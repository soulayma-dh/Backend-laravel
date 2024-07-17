<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Resident extends Model
{
    protected  $connection = 'mongodb';
    protected  $collection = 'residents';
    use HasFactory;
    protected $fillable = [
        'maison_id',
        'tutor_id',
        'name',
        'age',
        
    ];

    public function maisonResident() {
        return $this->belongsTo(Maison::class);
    }
    public function deviceResident() {
        return $this->hasOne(Device::class);
    }
}
