<?php

namespace App\Policies;

use App\Models\Vehicle;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class VehiclePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Vehicle $vehicle): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['superadmin', 'admin', 'company']);
    }

    public function update(User $user, Vehicle $vehicle): bool
    {
        if ($user->role === 'superadmin' || $user->role === 'admin') {
            return true;
        }
        if ($user->role === 'company') {
            return $vehicle->driver?->company_id === $user->company_id;
        }
        if ($user->role === 'driver') {
            return $vehicle->user_id === $user->id;
        }
        return false;
    }

    public function delete(User $user, Vehicle $vehicle): bool
    {
        return in_array($user->role, ['superadmin', 'admin']);
    }

    public function assign(User $user, Vehicle $vehicle): bool
    {
        return in_array($user->role, ['superadmin', 'admin', 'company']);
    }
}
