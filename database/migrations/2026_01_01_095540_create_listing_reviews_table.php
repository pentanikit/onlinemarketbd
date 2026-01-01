<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listing_reviews', function (Blueprint $table) {
            $table->id();

            $table->foreignId('listing_id')
                ->constrained('listings')
                ->cascadeOnDelete();

            $table->string('name', 120);                 // guest name
            $table->unsignedTinyInteger('rating');       // 1..5
            $table->text('comment');

            // Moderation / safety
            $table->string('status', 20)->default('pending'); // pending|approved|rejected
            $table->timestamp('approved_at')->nullable();

            // Optional spam controls (recommended)
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 255)->nullable();

            $table->timestamps();

            $table->index(['listing_id', 'status']);
            $table->index(['listing_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listing_reviews');
    }
};
