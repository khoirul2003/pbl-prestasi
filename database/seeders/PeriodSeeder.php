<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\Period;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $academicYears = AcademicYear::all();

        foreach ($academicYears as $academicYear) {
            Period::create([
                'academic_year_id' => $academicYear->academic_year_id,
                'period_name'      => 'Ganjil ' . $academicYear->academic_year,
                'start_date'       => $academicYear->start_date,
                'end_date'         => date('Y-m-d', strtotime($academicYear->start_date . ' +4 months')),
            ]);

            Period::create([
                'academic_year_id' => $academicYear->academic_year_id,
                'period_name'      => 'Genap ' . $academicYear->academic_year,
                'start_date'       => date('Y-m-d', strtotime($academicYear->start_date . ' +5 months')),
                'end_date'         => $academicYear->end_date,
            ]);
        }
    }
}
