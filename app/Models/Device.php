<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasAuditLog;

class Device extends Model
{
    use HasFactory, HasAuditLog;

    protected $fillable = [
        'device_id', 'user_id', 'device_name', 'model', 'manufacturer',
        'os_version', 'app_version', 'app_version_code', 'ip_address',
        'device_info', 'is_active', 'is_locked', 'last_sync_at', 'registered_at'
    ];

    protected $casts = [
        'device_info' => 'array',
        'is_active' => 'boolean',
        'is_locked' => 'boolean',
        'last_sync_at' => 'datetime',
        'registered_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deviceInstalls()
    {
        return $this->hasMany(DeviceAppInstall::class);
    }
}