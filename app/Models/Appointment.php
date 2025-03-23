<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'appointment_date', 'appointment_time', 'status', 'approved_at'
    ];

    /**
     * Relationship: An appointment can have multiple pets.
     */
    public function pets(): BelongsToMany
{
    return $this->belongsToMany(Pet::class, 'appointment_pet', 'appointment_id', 'pet_id');
}


    /**
     * Relationship: An appointment can have multiple services through pets.
     */
    public function services()
{
    return $this->belongsToMany(Service::class, 'appointment_service');
}

    /**
     * Relationship: An appointment belongs to a user (customer).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
