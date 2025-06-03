<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Competition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class CompetitionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Competition::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $faker = Faker::create();

        $categories = Category::all();

        for ($i = 1; $i <= 10; $i++) {
            $category = $categories->random();

            $title = $faker->words(3, true) . ' ' . $category->category_name;

            Competition::create([
                'category_id' => $category->category_id,
                'competition_tittle' => $title,
                'competition_description' => $faker->paragraph,
                'competition_organizer' => $faker->company,
                'competition_level' => $faker->randomElement(['regional', 'nasional', 'internasional']),
                'competition_registration_start' => $faker->dateTimeBetween('now', '+2 months')->format('Y-m-d'),
                'competition_registration_deadline' => $faker->dateTimeBetween('now', '+2 months')->format('Y-m-d'),
                'competition_registion_link' => $faker->url,
                'competition_document' => null,
            ]);
        }
    }
}
