<?php

class RBACMiddleware {
    const SUPER_ADMIN = 1;
    const ADMIN = 2;
    const MANAGER = 3;
    const AGENT = 4;

    public static function requireRole($minRole) {
        return function($request, $next) use ($minRole) {
            $user = $request->user();
            
            if (!$user) {
                return response()->json(['error' => 'unauthorized'], 401);
            }
            
            if ($user->role_id > $minRole) {
                return response()->json(['error' => 'forbidden'], 403);
            }
            
            return $next($request);
        };
    }

    public static function requireCompanyAccess() {
        return function($request, $next) {
            $user = $request->user();
            $companyId = $request->route('companyId') ?? $request->input('company_id');
            
            if (!$user) {
                return response()->json(['error' => 'unauthorized'], 401);
            }
            
            // Super admin can access all companies
            if ($user->role_id === self::SUPER_ADMIN) {
                return $next($request);
            }
            
            // Others can only access their own company
            if ($user->company_id != $companyId) {
                return response()->json(['error' => 'company_access_denied'], 403);
            }
            
            return $next($request);
        };
    }

    public static function canViewLeads($user, $leadCompanyId, $leadAssignedTo = null) {
        switch ($user->role_id) {
            case self::SUPER_ADMIN:
                return true;
            case self::ADMIN:
                return $user->company_id == $leadCompanyId;
            case self::MANAGER:
                // Manager can view team leads (simplified - would need team check)
                return $user->company_id == $leadCompanyId;
            case self::AGENT:
                return $leadAssignedTo == $user->id;
            default:
                return false;
        }
    }

    public static function canAssignLeads($user) {
        return in_array($user->role_id, [self::SUPER_ADMIN, self::ADMIN, self::MANAGER]);
    }

    public static function canViewReports($user, $scope = 'company') {
        switch ($user->role_id) {
            case self::SUPER_ADMIN:
                return true;
            case self::ADMIN:
                return in_array($scope, ['company', 'team', 'self']);
            case self::MANAGER:
                return in_array($scope, ['team', 'self']);
            case self::AGENT:
                return $scope === 'self';
            default:
                return false;
        }
    }
}

// Usage examples:
// Route::middleware([RBACMiddleware::requireRole(RBACMiddleware::ADMIN)])->group(function () {
//     Route::get('/admin/users', 'AdminController@users');
// });
?>