<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class AppointmentService extends Pivot
{
    protected $table = 'appointment_service';
    
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    
    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }
}