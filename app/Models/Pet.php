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

    /**
     * Check if a pet has a grooming record for a specific appointment
     */
    public function hasGroomingRecord($appointment_id)
    {
        return GroomingRecord::where('appointment_id', $appointment_id)
            ->whereHas('appointment', function($query) {
                $query->whereHas('pets', function($q) {
                    $q->where('pets.id', $this->id);
                });
            })->exists();
    }

    /**
     * Check if a pet has a medical record for a specific appointment
     */
    public function hasMedicalRecord($appointment_id)
    {
        return MedicalRecord::where('appointment_id', $appointment_id)
            ->whereHas('appointment', function($query) {
                $query->whereHas('pets', function($q) {
                    $q->where('pets.id', $this->id);
                });
            })->exists();
    }

    /**
     * Check if a pet has a boarding record for a specific appointment
     */
    public function hasBoardingRecord($appointment_id)
    {
        return BoardingRecord::where('appointment_id', $appointment_id)
            ->whereHas('appointment', function($query) {
                $query->whereHas('pets', function($q) {
                    $q->where('pets.id', $this->id);
                });
            })->exists();
    }

    /**
     * Get grooming records for this pet
     */
    public function groomingRecords()
{
    return $this->hasMany(GroomingRecord::class);
}

    /**
     * Get medical records for this pet
     */
    public function medicalRecords()
{
    return $this->hasMany(MedicalRecord::class);
}

    /**
     * Get boarding records for this pet
     */
    public function boardingRecords()
{
    return $this->hasMany(BoardingRecord::class);
}
}