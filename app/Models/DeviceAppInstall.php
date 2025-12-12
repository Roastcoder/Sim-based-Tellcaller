<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceAppInstall extends Model
{
    protected $fillable = [
        'device_id', 'app_id', 'installed_at', 'last_opened_at', 'is_active'
    ];

    protected $casts = [
        'installed_at' => 'datetime',
        'last_opened_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function app()
    {
        return $this->belongsTo(App::class);
    }
}