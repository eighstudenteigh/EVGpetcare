<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurgeryRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'record_id',
        'procedure_name',
        'anesthesia_type',
        'surgeon_name',
        'start_time',
        'end_time',
        'complications',
        'post_op_instructions',
        'medications'
    ];

    protected $casts = [
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    public function record()
    {
        return $this->belongsTo(Record::class);
    }

    public function appointment()
    {
        return $this->through('record')->has('appointment');
    }
}