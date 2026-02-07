<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
protected $fillable = [
    'first_name', 
    'last_name', 
    'middle_name', 
    'email', 
    'phone', 
    'age', 
    'gender', 
    'civil_status', 
    'birth_date', 
    'place_birth', 
    'height_cm', 
    'weight_kg', 
    'address', 
    'is_voter'
];
}