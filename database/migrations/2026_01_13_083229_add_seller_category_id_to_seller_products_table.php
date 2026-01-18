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
        Schema::table('seller_products', function (Blueprint $table) {
            if (!Schema::hasColumn('seller_products', 'seller_category_id')) {
                $table->unsignedBigInteger('seller_category_id')->nullable()->index()->after('seller_id');

                $table->foreign('seller_category_id')
                    ->references('id')
                    ->on('seller_categories')
                    ->nullOnDelete();
            }
        });
    }


    public function down(): void
    {
        Schema::table('seller_products', function (Blueprint $table) {
            if (Schema::hasColumn('seller_products', 'seller_category_id')) {
                $table->dropForeign(['seller_category_id']);
                $table->dropColumn('seller_category_id');
            }
        });
    }
};
