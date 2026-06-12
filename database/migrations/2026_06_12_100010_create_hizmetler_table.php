<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hizmetler', function (Blueprint $table) {
            $table->id();
            $table->string('ad');
            $table->string('slug')->unique();
            $table->string('ikon')->nullable(); // Material Symbols ikon adı
            $table->text('aciklama')->nullable();
            $table->string('gorsel')->nullable();
            $table->unsignedInteger('sira')->default(0)->index();
            $table->enum('durum', ['yayin', 'taslak'])->default('yayin')->index();
            $table->string('meta_title')->nullable();
            $table->string('meta_desc')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hizmetler');
    }
};
