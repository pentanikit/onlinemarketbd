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
        Schema::create('listing_addresses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('listing_id')
                  ->constrained('listings')
                  ->cascadeOnDelete();

            // Redundant but practical: country+city text for quick display
            $table->string('country_code', 2)->default('BD');
            $table->foreignId('city_id')
                  ->nullable()
                  ->constrained('cities')
                  ->nullOnDelete();

            $table->string('city_name', 150);      // e.g. "Dhaka"
            $table->string('area', 150)->nullable();  // thana: "Mirpur, Gulshan"

            $table->string('line1', 255);
            $table->string('line2', 255)->nullable();
            $table->string('postal_code', 20)->nullable();

            $table->timestamps();

            $table->unique('listing_id', 'uq_listing_address_listing'); // one main address per listing
            $table->index(['country_code', 'city_name'], 'idx_address_country_city_text');
            $table->index(['city_id'], 'idx_address_city_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listing_addresses');
    }
};
