<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceVaccinePricing extends Model
{
    use HasFactory;

    protected $table = 'service_vaccine_pricing';
    
    protected $fillable = [
        'service_id',
        'vaccine_type_id',
        'pet_type_id',
        'price'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function vaccineType()
    {
        return $this->belongsTo(VaccineType::class);
    }

    public function petType()
    {
        return $this->belongsTo(PetType::class);
    }
}