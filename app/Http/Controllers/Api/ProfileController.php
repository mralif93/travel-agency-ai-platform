<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        return response()->json([
            'customer' => $customer,
        ]);
    }

    public function update(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'phone' => 'sometimes|string|max:20',
            'address' => 'sometimes|string|max:500',
            'current_password' => 'required_with:password|string',
            'password' => ['sometimes', 'confirmed', Password::defaults()],
        ]);

        if (isset($validated['current_password'])) {
            if (!Hash::check($validated['current_password'], $customer->password)) {
                return response()->json([
                    'message' => 'Current password is incorrect',
                ], 422);
            }
            $validated['password'] = Hash::make($validated['password']);
            unset($validated['current_password']);
        }

        if ($customer instanceof Customer) {
            $customer->update($validated);
        }

        return response()->json([
            'message' => 'Profile updated successfully',
            'customer' => $customer->fresh(),
        ]);
    }
}
