<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Role;

class CreateSuperAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:superadmin {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a super administrator';

    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        $user = User::create([
            'name' => 'Super Admin',
            'email' => $email,
            'password' => bcrypt($password),
        ]);

        if ($user) {
            $role = new Role([
                'role' => 'superadmin',
                'user_id' => $user->_id
            ]);
            
            $role->save();

            $user->createToken('SuperAdminToken', ['superadmin']);

            $this->info('Super administrator created successfully');

        } else {
            $this->error('Failed to create super administrator');
        }
    }
}
// ./vendor/bin/sail php artisan make:superadmin soulaymadhouioui@gmail.com password


