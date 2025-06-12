<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\DetailStudent;
use App\Models\DetailSupervisor;
use App\Models\StudyProgram;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        DetailStudent::truncate();
        DetailSupervisor::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        User::create([
            'role_id' => 1,
            'user_name' => 'Admin Utama',
            'user_username' => 'admin',
            'user_password' => Hash::make('Admin123!'),
            'email_verified_at' => Carbon::now(),
        ]);

        $namaDepan = ['Andi', 'Budi', 'Citra', 'Dewi', 'Eka', 'Farhan', 'Gita', 'Hari', 'Indah', 'Joko', 'Kurniawan', 'Lestari', 'Maya', 'Nugroho', 'Oktaviani', 'Putri', 'Rizki', 'Sinta', 'Teguh', 'Umi', 'Vina', 'Wahyu', 'Yulia', 'Zahra', 'Fajar', 'Galih', 'Hanif', 'Intan', 'Jasmine', 'Kirana'];
        $namaBelakang = ['Saputra', 'Wijaya', 'Sari', 'Pratama', 'Yulianto', 'Santoso', 'Utami', 'Ramadhan', 'Mahendra', 'Surya', 'Nugraha', 'Permana', 'Rahmawati', 'Susilo', 'Subekti', 'Wibowo', 'Pangestu', 'Lubis', 'Harahap', 'Hidayat', 'Nasution', 'Tanjung', 'Sitorus', 'Simanjuntak'];

        $studyProgramIds = StudyProgram::pluck('study_program_id')->all();
        $departmentIds = Department::pluck('department_id')->all();

        // Students
        for ($i = 1; $i <= 20; $i++) {
            $firstName = $namaDepan[array_rand($namaDepan)];
            $lastName = $namaBelakang[array_rand($namaBelakang)];
            $name = "$firstName $lastName";
            $username = 'student' . $i;

            $user = User::create([
                'role_id' => 3,
                'user_name' => $name,
                'user_username' => $username,
                'user_password' => Hash::make('Student123!'),
                'email_verified_at' => Carbon::now()

            ]);

            DetailStudent::create([
                'user_id' => $user->user_id,
                'study_program_id' => $studyProgramIds[array_rand($studyProgramIds)],
                'detail_student_nim' => strval(rand(1000000000, 9999999999)),
                'detail_student_gender' => rand(0, 1) ? 'male' : 'female',
                'detail_student_dob' => now()->subYears(rand(18, 25))->subDays(rand(1, 365)),
                'detail_student_address' => 'Jl. Contoh Alamat ' . $i,
                'detail_student_phone_no' => '0812' . rand(10000000, 99999999),
                'detail_student_email' => strtolower(str_replace(' ', '', $name)) . '@gmail.com',
            ]);
        }

        // Supervisors
        for ($i = 1; $i <= 15; $i++) {
            $firstName = $namaDepan[array_rand($namaDepan)];
            $lastName = $namaBelakang[array_rand($namaBelakang)];
            $name = "$firstName $lastName";
            $username = 'supervisor' . $i;

            $user = User::create([
                'role_id' => 2,
                'user_name' => $name,
                'user_username' => $username,
                'user_password' => Hash::make('Supervisor123!'),
                'email_verified_at' => Carbon::now(),

            ]);

            DetailSupervisor::create([
                'user_id' => $user->user_id,
                'department_id' => $departmentIds[array_rand($departmentIds)],
                'detail_supervisor_nip' => strval(rand(1000000000, 9999999999)),
                'detail_supervisor_gender' => rand(0, 1) ? 'male' : 'female',
                'detail_supervisor_dob' => now()->subYears(rand(30, 60))->subDays(rand(1, 365)),
                'detail_supervisor_address' => 'Jl. Dosen ' . $i,
                'detail_supervisor_phone_no' => '0821' . rand(10000000, 99999999),
                'detail_supervisor_email' => strtolower(str_replace(' ', '', $name)) . '@gmail.com',
            ]);
        }
    }
}
