<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Maison extends Model
{
    use HasFactory;
    protected  $connection = 'mongodb';
    protected  $collection = 'maisons';

    protected $fillable = [
        
        'name',
        'adresse',
        'phone',      
        'is_pending'
    ];


    public function user() {
        return $this->hasMany(User::class);
    }
    public function resident() {
        return $this->hasMany(Resident::class);
    }
}
