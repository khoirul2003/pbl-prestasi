<?php

namespace Database\Seeders;

use App\Models\DosenDetail;
use App\Models\MahasiswaDetail;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Admin
        User::create([
            'role_id' => 1,
            'user_name' => 'Admin User',
            'user_username' => 'admin01',
            'user_password' => Hash::make('password123'),
        ]);

        // Supervisor
        for ($i = 1; $i <= 15; $i++) {
            User::create([
                'role_id' => 2,
                'user_name' => "Supervisor $i",
                'user_username' => "supervisor$i",
                'user_password' => Hash::make('password123'),
            ]);
        }

        // Student
        for ($i = 1; $i <= 20; $i++) {
            User::create([
                'role_id' => 3,
                'user_name' => "Student $i",
                'user_username' => "student$i",
                'user_password' => Hash::make('password123'),
            ]);
        }
    }
}
