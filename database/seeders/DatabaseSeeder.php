<?php

namespace Database\Seeders;

use App\Models\Achievement;
use App\Models\DetailStudent;
use App\Models\StudentSkill;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            AcademicYearSeeder::class,
            PeriodSeeder::class,
            DepartmentSeeder::class,
            StudyProgramSeeder::class,
            UserSeeder::class,
            DetailStudentSeeder::class,
            DetailSupervisorSeeder::class,
            CategorySeeder::class,
            CompetitionSeeder::class,
            StudentPeriodSeeder::class,
            SkillSeeder::class,
            StudentSkillSeeder::class,
            AchievementSeeder::class,
            PreUniversityAchievementSeeder::class
        ]);
    }
}
