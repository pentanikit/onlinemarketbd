<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('classified_ad_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classified_ad_id')
                ->constrained('classified_ads')
                ->cascadeOnDelete();
            $table->string('image_path');
            $table->boolean('is_primary')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['classified_ad_id', 'is_primary']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classified_ad_images');
    }
};