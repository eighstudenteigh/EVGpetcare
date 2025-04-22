<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaccinationRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'record_id',
        'vaccine_type',
        'batch_number',
        'administered_by',
        'next_due_date'
    ];

    protected $casts = [
        'next_due_date' => 'date',
    ];

    public function record()
    {
        return $this->belongsTo(Record::class);
    }

    public function pet()
    {
        return $this->through('record')->has('pet');
    }
}