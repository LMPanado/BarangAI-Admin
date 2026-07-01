<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComplaintMessage extends Model
{
    protected $fillable = [
        'complaint_id',
        'admin_id',
        'recipient_email',
        'message',
        'sender_type',
        'sender_name',
        'is_read',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'is_read'    => 'boolean',
    ];

    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function isByAdmin(): bool
    {
        return $this->sender_type === 'admin';
    }
}
