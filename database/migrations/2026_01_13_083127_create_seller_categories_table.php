<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('seller_categories', function (Blueprint $table) {
            $table->id();

            // Multi-tenant fields (keep as index-only to avoid FK issues if your tables differ)
            $table->unsignedBigInteger('shop_id')->nullable()->index();
            $table->unsignedBigInteger('seller_id')->nullable()->index();

            // Parent-child (subcategory)
            $table->unsignedBigInteger('parent_id')->nullable()->index();

            $table->string('name');
            $table->string('slug')->index();

            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->boolean('is_active')->default(true)->index();

            $table->timestamps();

            // Self FK for parent category
            $table->foreign('parent_id')
                ->references('id')
                ->on('seller_categories')
                ->nullOnDelete();

            // Prevent duplicate slug inside same shop/seller scope
            $table->unique(['shop_id', 'seller_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seller_categories');
    }
};
