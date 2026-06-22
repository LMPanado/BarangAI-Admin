<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedback';

    protected $fillable = [
        'user_email', 'message', 'category', 'sentiment',
        'sentiment_score', 'ai_summary', 'supabase_uid',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'sentiment_score' => 'float',
    ];

    public $timestamps = false;
}
