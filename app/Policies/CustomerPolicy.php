<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomerPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['superadmin', 'admin']);
    }

    public function view(User $user, Customer $customer): bool
    {
        return in_array($user->role, ['superadmin', 'admin']);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['superadmin', 'admin']);
    }

    public function update(User $user, Customer $customer): bool
    {
        return in_array($user->role, ['superadmin', 'admin']);
    }

    public function delete(User $user, Customer $customer): bool
    {
        return $user->role === 'superadmin';
    }

    public function resetPassword(User $user, Customer $customer): bool
    {
        return in_array($user->role, ['superadmin', 'admin']);
    }
}
