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
        Schema::create('listing_hours', function (Blueprint $table) {
            $table->id();

            $table->foreignId('listing_id')
                  ->constrained('listings')
                  ->cascadeOnDelete();

            $table->unsignedTinyInteger('day_of_week'); // 0=Sun ... 6=Sat

            $table->time('opens_at')->nullable();
            $table->time('closes_at')->nullable();

            $table->boolean('is_closed')->default(false);
            $table->boolean('is_24_hours')->default(false);

            $table->timestamps();

            $table->unique(['listing_id', 'day_of_week'], 'uq_listing_hours_listing_day');
            $table->index(['listing_id', 'day_of_week'], 'idx_listing_hours_listing_day');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listing_hours');
    }
};
