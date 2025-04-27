<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VaccineType extends Model
{
    protected $fillable = [
        'name', 
        'description'
        
    ];
    public function services() {
        return $this->belongsToMany(Service::class, 'service_vaccine_pricing')
                    ->withPivot(['pet_type_id', 'price']);
    }
    public function vaccinePricings()
    {
        return $this->hasMany(ServiceVaccinePricing::class);
    }
}