<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('talepler', function (Blueprint $table) {
            $table->id();
            $table->string('ad');
            $table->string('telefon');
            $table->string('email')->nullable();
            $table->string('il_ilce')->nullable();
            $table->string('ilgi_alani')->nullable();
            $table->foreignId('urun_id')->nullable()->constrained('urunler')->nullOnDelete();
            $table->string('m2')->nullable();
            $table->text('mesaj')->nullable();
            $table->string('foto')->nullable();
            $table->boolean('kvkk_onay')->default(false);
            $table->enum('durum', ['yeni', 'okundu', 'arandi', 'sonuclandi'])->default('yeni')->index();
            $table->string('kaynak')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('talepler');
    }
};
