<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentRequest extends Model
{
    // Ensure this matches the table name seen in your admin database
    protected $table = 'document_requests'; 

    protected $fillable = [
        'resident_id',
        'full_name',
        'document_type',
        'purpose',
        'pickup_date',
        'status',
        'source',
        'reference_no',
    ];

    // This connects the request to the Resident (Admin side likely uses this)
    public function resident()
    {
        return $this->belongsTo(Resident::class, 'resident_id');
    }
}