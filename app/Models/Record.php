<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\VaccinationRecord;
use App\Models\CheckupRecord;
use App\Models\SurgeryRecord;
use App\Models\GroomingRecord;
use App\Models\BoardingRecord;

class Record extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'pet_id',
        'service_id',
        'type', 
        'notes',
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

    // Specific record relationships
    public function vaccination()
    {
        return $this->hasOne(VaccinationRecord::class);
    }

    public function checkup()
    {
        return $this->hasOne(CheckupRecord::class);
    }

    public function surgery()
    {
        return $this->hasOne(SurgeryRecord::class);
    }

    public function grooming()
    {
        return $this->hasOne(GroomingRecord::class);
    }

    public function boarding()
    {
        return $this->hasOne(BoardingRecord::class);
    }
}