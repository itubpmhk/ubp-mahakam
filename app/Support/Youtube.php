<?php

namespace App\Support;

class Youtube
{
    /**
     * Extract the 11-character video id from any common YouTube URL
     * (watch?v=, youtu.be/, /embed/, /shorts/, /live/) or from a bare id.
     */
    public static function id(?string $input): ?string
    {
        $input = trim((string) $input);
        if ($input === '') {
            return null;
        }
        if (preg_match('/^[A-Za-z0-9_-]{11}$/', $input)) {
            return $input;
        }
        $pattern = '~(?:youtube(?:-nocookie)?\.com/(?:watch\?(?:.*&)?v=|embed/|shorts/|live/|v/)|youtu\.be/)([A-Za-z0-9_-]{11})~i';

        return preg_match($pattern, $input, $m) ? $m[1] : null;
    }

    public static function thumbnail(?string $id): ?string
    {
        return $id ? "https://i.ytimg.com/vi/{$id}/hqdefault.jpg" : null;
    }
}
