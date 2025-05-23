<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceAnimal extends Model
{
    use HasFactory;

    protected $fillable = ['service_id', 'animal_type'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
