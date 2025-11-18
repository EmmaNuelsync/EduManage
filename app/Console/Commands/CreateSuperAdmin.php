<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateSuperAdmin extends Command
{
    protected $signature = 'make:superadmin {email} {password}';
    protected $description = 'Create a new super admin user';

    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        User::create([
            'name' => 'System SuperAdmin',
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'super_admin',
            'email_verified_at' => now(),
        ]);

        $this->info('SuperAdmin created successfully!');
        return Command::SUCCESS;
    }
}