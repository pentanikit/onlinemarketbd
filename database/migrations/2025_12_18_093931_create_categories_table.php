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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()
                  ->constrained('categories')
                  ->cascadeOnDelete();
            $table->string('name', 150);           // Restaurants, Hotels, etc.
            $table->string('slug', 180)->unique();
            $table->string('icon_class', 100)->nullable(); // e.g. fa-solid fa-utensils
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['parent_id', 'sort_order'], 'idx_categories_parent_sort');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
