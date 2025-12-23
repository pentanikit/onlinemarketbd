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
        Schema::create('listings', function (Blueprint $table) {
            $table->id();

            // Which user owns this listing (after claim)
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained()
                  ->nullOnDelete();

            // Main category and city
            $table->foreignId('category_id')
                  ->nullable()
                  ->constrained('categories')
                  ->nullOnDelete();

            $table->foreignId('city_id')
                  ->nullable()
                  ->constrained('cities')
                  ->nullOnDelete();

            // Core info
            $table->string('name', 255);
            $table->string('slug', 255)->unique();
            $table->string('type', 50)->default('business'); // restaurant, hotel, shop, etc.
            $table->string('tagline', 255)->nullable();

            $table->text('description')->nullable();

            $table->string('email', 255)->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('website', 255)->nullable();

            // Price level & highlights
            $table->unsignedTinyInteger('price_level')->nullable(); // 1=$,2=$$,3=$$$,4=$$$$
            $table->text('highlights')->nullable(); // raw text; you can parse into amenities later

            // Geo / map
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();

            // Status & flags
            $table->boolean('is_claimed')->default(false);
            $table->string('status', 20)->default('pending'); // pending, active, rejected, disabled

            // Cached review stats
            $table->unsignedInteger('avg_rating')->default(0);      // 0.0–5.0
            $table->unsignedInteger('review_count')->default(0);

            // Extra flexible config
            $table->json('meta')->nullable();

            $table->timestamps();

            // Indices for fast search
            $table->index(['city_id', 'category_id', 'status'], 'idx_listings_city_cat_status');
            $table->index(['type', 'status'], 'idx_listings_type_status');
            $table->index('created_at', 'idx_listings_created_at');

            // Fulltext search on name + description
            $table->fullText(['name', 'description'], 'ft_listings_name_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
