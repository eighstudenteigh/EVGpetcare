<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroomingRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'record_id',
        'groomer_name',
        'grooming_type',
        'products_used',
        'coat_condition',
        'skin_condition',
        'behavior_notes',
        'special_instructions'
    ];

    public function record()
    {
        return $this->belongsTo(Record::class);
    }

    public function service()
    {
        return $this->through('record')->has('service');
    }
}