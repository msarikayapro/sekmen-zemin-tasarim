<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // 301 yönlendirme haritası (eski sekmenyapi.com → yeni)
    public function up(): void
    {
        Schema::create('yonlendirmeler', function (Blueprint $table) {
            $table->id();
            $table->string('eski_url')->index();
            $table->string('yeni_url');
            $table->unsignedSmallInteger('tip')->default(301);
            $table->boolean('aktif')->default(true)->index();
            $table->unsignedInteger('vurus')->default(0); // kaç kez tetiklendi
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('yonlendirmeler');
    }
};
