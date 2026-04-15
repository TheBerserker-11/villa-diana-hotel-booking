<?php

namespace App\Support;

use Illuminate\Support\Str;

final class MediaUrl
{
    public static function publicDisk(?string $path): string
    {
        $path = trim((string) $path);

        if ($path === '') {
            return '';
        }

        if (filter_var($path, FILTER_VALIDATE_URL) || Str::startsWith($path, ['//', 'data:'])) {
            return $path;
        }

        return route('media.show', ['path' => ltrim($path, '/\\')]);
    }
}
