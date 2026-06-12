<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proje_urun', function (Blueprint $table) {
            $table->foreignId('proje_id')->constrained('projeler')->cascadeOnDelete();
            $table->foreignId('urun_id')->constrained('urunler')->cascadeOnDelete();
            $table->primary(['proje_id', 'urun_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proje_urun');
    }
};
