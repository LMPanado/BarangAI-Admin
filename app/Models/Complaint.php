<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $table = 'complaints';

    protected $fillable = [
        'user_email', 'message', 'severity', 'severity_score',
        'ai_summary', 'status', 'supabase_uid',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'severity_score' => 'float',
    ];

    public $timestamps = false;
}
