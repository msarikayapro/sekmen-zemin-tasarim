<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Tek satırlık tracking merkezi
    public function up(): void
    {
        Schema::create('pazarlama_ayarlari', function (Blueprint $table) {
            $table->id();
            $table->string('meta_pixel_id')->nullable();
            $table->boolean('meta_pixel_aktif')->default(false);
            $table->text('capi_token')->nullable(); // şifreli (encrypted cast)
            $table->string('capi_test_code')->nullable();
            $table->boolean('capi_aktif')->default(false);
            $table->string('ga4_id')->nullable();
            $table->string('gtm_id')->nullable();
            $table->string('google_ads_id')->nullable();
            $table->string('google_ads_label')->nullable();
            $table->string('search_console_meta')->nullable();
            $table->text('head_kod')->nullable();
            $table->text('body_kod')->nullable();
            $table->json('event_mapping')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pazarlama_ayarlari');
    }
};
