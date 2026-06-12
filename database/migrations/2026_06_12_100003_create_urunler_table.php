<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('urunler', function (Blueprint $table) {
            $table->id();
            $table->string('ad');
            $table->string('slug')->unique();
            $table->text('aciklama')->nullable();
            // Teknik özellikler
            $table->string('ebat_en')->nullable();
            $table->string('ebat_boy')->nullable();
            $table->string('kalinlik')->nullable();
            $table->string('m2_adet')->nullable();
            $table->string('palet_bilgi')->nullable();
            $table->json('renk_secenekleri')->nullable();
            $table->json('kullanim_alanlari')->nullable();
            $table->string('dayanim')->nullable();
            $table->string('don_direnci')->nullable();
            $table->string('video_url')->nullable();
            $table->string('one_cikan_gorsel')->nullable();
            $table->boolean('one_cikan')->default(false)->index();
            $table->unsignedInteger('sira')->default(0)->index();
            $table->enum('durum', ['yayin', 'taslak'])->default('yayin')->index();
            // SEO
            $table->string('meta_title')->nullable();
            $table->string('meta_desc')->nullable();
            $table->string('og_image')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('urunler');
    }
};
