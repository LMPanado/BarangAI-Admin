<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'email',
        'phone',
        'age',
        'gender',
        'civil_status',
        'address',
        'is_voter',
        'birth_date',
        'place_birth',
        'height_cm',
        'weight_kg',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Addition: Link back to requests
    public function documentRequests()
    {
        return $this->hasMany(DocumentRequest::class, 'resident_id');
    }
}