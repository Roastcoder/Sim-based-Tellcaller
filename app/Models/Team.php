<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasAuditLog;

class Team extends Model
{
    use HasFactory, HasAuditLog;

    protected $fillable = [
        'company_id', 'manager_id', 'name', 'description', 'settings', 'status'
    ];

    protected $casts = [
        'settings' => 'array',
        'status' => 'boolean',
    ];

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
        return $this->hasMany(User::class, 'team_id');
    }

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }
}