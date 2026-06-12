<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('yorumlar', function (Blueprint $table) {
            $table->id();
            $table->string('ad');
            $table->string('unvan')->nullable(); // Villa Sahibi, Mimar, Müteahhit...
            $table->text('icerik');
            $table->unsignedTinyInteger('puan')->nullable();
            $table->string('gorsel')->nullable();
            $table->boolean('one_cikan')->default(false)->index();
            $table->enum('durum', ['yayin', 'gizli'])->default('yayin')->index();
            $table->unsignedInteger('sira')->default(0)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('yorumlar');
    }
};
