<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $path = ltrim($request->path(), '/');

        // Only protect routes that start with 'admin'
        if (str_starts_with($path, 'admin')) {
            $user = Auth::user();

            // Not logged in -> redirect to login
            if (!$user) {
                return Redirect::to('/login');
            }

            // If user doesn't have admin flag/role, redirect to login
            // We'll check common fields: 'is_admin', 'role', 'Quyen'
            $isAdmin = false;
            if (isset($user->is_admin) && $user->is_admin) {
                $isAdmin = true;
            } elseif (isset($user->role) && in_array(strtolower($user->role), ['admin', 'administrator', 'manager'])) {
                $isAdmin = true;
            } elseif (isset($user->Quyen) && (int)$user->Quyen === 1) {
                $isAdmin = true;
            }

            if (!$isAdmin) {
                return Redirect::to('/login');
            }
        }

        return $next($request);
    }
}
