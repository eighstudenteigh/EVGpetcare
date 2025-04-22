<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'name', 'type', 'breed', 'gender', 'age', 'photo_path'];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function appointments(): BelongsToMany
    {
        return $this->belongsToMany(Appointment::class, 'appointment_pet', 'pet_id', 'appointment_id');
    }
    
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'appointment_service', 'pet_id', 'service_id')
                    ->withTimestamps();
    }
    
    public function petType()
    {
        return $this->belongsTo(PetType::class, 'type', 'name'); 
    }
    
    public function getPhotoUrlAttribute()
    {
        return $this->photo_path ? asset('storage/' . $this->photo_path) : null;
    }
    public function appointmentServices()
{
    return $this->hasMany(AppointmentService::class);
}
   

    

   

}