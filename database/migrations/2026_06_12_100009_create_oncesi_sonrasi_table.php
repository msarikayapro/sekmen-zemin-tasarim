<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('oncesi_sonrasi', function (Blueprint $table) {
            $table->id();
            $table->string('baslik')->nullable();
            $table->string('oncesi_gorsel');
            $table->string('sonrasi_gorsel');
            $table->foreignId('proje_id')->nullable()->constrained('projeler')->nullOnDelete();
            $table->unsignedInteger('sira')->default(0)->index();
            $table->enum('durum', ['yayin', 'gizli'])->default('yayin')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('oncesi_sonrasi');
    }
};
