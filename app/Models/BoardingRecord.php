<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardingRecord extends Model
{
    use HasFactory;

    protected $table = 'boarding_records'; 

    protected $fillable = [
        'appointment_id',
        'check_in',
        'check_out',
        'daily_notes'
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
    
    // Instead of direct pet relationship, get it through appointment
    public function pet()
    {
        // Assuming each boarding record is for one pet
        // We need to find which pet in the appointment this record belongs to
        return $this->appointment ? $this->appointment->pets->first() : null;
    }
}