<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AutoDialer extends Model
{
    protected $fillable = [
        'user_id',
        'device_name',
        'sim_number',
        'android_device_id',
        'status',
        'call_dispositions',
        'calls_made_today',
        'last_call_at'
    ];

    protected $casts = [
        'call_dispositions' => 'array',
        'last_call_at' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}