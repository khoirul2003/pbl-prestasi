<?php

namespace Database\Seeders;

use App\Models\RecommendationResult;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecomendationResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        RecommendationResult::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
