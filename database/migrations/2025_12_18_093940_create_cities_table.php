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
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('country_code', 2)->default('BD')->index(); // BD, US, CA...
            $table->string('state', 100)->nullable();                  // Division / State
            $table->string('name', 150);                               // Dhaka, Washington
            $table->string('slug', 180)->unique();
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();
            $table->timestamps();

            $table->index(['country_code', 'name'], 'idx_cities_country_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
