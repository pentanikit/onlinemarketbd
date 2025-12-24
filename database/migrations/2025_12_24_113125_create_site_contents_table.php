<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('site_contents', function (Blueprint $table) {
            $table->id();

            // one row per page/area (we'll use 'home')
            $table->string('key')->unique(); // e.g. home

            // ABOUT
            $table->string('about_title')->nullable();
            $table->longText('about_body')->nullable();

            // MANAGE LISTING (with image + CTA)
            $table->string('manage_title')->nullable();
            $table->longText('manage_body')->nullable();
            $table->string('manage_cta_text')->nullable();
            $table->string('manage_cta_url')->nullable();
            $table->string('manage_phone')->nullable();
            $table->string('manage_image')->nullable(); // storage path

            // MISSION (with image)
            $table->string('mission_title')->nullable();
            $table->longText('mission_body')->nullable();
            $table->string('mission_image')->nullable(); // storage path

            // VISION (with image)
            $table->string('vision_title')->nullable();
            $table->longText('vision_body')->nullable();
            $table->string('vision_image')->nullable(); // storage path

            // for future expansion without new columns
            $table->json('meta')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_contents');
    }
};
