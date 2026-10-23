<?php

namespace App\Support;

use Illuminate\Support\HtmlString;

class Text
{
    /**
     * Escape a heading and turn *words* into a coloured highlight:
     * "Menjaga terang *Benua Etam*, setiap hari." -> ... <span class="hl">Benua Etam</span> ...
     */
    public static function highlight(?string $text): HtmlString
    {
        $safe = e((string) $text);

        return new HtmlString(preg_replace('/\*(.+?)\*/u', '<span class="hl">$1</span>', $safe));
    }

    /** Split a comma separated setting into a clean list. */
    public static function list(?string $text): array
    {
        return array_values(array_filter(array_map('trim', explode(',', (string) $text)), fn ($v) => $v !== ''));
    }

    /** One item per line (empty lines ignored). */
    public static function lines(?string $text): array
    {
        return array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', (string) $text)), fn ($v) => $v !== ''));
    }

    /** Lines written as "left | right" -> [[left, right], ...]. */
    public static function pairs(?string $text): array
    {
        return array_map(function ($line) {
            $parts = array_map('trim', explode('|', $line, 2));

            return [$parts[0], $parts[1] ?? ''];
        }, self::lines($text));
    }

    /** Paragraphs separated by a blank line. */
    public static function paragraphs(?string $text): array
    {
        return array_values(array_filter(array_map('trim', preg_split('/(\r?\n){2,}/', (string) $text)), fn ($v) => $v !== ''));
    }

    /** Only allow http(s) URLs to be printed into href attributes. */
    public static function safeUrl(?string $url): ?string
    {
        $url = trim((string) $url);

        return preg_match('~^https?://~i', $url) ? $url : null;
    }
}
