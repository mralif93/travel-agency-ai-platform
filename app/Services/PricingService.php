<?php

namespace App\Services;

use App\Models\PricingRule;

class PricingService
{
    /**
     * Calculate the total price based on distance and vehicle multiplier.
     * 
     * Formula:
     * 1. Get Base Price (Flagfall)
     * 2. Calculate Tier 1 Cost (Distance <= Limit)
     * 3. Calculate Tier 2 Cost (Distance > Limit)
     * 4. Apply Vehicle Multiplier
     * 
     * @param float $distanceKm
     * @param float $vehicleMultiplier
     * @return float
     */
    public function calculatePrice(float $distanceKm, float $vehicleMultiplier = 1.0): float
    {
        // Fetch active pricing rule (or default)
        $rule = PricingRule::where('is_active', true)->first();

        // Default fallback if no rule exists
        $basePrice = $rule ? $rule->base_price : 0;
        $tier1Rate = $rule ? $rule->tier_1_rate : 2.50; // Standard: RM 2.50
        $tier1Limit = $rule ? $rule->tier_1_limit : 60; // 60 km
        $tier2Rate = $rule ? $rule->tier_2_rate : 1.20; // Long distance: RM 1.20

        $distanceCost = 0;

        if ($distanceKm <= $tier1Limit) {
            // Entirely within Tier 1
            $distanceCost = $distanceKm * $tier1Rate;
        } else {
            // Split between Tier 1 and Tier 2
            $tier1Cost = $tier1Limit * $tier1Rate;
            $remainingKm = $distanceKm - $tier1Limit;
            $tier2Cost = $remainingKm * $tier2Rate;

            $distanceCost = $tier1Cost + $tier2Cost;
        }

        $subtotal = $basePrice + $distanceCost;

        // Final calculation with multiplier
        return round($subtotal * $vehicleMultiplier, 2);
    }
}
