<?php

namespace Database\Seeders;

use App\Models\StudyProgram;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudyProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        StudyProgram::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        StudyProgram::create(['department_id'=> 1, 'study_program_name' => 'D-IV Teknik Informatika']);
        StudyProgram::create(['department_id'=> 1, 'study_program_name' => 'D-IV Sistem Informasi Bisnis']);
        StudyProgram::create(['department_id'=> 1, 'study_program_name' => 'D-II PPLS']);
    }
}
