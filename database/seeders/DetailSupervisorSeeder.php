<?php

namespace Database\Seeders;

use App\Models\DetailSupervisor;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DetailSupervisorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $supervisors = User::where('role_id', 2)->get();

        foreach ($supervisors as $supervisor) {
            DetailSupervisor::create([
                'user_id' => $supervisor->user_id,
                'department_id' => 1,
                'detail_supervisor_nip' => '1987654321' . str_pad($supervisor->user_id, 3, '0', STR_PAD_LEFT),
                'detail_supervisor_gender' => $faker->randomElement(['male', 'female']),
                'detail_supervisor_dob' => $faker->date('Y-m-d', '1980-01-01'),
                'detail_supervisor_address' => $faker->address(),
                'detail_supervisor_phone_no' => $faker->phoneNumber(),
                'detail_supervisor_email' => $faker->unique()->safeEmail(),
                'detail_supervisor_photo' => null,
            ]);
        }
    }
}
