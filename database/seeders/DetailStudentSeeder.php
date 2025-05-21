<?php

namespace Database\Seeders;

use App\Models\DetailStudent;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DetailStudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Ambil semua user yang role_id = 3 (Student)
        $students = User::where('role_id', 3)->get();

        foreach ($students as $student) {
            DetailStudent::create([
                'user_id' => $student->user_id,
                'study_program_id' => $faker->numberBetween(1, 3),
                'detail_student_nim' => $faker->unique()->numerify('2023########'),
                'detail_student_gender' => $faker->randomElement(['male', 'female']),
                'detail_student_dob' => $faker->date('Y-m-d', '2005-01-01'),
                'detail_student_address' => $faker->address(),
                'detail_student_phone_no' => $faker->phoneNumber(),
                'detail_student_email' => $faker->unique()->safeEmail(),
                'detail_student_photo' => null,
            ]);
        }
    }
}
