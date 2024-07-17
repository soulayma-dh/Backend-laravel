<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class Role extends Model
{
    use HasApiTokens,HasFactory;
    protected $collection = 'roles';
    protected $fillable = [
        'user_id',
        'role',
        'is_pending'
    ];

    protected $casts = [
        'is_pending' => 'boolean'
    ];
    public function userRole() {
        return $this->belongsTo(User::class);
    }
   
}
