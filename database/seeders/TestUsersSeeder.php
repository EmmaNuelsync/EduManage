<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class TestUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@school.com',
            'password' => Hash::make('password'),
        ]);
        $superAdmin->assignRole('SuperAdmin');

        $teacher = User::create([
            'name' => 'John Emmanuel',
            'email' => 'johnemmanuel@school.com',
            'password' => Hash::make('password'),
        ]);
        $teacher->assignRole('Teacher');

        $student = User::create([
            'name' => 'Emmanuel Samuel',
            'email' => 'emmanuelsamuel@school.com',
            'password' => Hash::make('password'),
        ]);
        $student->assignRole('Student');

        $parent = User::create([
            'name' => 'Comfort Samuel',
            'email' => 'comfortsamuel@school.com',
            'password' => Hash::make('password'),
        ]);
        $parent->assignRole('Parent');

        $bursar = User::create([
            'name' => 'Peter Bursar',
            'email' => 'peterbursar@school.com',
            'password' => Hash::make('password'),
        ]);
        $bursar->assignRole('Bursar');
    }
}
