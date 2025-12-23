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
        Schema::create('listing_photos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('listing_id')
                  ->constrained('listings')
                  ->cascadeOnDelete();

            $table->string('path', 255);          // storage path or URL
            $table->string('alt_text', 255)->nullable();

            $table->boolean('is_primary')->default(false);
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();

            $table->index(['listing_id', 'is_primary', 'sort_order'], 'idx_listing_photos_main');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listing_photos');
    }
};
