<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::factory()
        ->count(3)
        ->hasRole()
        ->create();
        /*->each(function ($user) {
            $user->role()->save(\App\Models\Role::factory()
            ->make()
        );
        });*/
        
    }
}
