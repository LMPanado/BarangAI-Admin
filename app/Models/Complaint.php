<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $table = 'complaints';

    protected $fillable = [
        'user_email', 'message', 'severity', 'severity_score',
        'ai_summary', 'status', 'supabase_uid',
        'type', 'respondent_name', 'respondent_address', 'respondent_is_resident',
        'respondent_matched_uid', 'incident_type', 'incident_date', 'incident_time',
        'incident_location', 'witnesses',
    ];

    protected $casts = [
        'created_at'              => 'datetime',
        'severity_score'          => 'float',
        'respondent_is_resident'  => 'boolean',
        'incident_date'           => 'date',
    ];

    public $timestamps = false;

    public function residentUser()
    {
        return $this->belongsTo(User::class, 'supabase_uid', 'supabase_uid');
    }
}
