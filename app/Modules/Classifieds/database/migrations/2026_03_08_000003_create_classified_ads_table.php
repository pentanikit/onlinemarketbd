<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('classified_ads', function (Blueprint $table) {
            $table->id();

            $table->foreignId('classified_ad_user_id')
                ->constrained('classified_ad_users')
                ->cascadeOnDelete();

            $table->foreignId('category_id')
                ->constrained('classified_categories')
                ->cascadeOnDelete();

            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('description')->nullable();

            $table->decimal('price', 12, 2)->nullable();
            $table->string('price_type')->default('fixed'); // fixed, negotiable, call
            $table->string('condition_type')->nullable(); // new, used

            $table->string('location')->nullable();

            $table->string('contact_name');
            $table->string('contact_email')->nullable();
            $table->string('contact_phone', 30);

            $table->string('status')->default('pending'); // pending, published, rejected, sold
            $table->timestamp('published_at')->nullable();
            $table->timestamp('expires_at')->nullable();

            $table->unsignedBigInteger('views_count')->default(0);

            $table->timestamps();

            $table->index(['category_id', 'status']);
            $table->index(['classified_ad_user_id', 'status']);
            $table->index(['status', 'published_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classified_ads');
    }
};