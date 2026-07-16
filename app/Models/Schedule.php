<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'title',
        'schedule_date',
        'schedule_time',
        'schedule_time_to',
        'description',
        'location',
        'image',
        'age_groups',
    ];

    protected $casts = [
        'age_groups' => 'array',
    ];
}