<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'pet_id',
        'service_id',
        'notes',
        'products_used',
        'diagnosis',
        'treatment',
        'before_photos',
        'after_photos',
        'type', 
        'notes'
    ];

    protected $casts = [
        'before_photos' => 'array',
        'after_photos' => 'array'
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
   
    public function specificRecord()
    {
        return match($this->type) {
            'vaccination' => $this->hasOne(VaccinationRecord::class),
            'checkup' => $this->hasOne(CheckupRecord::class),
            'surgery' => $this->hasOne(SurgeryRecord::class),
            'grooming' => $this->hasOne(GroomingRecord::class),
            'boarding' => $this->hasOne(BoardingRecord::class),
            default => null,
        };
    }
}
