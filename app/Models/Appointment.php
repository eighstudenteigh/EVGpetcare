<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','appointment_id','customer_id', 'service_id', 'pet_id', 'price','appointment_date',
        'appointment_time',
        'status',
        'approved_at',
        'completed_at',
        'finalized_at',];

    protected $casts = [
        'appointment_date' => 'datetime',
        'approved_at' => 'datetime',
        'completed_at' => 'datetime',
        'finalized_at' => 'datetime', 
    ];
    

    /**
     * An appointment belongs to a user (customer).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * An appointment can have multiple pets.
     */
    
   
public function servicesForPet($petId)
{
    return $this->services->filter(function($service) use ($petId) {
        return $service->pivot->pet_id == $petId;
    });
}
public function records()
{
    return $this->hasMany(Record::class);
}

public function petRecords(Pet $pet)
{
    return $this->records()->where('pet_id', $pet->id);
}

public function serviceRecords(Service $service)
{
    return $this->records()->where('service_id', $service->id);
}
public function pets()
{
    return $this->belongsToMany(Pet::class, 'appointment_pet', 'appointment_id', 'pet_id');
}

public function appointmentServices()
{
    return $this->hasMany(AppointmentService::class);
}
public function grooming()
{
    return $this->hasOne(\App\Models\GroomingRecord::class, 'record_id');
}
public function services()
{
    return $this->belongsToMany(Service::class, 'appointment_service')
        ->withPivot(['id', 'pet_id', 'price']);
}

// In Service model:
public function vaccineTypes()
{
    return $this->belongsToMany(VaccineType::class, 'service_vaccine_pricing')
        ->withPivot(['price', 'pet_type_id']);
}
public function vaccines()
{
    return $this->belongsToMany(
        VaccineType::class, 
        'appointment_service_vaccine', 
        'appointment_service_id', 
        'vaccine_type_id'
    )->withTimestamps();
}
}
