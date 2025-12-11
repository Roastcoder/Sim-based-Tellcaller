<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasAuditLog;

class App extends Model
{
    use HasFactory, HasAuditLog;

    protected $fillable = [
        'name', 'package_name', 'version_name', 'version_code', 'file_path',
        'file_hash', 'file_size', 'channel', 'status', 'metadata', 'changelog',
        'min_sdk_version', 'target_sdk_version', 'permissions', 'uploaded_by', 'released_at'
    ];

    protected $casts = [
        'metadata' => 'array',
        'permissions' => 'array',
        'released_at' => 'datetime',
    ];

    // Channel constants
    const CHANNEL_INTERNAL = 'internal';
    const CHANNEL_BETA = 'beta';
    const CHANNEL_STABLE = 'stable';

    // Status constants
    const STATUS_ACTIVE = 'active';
    const STATUS_DEPRECATED = 'deprecated';
    const STATUS_DISABLED = 'disabled';

    // Relationships
    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function deviceInstalls()
    {
        return $this->hasMany(DeviceAppInstall::class);
    }

    public function devices()
    {
        return $this->belongsToMany(Device::class, 'device_app_installs')
                    ->withPivot(['installed_at', 'last_opened_at', 'is_active'])
                    ->withTimestamps();
    }

    // Scopes
    public function scopeByChannel($query, $channel)
    {
        return $query->where('channel', $channel);
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeLatestVersion($query)
    {
        return $query->orderBy('version_code', 'desc');
    }

    public function scopeByPackage($query, $packageName)
    {
        return $query->where('package_name', $packageName);
    }

    // Helper methods
    public function getDownloadUrlAttribute(): string
    {
        return route('apps.download', $this->id);
    }

    public function getFileSizeHumanAttribute(): string
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function getChannelColorAttribute(): string
    {
        return match($this->channel) {
            self::CHANNEL_STABLE => 'bg-green-100 text-green-800',
            self::CHANNEL_BETA => 'bg-yellow-100 text-yellow-800',
            self::CHANNEL_INTERNAL => 'bg-blue-100 text-blue-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            self::STATUS_ACTIVE => 'bg-green-100 text-green-800',
            self::STATUS_DEPRECATED => 'bg-yellow-100 text-yellow-800',
            self::STATUS_DISABLED => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getTotalInstallsAttribute(): int
    {
        return $this->deviceInstalls()->count();
    }

    public function getActiveInstallsAttribute(): int
    {
        return $this->deviceInstalls()->where('is_active', true)->count();
    }

    public function isLatestVersion(): bool
    {
        $latest = static::where('package_name', $this->package_name)
                       ->where('channel', $this->channel)
                       ->max('version_code');
        
        return $this->version_code === $latest;
    }
}