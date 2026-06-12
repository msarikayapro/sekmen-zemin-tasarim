<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projeler', function (Blueprint $table) {
            $table->id();
            $table->string('baslik');
            $table->string('slug')->unique();
            $table->enum('tip', ['konut', 'kamu', 'ticari', 'peyzaj'])->default('konut')->index();
            $table->string('konum')->nullable();
            $table->string('tarih')->nullable();
            $table->text('aciklama')->nullable();
            $table->string('kapak_gorsel')->nullable();
            $table->string('video_url')->nullable();
            $table->string('musteri_adi')->nullable();
            $table->text('musteri_yorumu')->nullable();
            $table->boolean('one_cikan')->default(false)->index();
            $table->unsignedInteger('sira')->default(0)->index();
            $table->enum('durum', ['yayin', 'taslak'])->default('yayin')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projeler');
    }
};
