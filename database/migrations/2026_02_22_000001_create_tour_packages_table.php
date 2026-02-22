<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tour_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('short_description');
            $table->longText('description');
            $table->decimal('price', 10, 2);
            $table->string('duration');
            $table->string('destination');
            $table->enum('category', ['adventure', 'cultural', 'nature', 'beach', 'city', 'culinary'])->default('nature');
            $table->string('featured_image')->nullable();
            $table->json('gallery')->nullable();
            $table->json('inclusions')->nullable();
            $table->json('exclusions')->nullable();
            $table->json('itinerary')->nullable();
            $table->integer('max_pax')->default(10);
            $table->enum('difficulty', ['easy', 'moderate', 'challenging'])->default('easy');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tour_packages');
    }
};
