<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttractionReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'attraction_id',
        'customer_id',
        'rating',
        'comment',
        'is_approved',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    public function attraction()
    {
        return $this->belongsTo(Attraction::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    protected static function boot()
    {
        parent::boot();
        
        static::created(function ($review) {
            $review->attraction->updateRating();
        });
        
        static::updated(function ($review) {
            $review->attraction->updateRating();
        });
        
        static::deleted(function ($review) {
            $review->attraction->updateRating();
        });
    }
}
