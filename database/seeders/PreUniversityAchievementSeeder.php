<?php

namespace Database\Seeders;

use App\Models\PreUniversityAchievement;
use App\Models\Category;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class PreUniversityAchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        PreUniversityAchievement::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $faker = Faker::create();

        $students = User::where('role_id', 3)->get();
        $categories = Category::all();

        $totalAchievements = 40;

        $yearsWithWeights = [
            2018 => 1,
            2019 => 2,
            2020 => 3,
            2021 => 4
        ];

        $weightedYears = [];
        foreach ($yearsWithWeights as $year => $weight) {
            for ($w = 0; $w < $weight; $w++) {
                $weightedYears[] = $year;
            }
        }

        for ($i = 0; $i < $totalAchievements; $i++) {

            $student = $students->random();
            $category = $categories->random();

            $year = $faker->randomElement($weightedYears);
            $month = $faker->numberBetween(1, 12);
            $day = $faker->numberBetween(1, 28);

            $createdAt = Carbon::create($year, $month, $day)->toDateTimeString();

            PreUniversityAchievement::create([
                'user_id' => $student->user_id,
                'category_id' => $category ? $category->category_id : null,
                'pre_university_achievement_title' => $faker->sentence(5, true),
                'pre_university_achievement_description' => $faker->paragraph,
                'pre_university_achievement_ranking' => $faker->numberBetween(1, 3),
                'pre_university_achievement_level' => $faker->randomElement(['regional', 'nasional', 'internasional']),
                'pre_university_achievement_document' => null,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
        }
    }
}
