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
        Schema::create('listing_infos', function (Blueprint $table) {
            $table->id();

            // Relation (1 listing -> 1 listing_info)
            $table->foreignId('listing_id')
                ->constrained('listings')
                ->cascadeOnDelete()
                ->unique();

            // Core info
            $table->string('tagline')->nullable();
            $table->text('about')->nullable();

            // Contact extras
            $table->string('fax')->nullable();


            // Flexible collections (store as JSON arrays)
            $table->json('services')->nullable();        // ["Drain Cleaning","Sewer Repair",...]
            $table->json('social_profiles')->nullable(); // [{"platform":"facebook","url":"..."}, ...]
            $table->json('other_emails')->nullable();    // ["a@x.com","b@y.com"]
            $table->json('other_phones')->nullable();    // ["+1....","+880...."]
            $table->json('payment_methods')->nullable(); // ["Visa","MasterCard"]
            $table->json('accreditations')->nullable();  // ["BBB","Licensed","Insured"]

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listing_infos');
    }
};
