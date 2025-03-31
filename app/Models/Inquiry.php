<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'contact_number',
        'message',
        'pet_type_id',
        'service_id',
        'status'
    ];

    protected $attributes = [
        'contact_number' => null, 
    ];

    public function petType()
    {
        return $this->belongsTo(PetType::class, 'pet_type_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
    
}
