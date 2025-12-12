<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasAuditLog;

class CallLog extends Model
{
    use HasFactory, HasAuditLog;

    protected $fillable = [
        'user_id', 'lead_id', 'phone', 'call_type', 'duration_seconds',
        'start_time', 'end_time', 'disposition', 'note', 'voice_note_path',
        'device_call_id', 'metadata', 'synced_at'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'synced_at' => 'datetime',
        'metadata' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
}