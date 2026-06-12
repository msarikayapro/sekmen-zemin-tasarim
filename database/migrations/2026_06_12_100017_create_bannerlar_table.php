<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bannerlar', function (Blueprint $table) {
            $table->id();
            $table->string('gorsel');
            $table->string('baslik')->nullable();
            $table->string('alt_baslik')->nullable();
            $table->string('alt_metin')->nullable();
            $table->string('buton_yazi')->nullable();
            $table->string('link')->nullable();
            $table->unsignedInteger('sira')->default(0)->index();
            $table->enum('durum', ['yayin', 'gizli'])->default('yayin')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bannerlar');
    }
};
