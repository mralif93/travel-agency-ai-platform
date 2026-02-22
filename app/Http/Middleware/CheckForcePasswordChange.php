<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckForcePasswordChange
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        
        if ($user && $user->force_password_change) {
            $allowedRoutes = [
                'password.change.show',
                'password.change.update',
                'logout',
            ];
            
            if (!in_array($request->route()->getName(), $allowedRoutes)) {
                return redirect()->route('password.change.show');
            }
        }
        
        return $next($request);
    }
}
