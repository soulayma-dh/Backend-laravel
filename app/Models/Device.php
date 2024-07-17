<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Device extends Model
{
    use HasFactory;
    protected  $connection = 'mongodb';
    protected  $collection = 'devices';

    protected $fillable = [
        'name',
        'type', 
        'identifier',
        'resident_id',
        'is_pending'
    ];

    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }
    public function sensor()
    {
        return $this->hasMany(Sensor::class);
    }
}
