<?php

namespace App\Http\Controllers\Panel\Concerns;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait GorselYukle
{
    /** Tek görseli public diske yükler, göreli yolu döndürür. */
    protected function gorselKaydet(?UploadedFile $dosya, string $klasor, ?string $eski = null): ?string
    {
        if (! $dosya) {
            return $eski;
        }

        if ($eski) {
            Storage::disk('public')->delete($eski);
        }

        return $dosya->store($klasor, 'public');
    }

    protected function gorselSil(?string $yol): void
    {
        if ($yol) {
            Storage::disk('public')->delete($yol);
        }
    }
}
