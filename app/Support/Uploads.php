<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/** Small helper around the "public" disk (storage/app/public, linked to /storage). */
class Uploads
{
    public static function store(?UploadedFile $file, string $dir): ?string
    {
        return $file ? $file->store($dir, 'public') : null;
    }

    public static function delete(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    /** Replace an old file with a newly uploaded one (or keep the old one). */
    public static function replace(?UploadedFile $file, ?string $oldPath, string $dir): ?string
    {
        if (! $file) {
            return $oldPath;
        }
        self::delete($oldPath);

        return self::store($file, $dir);
    }
}
