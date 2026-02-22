<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Attraction extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description',
        'location',
        'address',
        'latitude',
        'longitude',
        'entrance_fee',
        'opening_hours',
        'contact_number',
        'website',
        'category',
        'featured_image',
        'gallery',
        'rating',
        'reviews_count',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'entrance_fee' => 'decimal:2',
        'opening_hours' => 'array',
        'gallery' => 'array',
        'rating' => 'decimal:2',
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

    public function reviews()
    {
        return $this->hasMany(AttractionReview::class);
    }

    public function approvedReviews()
    {
        return $this->reviews()->where('is_approved', true)->latest();
    }

    public function getFeaturedImageUrlAttribute()
    {
        if ($this->featured_image) {
            return asset('storage/' . $this->featured_image);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=059669&color=fff&size=400';
    }

    public function getGalleryUrlsAttribute()
    {
        if (!$this->gallery) return [];
        return array_map(fn($path) => asset('storage/' . $path), $this->gallery);
    }

    public function getCategoryLabelAttribute()
    {
        return match($this->category) {
            'temple' => 'Temple',
            'beach' => 'Beach',
            'mountain' => 'Mountain',
            'park' => 'Park',
            'museum' => 'Museum',
            'island' => 'Island',
            'waterfall' => 'Waterfall',
            'cave' => 'Cave',
            default => ucfirst($this->category),
        };
    }

    public function getFormattedOpeningHoursAttribute()
    {
        if (!$this->opening_hours) return null;
        
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        $result = [];
        
        foreach ($days as $day) {
            if (isset($this->opening_hours[$day])) {
                $result[ucfirst($day)] = $this->opening_hours[$day];
            }
        }
        
        return $result;
    }

    public function updateRating()
    {
        $avgRating = $this->approvedReviews()->avg('rating') ?? 0;
        $count = $this->approvedReviews()->count();
        
        $this->update([
            'rating' => round($avgRating, 2),
            'reviews_count' => $count,
        ]);
    }
}
