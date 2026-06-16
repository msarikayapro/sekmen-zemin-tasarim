<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('showcases', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['image', 'video'])->default('image');
            $table->string('media_path');
            $table->string('thumbnail_path')->nullable(); // video için zorunlu kapak fotoğrafı
            $table->unsignedInteger('order')->default(0)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('showcases');
    }
};
