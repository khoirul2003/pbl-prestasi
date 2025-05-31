<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Category::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Category::create(['category_name' => 'Innovation & Technology']);
        Category::create(['category_name' => 'Business & Entrepreneurship']);
        Category::create(['category_name' => 'Design & Creative Arts']);
        Category::create(['category_name' => 'E-Sports & Gaming']);
        Category::create(['category_name' => 'Academic & Research']);
        Category::create(['category_name' => 'Arts & Culture']);
        Category::create(['category_name' => 'Sports']);
        Category::create(['category_name' => 'Leadership & Organization']);
        Category::create(['category_name' => 'Social & Environmental']);
    }
}
