<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['superadmin', 'admin']);
    }

    public function view(User $user, Company $company): bool
    {
        if ($user->role === 'superadmin' || $user->role === 'admin') {
            return true;
        }
        if ($user->role === 'company') {
            return $user->company_id === $company->id;
        }
        return false;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['superadmin', 'admin']);
    }

    public function update(User $user, Company $company): bool
    {
        if ($user->role === 'superadmin' || $user->role === 'admin') {
            return true;
        }
        if ($user->role === 'company') {
            return $user->company_id === $company->id;
        }
        return false;
    }

    public function delete(User $user, Company $company): bool
    {
        return $user->role === 'superadmin';
    }
}
