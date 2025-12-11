<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\HasAuditLog;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasAuditLog;

    protected $fillable = [
        'name', 'email', 'phone', 'password', 'role_id', 'company_id', 
        'manager_id', 'team_id', 'status', 'avatar'
    ];

    protected $hidden = ['password', 'remember_token', 'two_factor_secret'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'two_factor_enabled' => 'boolean',
        'status' => 'boolean',
        'password' => 'hashed',
    ];

    // Role constants
    const SUPER_ADMIN = 1;
    const ADMIN = 2;
    const MANAGER = 3;
    const AGENT = 4;

    // Relationships
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function agents()
    {
        return $this->hasMany(User::class, 'manager_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function managedTeams()
    {
        return $this->hasMany(Team::class, 'manager_id');
    }

    public function leads()
    {
        return $this->hasMany(Lead::class, 'assigned_to');
    }

    public function callLogs()
    {
        return $this->hasMany(CallLog::class);
    }

    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    public function agentStats()
    {
        return $this->hasMany(AgentStat::class);
    }

    // Role checking methods
    public function isSuperAdmin(): bool
    {
        return $this->role_id === self::SUPER_ADMIN;
    }

    public function isAdmin(): bool
    {
        return $this->role_id === self::ADMIN;
    }

    public function isManager(): bool
    {
        return $this->role_id === self::MANAGER;
    }

    public function isAgent(): bool
    {
        return $this->role_id === self::AGENT;
    }

    public function hasRole(int $role): bool
    {
        return $this->role_id === $role;
    }

    public function hasMinRole(int $minRole): bool
    {
        return $this->role_id <= $minRole;
    }

    // Scope methods
    public function scopeByCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    public function scopeByRole($query, $roleId)
    {
        return $query->where('role_id', $roleId);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    // Helper methods
    public function getFullNameAttribute(): string
    {
        return $this->name;
    }

    public function getRoleNameAttribute(): string
    {
        return $this->role->display_name ?? 'Unknown';
    }

    public function canManage(User $user): bool
    {
        if ($this->isSuperAdmin()) return true;
        if ($this->isAdmin() && $this->company_id === $user->company_id) return true;
        if ($this->isManager() && $user->manager_id === $this->id) return true;
        return false;
    }
}