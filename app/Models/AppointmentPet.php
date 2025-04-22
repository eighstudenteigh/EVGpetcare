<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class AppointmentPet extends Pivot
{
    protected $table = 'appointment_pet';
    public $incrementing = true; // If you have an auto-incrementing id
    public $timestamps = false; // Disable timestamps
    
    protected $fillable = [
        'id',
        'appointment_id',
        'pet_id'
    ];
}