<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardingRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'record_id',
        'kennel_number',
        'check_in_time',
        'check_out_time',
        'feeding_schedule',
        'medications_administered',
        'activity_notes',
        'behavior_notes',
        'special_instructions'
    ];

    protected $casts = [
        'check_in_time' => 'datetime:H:i',
        'check_out_time' => 'datetime:H:i',
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