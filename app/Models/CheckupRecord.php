<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckupRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'record_id',
        'weight',
        'temperature',
        'heart_rate',
        'respiratory_rate',
        'diagnosis',
        'treatment_plan'
    ];

    protected $casts = [
        'weight' => 'decimal:2',
        'temperature' => 'decimal:1',
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