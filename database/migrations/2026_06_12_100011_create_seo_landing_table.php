<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seo_landing', function (Blueprint $table) {
            $table->id();
            $table->string('baslik_h1');
            $table->string('slug')->unique();
            $table->string('sehir')->nullable();
            $table->string('urun_tipi')->nullable();
            $table->longText('icerik')->nullable();
            $table->json('gorseller')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_desc')->nullable();
            $table->enum('durum', ['yayin', 'taslak'])->default('yayin')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_landing');
    }
};
