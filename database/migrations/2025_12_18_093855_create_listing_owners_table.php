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
        Schema::create('listing_owners', function (Blueprint $table) {
            $table->id();

            $table->foreignId('listing_id')
                  ->constrained('listings')
                  ->cascadeOnDelete();

            $table->string('owner_name', 255);
            $table->string('nid_number', 50);

            // File paths in storage
            $table->string('nid_front_path', 255);
            $table->string('nid_back_path', 255)->nullable();
            $table->string('trade_license_path', 255);
            $table->string('tax_document_path', 255)->nullable();

            // Status
            $table->string('verification_status', 20)->default('pending'); // pending, approved, rejected
            $table->timestamp('verified_at')->nullable();
            $table->text('review_notes')->nullable();

            // Terms
            $table->boolean('agreed_terms')->default(false);
            $table->timestamp('agreed_at')->nullable();

            $table->timestamps();

            $table->unique('listing_id', 'uq_owner_verification_listing');
            $table->index(['verification_status'], 'idx_owner_verification_status');
            $table->index(['nid_number'], 'idx_owner_verification_nid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listing_owners');
    }
};
