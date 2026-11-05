<?php

namespace App\Support;

final class InvitationVideo
{
    /**
     * Return a trustworthy, fixed-domain video embed URL.
     * User input is never used directly as an iframe src.
     */
    public static function embed(?string $input): ?string
    {
        if (!$input || !filter_var($input, FILTER_VALIDATE_URL)) return null;
        $parts = parse_url(trim($input));
        if (!is_array($parts) || strtolower($parts['scheme'] ?? '') !== 'https') return null;
        $host = strtolower($parts['host'] ?? '');
        $host = preg_replace('/^www\./', '', $host);
        $path = trim($parts['path'] ?? '', '/');

        if (in_array($host, ['youtube.com', 'm.youtube.com', 'youtu.be', 'youtube-nocookie.com'], true)) {
            parse_str($parts['query'] ?? '', $query);
            $id = $host === 'youtu.be' ? explode('/', $path)[0]
                : ($query['v'] ?? (preg_match('~^(?:embed|shorts)/([a-zA-Z0-9_-]{11})$~', $path, $m) ? $m[1] : ''));
            return is_string($id) && preg_match('/^[a-zA-Z0-9_-]{11}$/D', $id)
                ? 'https://www.youtube-nocookie.com/embed/' . $id : null;
        }

        if (in_array($host, ['vimeo.com', 'player.vimeo.com'], true)) {
            $id = preg_match('~(?:^|/)video/(\d{6,12})$|^(\d{6,12})$~', $path, $m)
                ? ($m[1] ?: ($m[2] ?? '')) : null;
            return $id ? 'https://player.vimeo.com/video/' . $id : null;
        }
        return null;
    }
}
