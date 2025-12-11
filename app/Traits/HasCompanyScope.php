<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait HasCompanyScope
{
    protected static function bootHasCompanyScope()
    {
        static::addGlobalScope('company', function (Builder $builder) {
            $user = Auth::user();
            
            if (!$user) {
                return;
            }

            // Super admin can see everything
            if ($user->isSuperAdmin()) {
                return;
            }

            // Admin and below are scoped to their company
            if ($user->company_id) {
                $builder->where('company_id', $user->company_id);
            }
        });
    }

    public function scopeForUser($query, $user = null)
    {
        $user = $user ?: Auth::user();
        
        if (!$user) {
            return $query->whereRaw('1 = 0'); // No results
        }

        if ($user->isSuperAdmin()) {
            return $query;
        }

        if ($user->isAdmin()) {
            return $query->where('company_id', $user->company_id);
        }

        if ($user->isManager()) {
            return $query->where('company_id', $user->company_id)
                        ->where(function($q) use ($user) {
                            $q->where('team_id', $user->managedTeams()->pluck('id'))
                              ->orWhere('assigned_to', $user->id);
                        });
        }

        if ($user->isAgent()) {
            return $query->where('assigned_to', $user->id);
        }

        return $query->whereRaw('1 = 0');
    }
}