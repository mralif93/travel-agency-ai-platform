<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TourPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description',
        'price',
        'duration',
        'destination',
        'category',
        'featured_image',
        'gallery',
        'inclusions',
        'exclusions',
        'itinerary',
        'max_pax',
        'difficulty',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'gallery' => 'array',
        'inclusions' => 'array',
        'exclusions' => 'array',
        'itinerary' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name) . '-' . Str::random(6);
            }
        });
    }

    public function getFeaturedImageUrlAttribute()
    {
        if ($this->featured_image) {
            return asset('storage/' . $this->featured_image);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=4f46e5&color=fff&size=400';
    }

    public function getGalleryUrlsAttribute()
    {
        if (!$this->gallery) return [];
        return array_map(fn($path) => asset('storage/' . $path), $this->gallery);
    }

    public function getCategoryLabelAttribute()
    {
        return match($this->category) {
            'adventure' => 'Adventure',
            'cultural' => 'Cultural',
            'nature' => 'Nature',
            'beach' => 'Beach',
            'city' => 'City Tour',
            'culinary' => 'Culinary',
            default => ucfirst($this->category),
        };
    }

    public function getDifficultyLabelAttribute()
    {
        return match($this->difficulty) {
            'easy' => 'Easy',
            'moderate' => 'Moderate',
            'challenging' => 'Challenging',
            default => ucfirst($this->difficulty),
        };
    }

    public function getDifficultyColorAttribute()
    {
        return match($this->difficulty) {
            'easy' => 'green',
            'moderate' => 'yellow',
            'challenging' => 'red',
            default => 'gray',
        };
    }
}
