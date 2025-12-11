<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

trait HasAuditLog
{
    protected static function bootHasAuditLog()
    {
        static::created(function ($model) {
            $model->logActivity('created');
        });

        static::updated(function ($model) {
            $model->logActivity('updated', $model->getOriginal(), $model->getAttributes());
        });

        static::deleted(function ($model) {
            $model->logActivity('deleted');
        });
    }

    public function logActivity(string $action, array $oldValues = [], array $newValues = [])
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'target_type' => get_class($this),
            'target_id' => $this->id,
            'old_values' => !empty($oldValues) ? $oldValues : null,
            'new_values' => !empty($newValues) ? $newValues : null,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    public function auditLogs()
    {
        return $this->morphMany(AuditLog::class, 'target', 'target_type', 'target_id');
    }
}