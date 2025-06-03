<?php

namespace Database\Seeders;

use App\Models\DetailSupervisor;
use App\Models\Skill;
use App\Models\SupervisorSkill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupervisorSkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        SupervisorSkill::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $supervisors = DetailSupervisor::all();
        $skills = Skill::all();


        if ($supervisors->isEmpty() || $skills->isEmpty()) {
            $this->command->warn('DetailSupervisor or Skill table is empty. Skipping SupervisorSkill seeding.');
            return;
        }

        foreach ($supervisors as $supervisor) {
            $randomSkills = $skills->random(rand(1, 8));

            foreach ($randomSkills as $skill) {
                SupervisorSkill::firstOrCreate([
                    'detail_supervisor_id' => $supervisor->detail_supervisor_id,
                    'skill_id' => $skill->skill_id,
                ]);
            }
        }
    }
}
