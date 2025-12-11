<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasAuditLog;

class Company extends Model
{
    use HasFactory, HasAuditLog;

    protected $fillable = [
        'name', 'slug', 'logo', 'primary_color', 'billing_status', 'settings', 'status'
    ];

    protected $casts = [
        'settings' => 'array',
        'status' => 'boolean',
    ];

    // Relationships
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }

    public function admins()
    {
        return $this->users()->where('role_id', User::ADMIN);
    }

    public function managers()
    {
        return $this->users()->where('role_id', User::MANAGER);
    }

    public function agents()
    {
        return $this->users()->where('role_id', User::AGENT);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeByBillingStatus($query, $status)
    {
        return $query->where('billing_status', $status);
    }

    // Helper methods
    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo ? asset('storage/' . $this->logo) : null;
    }

    public function isActive(): bool
    {
        return $this->status && $this->billing_status === 'active';
    }

    public function getTotalUsersAttribute(): int
    {
        return $this->users()->count();
    }

    public function getTotalLeadsAttribute(): int
    {
        return $this->leads()->count();
    }
}