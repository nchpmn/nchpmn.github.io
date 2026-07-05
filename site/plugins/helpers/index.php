<?php

/**
 * Very small helpers for turning a plain Vimeo/YouTube URL into an
 * embeddable iframe src. Rough/functional only - revisit during the
 * visual design pass (this is what needs to become a true full-bleed,
 * chrome-free background video on the Tidbits homepage).
 */

function embedVideoId(string $url): array
{
    if (preg_match('#vimeo\.com/(\d+)#', $url, $m)) {
        return ['provider' => 'vimeo', 'id' => $m[1]];
    }
    if (preg_match('#(?:youtu\.be/|youtube\.com/(?:watch\?v=|embed/))([\w-]{11})#', $url, $m)) {
        return ['provider' => 'youtube', 'id' => $m[1]];
    }
    return ['provider' => null, 'id' => null];
}

/** Normal embed - used for a single portfolio item's featured video. */
function embedUrl(string $url): string
{
    $video = embedVideoId($url);

    if ($video['provider'] === 'vimeo') {
        return 'https://player.vimeo.com/video/' . $video['id'];
    }
    if ($video['provider'] === 'youtube') {
        return 'https://www.youtube.com/embed/' . $video['id'];
    }
    return $url;
}

/** Autoplay/loop/muted, chrome-free - used for the Tidbits homepage showreel. */
function embedBackgroundUrl(string $url): string
{
    $video = embedVideoId($url);

    if ($video['provider'] === 'vimeo') {
        return 'https://player.vimeo.com/video/' . $video['id']
            . '?background=1&autoplay=1&loop=1&muted=1&byline=0&title=0&portrait=0';
    }
    if ($video['provider'] === 'youtube') {
        return 'https://www.youtube.com/embed/' . $video['id']
            . '?autoplay=1&mute=1&loop=1&controls=0&playlist=' . $video['id']
            . '&modestbranding=1&playsinline=1';
    }
    return $url;
}
