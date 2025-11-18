<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if super admin already exists
        $existingSuperAdmin = User::where('email', 'superadmin@edumanage.com')->first();
        
        if (!$existingSuperAdmin) {
            User::create([
                'name' => 'System SuperAdmin',
                'email' => 'superadmin@edumanage.com',
                'password' => Hash::make('SuperAdmin123!'), // You'll change this later
                'role' => 'super_admin',
                'email_verified_at' => now(),
            ]);
            
            $this->command->info('SuperAdmin account created successfully!');
            $this->command->info('Email: superadmin@edumanage.com');
            $this->command->info('Password: SuperAdmin123!');
            $this->command->warn('Please change the password after first login!');
        } else {
            $this->command->info('SuperAdmin account already exists.');
        }
    }
}