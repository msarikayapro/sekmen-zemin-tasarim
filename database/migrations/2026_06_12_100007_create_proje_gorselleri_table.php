<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proje_gorselleri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proje_id')->constrained('projeler')->cascadeOnDelete();
            $table->string('yol');
            $table->string('alt_metin')->nullable();
            $table->unsignedInteger('sira')->default(0);
            $table->timestamps();
            $table->index(['proje_id', 'sira']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proje_gorselleri');
    }
};
