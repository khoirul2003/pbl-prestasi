<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcademicYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $academicYears = [
            [
                'academic_year' => '2021/2022',
                'start_date' => '2021-08-01',
                'end_date' => '2022-07-31',
            ],
            [
                'academic_year' => '2022/2023',
                'start_date' => '2022-08-01',
                'end_date' => '2023-07-31',
            ],
            [
                'academic_year' => '2023/2024',
                'start_date' => '2023-08-01',
                'end_date' => '2024-07-31',
            ],
        ];

        foreach ($academicYears as $year) {
            AcademicYear::create($year);
        }
    }
}
