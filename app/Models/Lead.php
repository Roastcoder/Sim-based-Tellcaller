<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasAuditLog;
use App\Traits\HasCompanyScope;

class Lead extends Model
{
    use HasFactory, HasAuditLog, HasCompanyScope;

    protected $fillable = [
        'company_id', 'team_id', 'name', 'phone', 'email', 'address',
        'assigned_to', 'source', 'status', 'disposition', 'score', 'priority',
        'custom_fields', 'notes', 'last_contacted_at', 'follow_up_at', 'created_by'
    ];

    protected $casts = [
        'custom_fields' => 'array',
        'last_contacted_at' => 'datetime',
        'follow_up_at' => 'datetime',
    ];

    // Status constants
    const STATUS_NEW = 'new';
    const STATUS_CONTACTED = 'contacted';
    const STATUS_INTERESTED = 'interested';
    const STATUS_FOLLOW_UP = 'follow_up';
    const STATUS_CONVERTED = 'converted';
    const STATUS_LOST = 'lost';

    // Priority constants
    const PRIORITY_LOW = 'low';
    const PRIORITY_MEDIUM = 'medium';
    const PRIORITY_HIGH = 'high';

    // Relationships
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function callLogs()
    {
        return $this->hasMany(CallLog::class);
    }

    // Scopes
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeAssignedTo($query, $userId)
    {
        return $query->where('assigned_to', $userId);
    }

    public function scopeByTeam($query, $teamId)
    {
        return $query->where('team_id', $teamId);
    }

    public function scopeNeedsFollowUp($query)
    {
        return $query->where('follow_up_at', '<=', now())
                    ->where('status', '!=', self::STATUS_CONVERTED)
                    ->where('status', '!=', self::STATUS_LOST);
    }

    // Helper methods
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            self::STATUS_NEW => 'bg-blue-100 text-blue-800',
            self::STATUS_CONTACTED => 'bg-yellow-100 text-yellow-800',
            self::STATUS_INTERESTED => 'bg-green-100 text-green-800',
            self::STATUS_FOLLOW_UP => 'bg-purple-100 text-purple-800',
            self::STATUS_CONVERTED => 'bg-emerald-100 text-emerald-800',
            self::STATUS_LOST => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getPriorityColorAttribute(): string
    {
        return match($this->priority) {
            self::PRIORITY_HIGH => 'bg-red-100 text-red-800',
            self::PRIORITY_MEDIUM => 'bg-yellow-100 text-yellow-800',
            self::PRIORITY_LOW => 'bg-green-100 text-green-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getLastCallAttribute()
    {
        return $this->callLogs()->latest('start_time')->first();
    }

    public function getTotalCallsAttribute(): int
    {
        return $this->callLogs()->count();
    }

    public function isOverdue(): bool
    {
        return $this->follow_up_at && $this->follow_up_at->isPast();
    }
}