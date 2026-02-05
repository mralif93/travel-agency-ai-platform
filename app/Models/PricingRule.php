<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingRule extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'base_price',
        'tier_1_rate',
        'tier_1_limit',
        'tier_2_rate',
        'is_active',
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'tier_1_rate' => 'decimal:2',
        'tier_2_rate' => 'decimal:2',
        'is_active' => 'boolean',
    ];
}
