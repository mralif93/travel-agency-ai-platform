<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['superadmin', 'admin', 'company']);
    }

    public function view(User $user, User $model): bool
    {
        if ($user->role === 'superadmin') {
            return true;
        }
        if ($user->role === 'admin') {
            return $model->role !== 'superadmin';
        }
        if ($user->role === 'company') {
            return $model->company_id === $user->company_id;
        }
        return $user->id === $model->id;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['superadmin', 'admin', 'company']);
    }

    public function update(User $user, User $model): bool
    {
        if ($user->role === 'superadmin') {
            return true;
        }
        if ($user->role === 'admin') {
            return $model->role !== 'superadmin';
        }
        if ($user->role === 'company') {
            return $model->company_id === $user->company_id;
        }
        return $user->id === $model->id;
    }

    public function delete(User $user, User $model): bool
    {
        if ($user->id === $model->id) {
            return false;
        }
        if ($user->role === 'superadmin') {
            return true;
        }
        if ($user->role === 'admin') {
            return !in_array($model->role, ['superadmin', 'admin']);
        }
        return false;
    }

    public function resetPassword(User $user, User $model): bool
    {
        return in_array($user->role, ['superadmin', 'admin']);
    }
}
