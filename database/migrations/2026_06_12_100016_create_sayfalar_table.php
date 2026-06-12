<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Statik içerik / ana sayfa blokları (key-bazlı)
    public function up(): void
    {
        Schema::create('sayfalar', function (Blueprint $table) {
            $table->id();
            $table->string('anahtar')->unique(); // home, about, kvkk, cerez ...
            $table->string('baslik')->nullable();
            $table->json('bloklar')->nullable();
            $table->longText('icerik')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_desc')->nullable();
            $table->string('og_image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sayfalar');
    }
};
