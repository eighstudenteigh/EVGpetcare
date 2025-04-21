<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'type',
        'diagnosis',
        'treatment',
        'vitals',
        'follow_up'
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
    
    // Instead of direct pet relationship, get it through appointment
    public function pet()
    {
        // Assuming each medical record is for one pet
        // We need to find which pet in the appointment this record belongs to
        return $this->appointment ? $this->appointment->pets->first() : null;
    }
}