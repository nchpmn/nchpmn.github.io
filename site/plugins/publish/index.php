<?php

namespace Nathan;

use Kirby\Cms\App as Kirby;

require_once __DIR__ . '/publisher.php';

function renderPublishResult(array $result): string
{
    $status = $result['ok'] ? 'Published' : 'Something went wrong';
    $color  = $result['ok'] ? '#2e7d32' : '#c62828';
    $rows   = implode("\n", array_map(
        fn($line) => '<li>' . htmlspecialchars($line) . '</li>',
        $result['log']
    ));

    return <<<HTML
    <!doctype html>
    <html>
    <head>
      <meta charset="utf-8">
      <title>{$status}</title>
      <style>
        body{font-family:-apple-system,Helvetica,Arial,sans-serif;max-width:640px;margin:4rem auto;padding:0 1.5rem;color:#111;}
        h1{color:{$color};}
        ul{background:#f4f4f4;padding:1rem 1.5rem;border-radius:6px;font-size:.9rem;line-height:1.6;}
        a{color:#111;}
      </style>
    </head>
    <body>
      <h1>{$status}</h1>
      <ul>{$rows}</ul>
      <p><a href="/panel/site">&larr; Back to Panel</a></p>
    </body>
    </html>
    HTML;
}

Kirby::plugin('nathan/publish', [
    'routes' => function (Kirby $kirby) {
        return [
            [
                'pattern' => 'publish',
                'method'  => 'GET',
                'action'  => function () use ($kirby) {
                    if (!$kirby->user()) {
                        go('panel/login');
                        return;
                    }

                    $publisher = new Publisher($kirby);
                    $result = $publisher->publish();

                    return new \Kirby\Http\Response(
                        renderPublishResult($result),
                        'text/html',
                        $result['ok'] ? 200 : 500
                    );
                }
            ]
        ];
    }
]);
