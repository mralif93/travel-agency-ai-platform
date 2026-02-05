<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vehicle extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'make',
        'model',
        'year',
        'license_plate',
        'capacity',
        'status',
        'price_multiplier',
    ];

    public function driver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
