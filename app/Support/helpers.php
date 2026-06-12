<?php

use App\Models\Ayar;
use Illuminate\Support\Facades\Storage;

if (! function_exists('ayar')) {
    /** Genel ayar değeri (cache'li). */
    function ayar(string $anahtar, $varsayilan = null)
    {
        return Ayar::get($anahtar, $varsayilan);
    }
}

if (! function_exists('gorsel')) {
    /**
     * Yüklenen görsel için public URL döndürür; dosya yoksa zarif placeholder.
     * Kayıtlı yol "storage" diski (public) içindeki göreli yoldur.
     */
    function gorsel(?string $yol, ?string $placeholder = null): string
    {
        if ($yol) {
            // Tam URL ise olduğu gibi
            if (str_starts_with($yol, 'http://') || str_starts_with($yol, 'https://')) {
                return $yol;
            }
            if (Storage::disk('public')->exists($yol)) {
                return Storage::disk('public')->url($yol);
            }
            // public/ altında doğrudan duran dosya
            if (file_exists(public_path($yol))) {
                return asset($yol);
            }
        }

        return asset($placeholder ?? 'img/placeholder.svg');
    }
}

if (! function_exists('whatsapp_link')) {
    /** WhatsApp ön-doldurulmuş mesaj linki. */
    function whatsapp_link(?string $mesaj = null): string
    {
        $numara = preg_replace('/\D+/', '', (string) ayar('whatsapp', ''));
        $mesaj ??= ayar('whatsapp_mesaj', 'Merhaba, bilgi almak istiyorum.');

        return 'https://wa.me/' . $numara . '?text=' . rawurlencode($mesaj);
    }
}

if (! function_exists('tel_link')) {
    /** tel: linki için temizlenmiş numara. */
    function tel_link(?string $numara): string
    {
        return 'tel:' . preg_replace('/[^\d+]/', '', (string) $numara);
    }
}

if (! function_exists('slugify_tr')) {
    /** Türkçe karakterleri sadeleştirip slug üretir. */
    function slugify_tr(string $metin): string
    {
        $tr = ['ç','Ç','ğ','Ğ','ı','İ','ö','Ö','ş','Ş','ü','Ü'];
        $en = ['c','c','g','g','i','i','o','o','s','s','u','u'];
        $metin = str_replace($tr, $en, $metin);

        return \Illuminate\Support\Str::slug($metin);
    }
}
