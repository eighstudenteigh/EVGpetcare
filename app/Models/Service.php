<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'is_vaccination', ];
    protected $casts = [
        'is_vaccination' => 'boolean',
    ];
    public function petTypes()
    {
        return $this->belongsToMany(PetType::class, 'service_pet_type', 'service_id', 'pet_type_id')
                    ->withPivot('price');
    }

    // Add this alias if you need to keep using animalTypes in your code
    public function animalTypes()
    {
        return $this->petTypes();
    }
    public function vaccinePricings()
{
    return $this->hasMany(ServiceVaccinePricing::class)
        ->with(['vaccineType', 'petType']); // Eager load both relationships
}
    
    public function vaccineTypes()
    {
        return $this->belongsToMany(VaccineType::class, 'service_vaccine_pricing')
                   ->withPivot(['pet_type_id', 'price']);
    }

public function universalVaccines()
{
    return $this->belongsToMany(VaccineType::class, 'service_vaccine_pricing')
                ->withPivot(['pet_type_id', 'price'])
                ->wherePivotNull('pet_type_id'); // Vaccines without animal types
}
    
}   