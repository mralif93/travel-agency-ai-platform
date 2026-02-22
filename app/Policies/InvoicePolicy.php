<?php

namespace App\Policies;

use App\Models\Invoice;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvoicePolicy
{
    use HandlesAuthorization;

    public function viewAny($user): bool
    {
        if ($user instanceof User) {
            return in_array($user->role, ['superadmin', 'admin', 'company']);
        }
        return false;
    }

    public function view($user, Invoice $invoice): bool
    {
        if ($user instanceof User) {
            if (in_array($user->role, ['superadmin', 'admin'])) {
                return true;
            }
            if ($user->role === 'company') {
                return $invoice->company_id === $user->company_id;
            }
        }
        if ($user instanceof Customer) {
            return $invoice->order?->customer_id === $user->id;
        }
        return false;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['superadmin', 'admin']);
    }

    public function update(User $user, Invoice $invoice): bool
    {
        return in_array($user->role, ['superadmin', 'admin']);
    }

    public function delete(User $user, Invoice $invoice): bool
    {
        return $user->role === 'superadmin';
    }

    public function download($user, Invoice $invoice): bool
    {
        return $this->view($user, $invoice);
    }
}
