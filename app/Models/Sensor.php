<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    protected  $connection = 'mongodb';
    protected  $collection = 'sensors';
    use HasFactory;
    protected $fillable = [
        'device_id', 'data'
    ];
    protected $casts = [
        'data' => 'array'
    ];

    public function device()
    {
        return $this->belongsTo(Device::class, 'identifier');
    }
}