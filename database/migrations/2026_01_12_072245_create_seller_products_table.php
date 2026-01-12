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
        Schema::create('seller_products', function (Blueprint $table) {
            $table->id();

            // Seller scope
            $table->unsignedBigInteger('shop_id')->index();   // your shop id
            $table->unsignedBigInteger('seller_id')->index(); // auth user id

            // Core
            $table->string('name', 180);
            $table->string('slug', 220)->index();
            $table->string('sku', 80)->nullable()->index();

            // Pricing (BD)
            $table->decimal('price', 12, 2)->default(0);
            $table->decimal('compare_price', 12, 2)->nullable(); // old price
            $table->decimal('cost_price', 12, 2)->nullable();    // optional
            $table->string('currency', 10)->default('BDT');

            // Stock
            $table->integer('stock_qty')->default(0);
            $table->boolean('track_stock')->default(true);
            $table->boolean('allow_backorder')->default(false);

            // Content
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();

            // Flexible future fields
            $table->json('attributes')->nullable(); // ex: {"Color":["Red","Blue"],"Size":["M","L"]}
            $table->json('variants')->nullable();   // ex: variant combinations, prices, sku, stock
            $table->json('shipping')->nullable();   // ex: {"weight":1.2,"unit":"kg","inside_dhaka":80,"outside_dhaka":130}

            // Status
            $table->enum('status', ['draft', 'active', 'inactive'])->default('draft');

            // SEO (optional)
            $table->string('seo_title', 200)->nullable();
            $table->string('seo_description', 255)->nullable();

            $table->timestamps();

            // Prevent duplicates per shop
            $table->unique(['shop_id', 'slug']);
            $table->unique(['shop_id', 'sku']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_products');
    }
};
