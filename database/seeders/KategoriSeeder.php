<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoriler = [
            [
                'ad' => 'Parke Taşları',
                'slug' => 'parke-taslari',
                'aciklama_seo' => 'Klasik ve modern döşeme modelleriyle yaya yolu, araç yolu ve bahçeleriniz için dayanıklı kilit parke taşı çeşitleri.',
                'sira' => 1,
            ],
            [
                'ad' => 'Çevre & Tamamlayıcı Elemanlar',
                'slug' => 'cevre-tamamlayici-elemanlar',
                'aciklama_seo' => 'Bordür, yağmur oluğu, merdiven ve kent mobilyaları ile projelerinizi çerçeveleyen tamamlayıcı beton elemanlar.',
                'sira' => 2,
            ],
        ];

        foreach ($kategoriler as $k) {
            Kategori::updateOrCreate(['slug' => $k['slug']], $k);
        }
    }
}
