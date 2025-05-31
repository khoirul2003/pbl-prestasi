<?php

namespace Database\Seeders;

use App\Models\Achievement;
use App\Models\Category;
use App\Models\User;
use Carbon\Carbon;
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

        $totalAchievements = 200;

        $yearsWithWeights = [
            2022 => 1,
            2023 => 2,
            2024 => 3,
            2025 => 4
        ];

        $weightedYears = [];
        foreach ($yearsWithWeights as $year => $weight) {
            for ($w = 0; $w < $weight; $w++) {
                $weightedYears[] = $year;
            }
        }

        $weights = [
            'approved' => 80,
            'pending' => 10,
            'rejected' => 10,
        ];

        // Fungsi memilih status achievement_verified dengan probabilitas bobot
        function weightedRandomStatus(array $weights)
        {
            $rand = mt_rand(1, array_sum($weights));
            $cumulative = 0;
            foreach ($weights as $status => $weight) {
                $cumulative += $weight;
                if ($rand <= $cumulative) {
                    return $status;
                }
            }
            return null; // fallback, seharusnya tidak terjadi
        }

        for ($i = 0; $i < $totalAchievements; $i++) {

            $student = $students->random();
            $category = $categories->random();

            $year = $faker->randomElement($weightedYears);
            $month = $faker->numberBetween(1, 12);
            $day = $faker->numberBetween(1, 28);

            $createdAt = Carbon::create($year, $month, $day)->toDateTimeString();

            Achievement::create([
                'user_id' => $student->user_id,
                'category_id' => $category->category_id,
                'achievement_title' => $faker->sentence(5, true),
                'achievement_description' => $faker->paragraph,
                'achievement_ranking' => $faker->numberBetween(1, 6),
                'achievement_level' => $faker->randomElement(['regional', 'nasional', 'internasional']),
                'achievement_document' => null,
                'achievement_verified' => weightedRandomStatus($weights),
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
        }
    }
}
