<?php

namespace App\Policies;

use App\Models\{User, Lead};

class LeadPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasMinRole(User::AGENT);
    }

    public function view(User $user, Lead $lead): bool
    {
        // Super admin can view all
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Admin can view company leads
        if ($user->isAdmin() && $user->company_id === $lead->company_id) {
            return true;
        }

        // Manager can view team leads
        if ($user->isManager()) {
            $teamIds = $user->managedTeams()->pluck('id');
            return $teamIds->contains($lead->team_id) || $lead->assigned_to === $user->id;
        }

        // Agent can view assigned leads
        if ($user->isAgent()) {
            return $lead->assigned_to === $user->id;
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->hasMinRole(User::MANAGER);
    }

    public function update(User $user, Lead $lead): bool
    {
        // Super admin can update all
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Admin can update company leads
        if ($user->isAdmin() && $user->company_id === $lead->company_id) {
            return true;
        }

        // Manager can update team leads
        if ($user->isManager()) {
            $teamIds = $user->managedTeams()->pluck('id');
            return $teamIds->contains($lead->team_id);
        }

        // Agent can update assigned leads (limited fields)
        if ($user->isAgent()) {
            return $lead->assigned_to === $user->id;
        }

        return false;
    }

    public function delete(User $user, Lead $lead): bool
    {
        // Only admin and above can delete
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($user->isAdmin() && $user->company_id === $lead->company_id) {
            return true;
        }

        return false;
    }

    public function assign(User $user): bool
    {
        return $user->hasMinRole(User::MANAGER);
    }

    public function import(User $user): bool
    {
        return $user->hasMinRole(User::MANAGER);
    }

    public function export(User $user): bool
    {
        return $user->hasMinRole(User::MANAGER);
    }
}