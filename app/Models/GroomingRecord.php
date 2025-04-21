<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroomingRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'pet_id',
        'notes',
        'products_used',
        'before_photo_path',
        'after_photo_path'
    ];
    
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }
}