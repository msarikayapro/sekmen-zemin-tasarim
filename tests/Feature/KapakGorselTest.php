<?php

namespace Tests\Feature;

use App\Models\Urun;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class KapakGorselTest extends TestCase
{
    use RefreshDatabase;

    public function test_kapak_gorseli_guncellemede_degisir(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['rol' => 'admin', 'aktif' => true]);

        // 1) Kapaklı ürün oluştur
        $urun = Urun::create([
            'ad' => 'Test Parke',
            'slug' => 'test-parke',
            'durum' => 'yayin',
            'one_cikan_gorsel' => 'urunler/eski.jpg',
        ]);

        $this->assertSame('urunler/eski.jpg', $urun->one_cikan_gorsel);

        // 2) Yeni kapak yükleyerek güncelle
        $yeni = UploadedFile::fake()->image('yeni.jpg', 800, 600);

        $response = $this->actingAs($admin)
            ->put('/panel/urunler/' . $urun->slug, [
                'ad' => 'Test Parke',
                'slug' => 'test-parke',
                'durum' => 'yayin',
                'one_cikan_gorsel' => $yeni,
            ]);

        $response->assertSessionHasNoErrors();
        $urun->refresh();

        $this->assertNotSame('urunler/eski.jpg', $urun->one_cikan_gorsel, 'Kapak görseli güncellenmedi!');
        Storage::disk('public')->assertExists($urun->one_cikan_gorsel);
    }

    public function test_urun_duzenleme_sayfasi_render_olur(): void
    {
        $admin = User::factory()->create(['rol' => 'admin', 'aktif' => true]);

        $urun = Urun::create(['ad' => 'Render', 'slug' => 'render', 'durum' => 'yayin']);
        $urun->gorseller()->create(['yol' => 'urunler/galeri/x.jpg', 'sira' => 0]);

        $this->actingAs($admin)
            ->get('/panel/urunler/' . $urun->slug . '/edit')
            ->assertOk()
            ->assertSee('Galeri Görselleri');
    }

    public function test_galeri_surukle_birak_siralama(): void
    {
        $admin = User::factory()->create(['rol' => 'admin', 'aktif' => true]);

        $urun = Urun::create(['ad' => 'G', 'slug' => 'g', 'durum' => 'yayin']);
        $g1 = $urun->gorseller()->create(['yol' => 'urunler/galeri/a.jpg', 'sira' => 0]);
        $g2 = $urun->gorseller()->create(['yol' => 'urunler/galeri/b.jpg', 'sira' => 1]);
        $g3 = $urun->gorseller()->create(['yol' => 'urunler/galeri/c.jpg', 'sira' => 2]);

        // Yeni sıra: c, a, b
        $this->actingAs($admin)
            ->postJson('/panel/urunler/' . $urun->slug . '/galeri-sirala', [
                'sira' => [$g3->id, $g1->id, $g2->id],
            ])->assertOk()->assertJson(['ok' => true]);

        $this->assertSame(0, $g3->fresh()->sira);
        $this->assertSame(1, $g1->fresh()->sira);
        $this->assertSame(2, $g2->fresh()->sira);
    }
}
