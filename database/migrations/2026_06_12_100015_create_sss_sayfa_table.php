<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Sayfa-bazlı SSS görünürlüğü. Kayıt yoksa → SSS tüm sayfalarda görünür.
    public function up(): void
    {
        Schema::create('sss_sayfa', function (Blueprint $table) {
            $table->foreignId('sss_id')->constrained('sss')->cascadeOnDelete();
            $table->string('sayfa_anahtar'); // ana_sayfa, urun_detay, projeler, hakkimizda, iletisim, kvkk, cerez
            $table->primary(['sss_id', 'sayfa_anahtar']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sss_sayfa');
    }
};
