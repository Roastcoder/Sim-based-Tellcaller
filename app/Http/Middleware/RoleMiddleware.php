<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Convert role names to IDs if needed
        $roleIds = collect($roles)->map(function ($role) {
            return match(strtoupper($role)) {
                'SUPER_ADMIN' => 1,
                'ADMIN' => 2,
                'MANAGER' => 3,
                'AGENT' => 4,
                default => (int) $role
            };
        });

        // Check if user has any of the required roles
        if (!$roleIds->contains($user->role_id)) {
            abort(403, 'Insufficient permissions');
        }

        return $next($request);
    }
}