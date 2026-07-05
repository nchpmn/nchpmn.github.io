<?php

namespace Nathan;

use Kirby\Cms\App;

class Publisher
{
    protected App $kirby;

    public function __construct(App $kirby)
    {
        $this->kirby = $kirby;
    }

    /**
     * Runs the full pipeline: regenerate static export, then commit and
     * push it. Returns a structured result - never throws, so the route
     * can always render a clear result page either way.
     */
    public function publish(): array
    {
        $log = [];

        $outputFolder = $this->kirby->option('jr.static_site_generator.output_folder', './static');
        $outputFolderAbs = realpath($this->kirby->root('index') . '/' . $outputFolder) ?: null;

        // First-ever run against a freshly git-cloned (non-empty) folder:
        // the generator refuses to touch a non-empty folder unless it
        // already has this marker. Since we know this folder is meant to
        // be the export target (it's what's configured), it's safe to
        // create it ourselves rather than making this a manual setup step.
        if ($outputFolderAbs && is_dir($outputFolderAbs) && !file_exists($outputFolderAbs . '/.kirbystatic')) {
            file_put_contents($outputFolderAbs . '/.kirbystatic', '');
            $log[] = 'First run against this folder - created .kirbystatic marker.';
        }

        try {
            $files = \JR\StaticSiteGenerator::generateFromConfig($this->kirby);
            $log[] = count($files) . ' file(s) generated.';
        } catch (\Throwable $e) {
            return $this->failure('Static export failed: ' . $e->getMessage(), $log);
        }

        $outputFolder = realpath($outputFolderAbs ?: ($this->kirby->root('index') . '/' . $outputFolder)) ?: $outputFolder;

        if (!is_dir($outputFolder . '/.git')) {
            return $this->failure(
                "The output folder ($outputFolder) isn't a git repository yet. " .
                "On the homelab, cd into it and run: git init, git remote add origin <your-pages-repo-url>, " .
                "then git checkout -b main and make an initial commit/push manually once, before using this button.",
                $log
            );
        }

        [$code, $out] = $this->run('git add -A', $outputFolder);
        if ($code !== 0) {
            return $this->failure("git add failed:\n$out", $log);
        }

        [$diffCode] = $this->run('git diff --cached --quiet', $outputFolder);
        if ($diffCode === 0) {
            $log[] = 'No changes to publish - the live site already matches this content.';
            return $this->success($log);
        }

        $message = 'Publish from Panel: ' . date('Y-m-d H:i:s');
        [$commitCode, $commitOut] = $this->run('git commit -m ' . escapeshellarg($message), $outputFolder);
        if ($commitCode !== 0) {
            return $this->failure("git commit failed:\n$commitOut", $log);
        }
        $log[] = 'Committed: ' . $message;

        [$pushCode, $pushOut] = $this->run('git push', $outputFolder);
        if ($pushCode !== 0) {
            return $this->failure("git push failed:\n$pushOut", $log);
        }
        $log[] = 'Pushed to remote.';
        $log[] = trim($pushOut);

        return $this->success($log);
    }

    protected function run(string $command, string $cwd): array
    {
        $descriptors = [
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ];
        $process = proc_open($command, $descriptors, $pipes, $cwd);
        if (!is_resource($process)) {
            return [1, "Could not start process: $command"];
        }
        $stdout = stream_get_contents($pipes[1]);
        $stderr = stream_get_contents($pipes[2]);
        fclose($pipes[1]);
        fclose($pipes[2]);
        $code = proc_close($process);
        return [$code, trim($stdout . "\n" . $stderr)];
    }

    protected function success(array $log): array
    {
        return ['ok' => true, 'log' => $log];
    }

    protected function failure(string $message, array $log): array
    {
        $log[] = 'ERROR: ' . $message;
        return ['ok' => false, 'log' => $log];
    }
}
