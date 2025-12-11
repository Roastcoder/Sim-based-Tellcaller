<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class CompanyScopeMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Super admin can access everything
        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        // Check if user has a company
        if (!$user->company_id) {
            abort(403, 'No company assigned');
        }

        // Check if company is active
        if (!$user->company?->isActive()) {
            abort(403, 'Company is inactive');
        }

        // Add company scope to request for controllers to use
        $request->merge(['company_scope' => $user->company_id]);

        return $next($request);
    }
}