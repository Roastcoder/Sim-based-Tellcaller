<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentStat extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'date', 'total_calls', 'total_talk_seconds', 'conversions',
        'leads_contacted', 'follow_ups_scheduled', 'conversion_rate', 'hourly_breakdown'
    ];

    protected $casts = [
        'date' => 'date',
        'conversion_rate' => 'decimal:2',
        'hourly_breakdown' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}