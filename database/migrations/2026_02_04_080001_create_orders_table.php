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
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignIdFor(\App\Models\Customer::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(\App\Models\Vehicle::class)->nullable()->constrained()->nullOnDelete();

            // Location Details
            $table->text('pickup_address');
            $table->decimal('pickup_latitude', 10, 8)->nullable();
            $table->decimal('pickup_longitude', 11, 8)->nullable();

            $table->text('dropoff_address');
            $table->decimal('dropoff_latitude', 10, 8)->nullable();
            $table->decimal('dropoff_longitude', 11, 8)->nullable();

            // Trip Details
            $table->decimal('distance_km', 8, 2);
            $table->decimal('vehicle_multiplier', 4, 2)->default(1.0);
            $table->decimal('total_price', 10, 2);

            $table->string('status')->default('pending'); // pending, confirmed, completed, cancelled
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
