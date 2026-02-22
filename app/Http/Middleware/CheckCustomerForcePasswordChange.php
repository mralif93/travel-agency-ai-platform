<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckCustomerForcePasswordChange
{
    public function handle(Request $request, Closure $next): Response
    {
        $customer = Auth::guard('customer')->user();
        
        if ($customer && $customer->force_password_change) {
            $allowedRoutes = [
                'customer.password.change.show',
                'customer.password.change.update',
                'customer.logout',
            ];
            
            if (!in_array($request->route()->getName(), $allowedRoutes)) {
                return redirect()->route('customer.password.change.show');
            }
        }
        
        return $next($request);
    }
}
