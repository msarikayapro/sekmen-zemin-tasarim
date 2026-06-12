<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            AyarSeeder::class,
            KategoriSeeder::class,
            UrunSeeder::class,
            HizmetSeeder::class,
            ProjeSeeder::class,
            OncesiSonrasiSeeder::class,
            YorumSeeder::class,
            SssSeeder::class,
            BannerSeeder::class,
            SayfaSeeder::class,
            SeoLandingSeeder::class,
            YonlendirmeSeeder::class,
        ]);
    }
}
