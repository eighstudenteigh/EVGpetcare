<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'description'];

    public function animalTypes()
    {
        return $this->belongsToMany(PetType::class, 'service_pet_type', 'service_id', 'pet_type_id') ->withPivot('price');
}
    public function petTypes()
{
    return $this->belongsToMany(PetType::class, 'service_pet_type', 'service_id', 'pet_type_id')
                ->withTimestamps(); 
}
public function services()
{
    return $this->belongsToMany(Service::class, 'service_pet_type', 'pet_type_id', 'service_id');
}
}

