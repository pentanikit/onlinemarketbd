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
        Schema::create('shops', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('name');
            $table->string('category')->index();
            $table->string('slug')->unique(); // shop url slug
            $table->string('support_phone', 20)->nullable();

            $table->text('description')->nullable();

            $table->string('logo_path')->nullable();
            $table->string('banner_path')->nullable();

            $table->string('status')->default('pending')->index(); // pending|active|suspended
            $table->timestamp('onboarded_at')->nullable();

            $table->timestamps();

            $table->unique(['user_id']); // one shop per user (remove if you want multiple shops)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shops');
    }
};
