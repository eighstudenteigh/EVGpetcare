<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetType extends Model
{
    use HasFactory;

    protected $fillable = ['name']; 

    
    public function pets()
{
    return $this->hasMany(Pet::class, 'type', 'name'); 
}

public function services()
{
    return $this->belongsToMany(Service::class, 'service_pet_type', 'pet_type_id', 'service_id')
                ->withTimestamps(); 
}

}
