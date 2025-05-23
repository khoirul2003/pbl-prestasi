<?php

namespace Database\Seeders;

use App\Models\Achievement;
use App\Models\Category;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Achievement::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $faker = Faker::create();

        $students = User::where('role_id', 3)->get();
        $categories = Category::all();

        $totalAchievements = 80;

        $years = [2022, 2023, 2024, 2025];

        for ($i = 0; $i < $totalAchievements; $i++) {

            $student = $students->random();
            $category = $categories->random();

            $year = $faker->randomElement($years);
            $month = $faker->numberBetween(1, 12);
            $day = $faker->numberBetween(1, 28);

            $createdAt = Carbon::create($year, $month, $day)->toDateTimeString();

            Achievement::create([
                'user_id' => $student->user_id,
                'category_id' => $category->category_id,
                'achievement_title' => $faker->sentence(5, true),
                'achievement_description' => $faker->paragraph,
                'achievement_ranking' => $faker->numberBetween(1, 3),
                'achievement_level' => $faker->randomElement(['regional', 'nasional', 'internasional']),
                'achievement_document' => null,
                'achievement_verified' => $faker->randomElement(['approved', 'rejected', 'pending']),
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
        }
    }
}
