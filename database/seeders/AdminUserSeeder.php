<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@sekmenzemintasarim.com'],
            [
                'name' => 'Sekmen Yönetici',
                'password' => Hash::make('Sekmen2026!'),
                'rol' => 'admin',
                'telefon' => '0533 607 89 76',
                'aktif' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'editor@sekmenzemintasarim.com'],
            [
                'name' => 'İçerik Editörü',
                'password' => Hash::make('Editor2026!'),
                'rol' => 'editor',
                'aktif' => true,
            ]
        );
    }
}
