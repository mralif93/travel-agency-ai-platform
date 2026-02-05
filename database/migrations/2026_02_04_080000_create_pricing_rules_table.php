<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pricing_rules', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name'); // e.g., "Standard Pricing"
            $table->decimal('base_price', 10, 2)->default(0); // Flagfall
            $table->decimal('tier_1_rate', 10, 2); // Rate per km for first tier
            $table->integer('tier_1_limit')->default(60); // Limit in km (e.g., 60)
            $table->decimal('tier_2_rate', 10, 2); // Rate per km for excess distance
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_rules');
    }
};
