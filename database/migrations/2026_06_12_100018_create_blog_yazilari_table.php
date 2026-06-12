<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Faz 2 — yapı baştan kuruluyor
    public function up(): void
    {
        Schema::create('blog_yazilari', function (Blueprint $table) {
            $table->id();
            $table->string('baslik');
            $table->string('slug')->unique();
            $table->text('ozet')->nullable();
            $table->longText('icerik')->nullable();
            $table->string('kapak')->nullable();
            $table->json('etiketler')->nullable();
            $table->string('kategori')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_desc')->nullable();
            $table->enum('durum', ['yayin', 'taslak'])->default('taslak')->index();
            $table->timestamp('yayin_tarihi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_yazilari');
    }
};
