<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    public function viewAny($user): bool
    {
        if ($user instanceof User) {
            return in_array($user->role, ['superadmin', 'admin', 'driver', 'company']);
        }
        return true;
    }

    public function view($user, Order $order): bool
    {
        if ($user instanceof User) {
            if (in_array($user->role, ['superadmin', 'admin'])) {
                return true;
            }
            if ($user->role === 'driver') {
                return $order->vehicle?->user_id === $user->id;
            }
            if ($user->role === 'company') {
                return $order->vehicle?->driver?->company_id === $user->company_id;
            }
        }
        if ($user instanceof Customer) {
            return $order->customer_id === $user->id;
        }
        return false;
    }

    public function create($user): bool
    {
        return true;
    }

    public function update($user, Order $order): bool
    {
        if ($user instanceof User) {
            return in_array($user->role, ['superadmin', 'admin']);
        }
        return false;
    }

    public function updateStatus($user, Order $order): bool
    {
        if ($user instanceof User) {
            if (in_array($user->role, ['superadmin', 'admin'])) {
                return true;
            }
            if ($user->role === 'driver') {
                return $order->vehicle?->user_id === $user->id;
            }
        }
        return false;
    }

    public function delete($user, Order $order): bool
    {
        if ($user instanceof User) {
            return in_array($user->role, ['superadmin', 'admin']);
        }
        return false;
    }

    public function complete($user, Order $order): bool
    {
        if ($user instanceof User && $user->role === 'driver') {
            return $order->vehicle?->user_id === $user->id;
        }
        return false;
    }

    public function downloadInvoice($user, Order $order): bool
    {
        return $this->view($user, $order);
    }
}
