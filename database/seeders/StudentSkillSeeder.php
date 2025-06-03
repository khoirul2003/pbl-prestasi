<?php

namespace Database\Seeders;

use App\Models\StudentSkill;
use App\Models\DetailStudent;
use App\Models\Skill;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentSkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        StudentSkill::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $students = DetailStudent::all();
        $skills = Skill::all();


        if ($students->isEmpty() || $skills->isEmpty()) {
            $this->command->warn('DetailStudent or Skill table is empty. Skipping StudentSkill seeding.');
            return;
        }

        foreach ($students as $student) {
            $randomSkills = $skills->random(rand(1, 8));

            foreach ($randomSkills as $skill) {
                StudentSkill::firstOrCreate([
                    'detail_student_id' => $student->detail_student_id,
                    'skill_id' => $skill->skill_id,
                ]);
            }
        }
    }
}
