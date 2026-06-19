<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $table = 'announcements';

    protected $fillable = [
        'title',
        'content',
        'category',
        'image_url',
        'is_pinned',
    ];

    protected $casts = [
        'is_pinned' => 'boolean', // Crucial for PostgreSQL compatibility
    ];
}