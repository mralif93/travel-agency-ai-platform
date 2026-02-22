<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attractions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('short_description');
            $table->longText('description');
            $table->string('location');
            $table->text('address')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->decimal('entrance_fee', 10, 2)->default(0);
            $table->json('opening_hours')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('website')->nullable();
            $table->enum('category', ['temple', 'beach', 'mountain', 'park', 'museum', 'island', 'waterfall', 'cave'])->default('park');
            $table->string('featured_image')->nullable();
            $table->json('gallery')->nullable();
            $table->decimal('rating', 3, 2)->default(0);
            $table->integer('reviews_count')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('attraction_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attraction_id')->constrained()->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->tinyInteger('rating')->unsigned();
            $table->text('comment')->nullable();
            $table->boolean('is_approved')->default(true);
            $table->timestamps();
            
            $table->unique(['attraction_id', 'customer_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attraction_reviews');
        Schema::dropIfExists('attractions');
    }
};
