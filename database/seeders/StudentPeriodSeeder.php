<?php

namespace Database\Seeders;

use App\Models\DetailStudent;
use App\Models\Period;
use App\Models\StudentPeriod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class StudentPeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        StudentPeriod::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $faker = Faker::create();

        $students = DetailStudent::all();
        $periods = Period::all();

        foreach ($students as $student) {
            $periodCount = $faker->numberBetween(2, 4);

            $studentPeriods = $periods->random($periodCount);

            foreach ($studentPeriods as $period) {
                StudentPeriod::create([
                    'period_id' => $period->period_id,
                    'detail_student_id' => $student->detail_student_id,
                    'ipk' => $faker->randomFloat(2, 3.5, 4.0),
                ]);
            }
        }
    }
}
