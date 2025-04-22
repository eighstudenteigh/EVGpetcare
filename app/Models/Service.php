<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'description', ];

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
}