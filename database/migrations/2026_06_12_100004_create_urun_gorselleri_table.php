<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('urun_gorselleri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('urun_id')->constrained('urunler')->cascadeOnDelete();
            $table->string('yol');
            $table->string('alt_metin')->nullable();
            $table->unsignedInteger('sira')->default(0);
            $table->timestamps();
            $table->index(['urun_id', 'sira']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('urun_gorselleri');
    }
};
