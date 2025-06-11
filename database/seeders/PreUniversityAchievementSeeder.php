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

        $faker = Faker::create('id_ID');
        $students = User::where('role_id', 3)->get(); // asumsi: 3 adalah student
        $categories = Category::all();

        $achievementTitles = [
            'Olimpiade Sains Nasional (OSN)',
            'Festival Inovasi dan Kewirausahaan Siswa Indonesia (FIKSI)',
            'Lomba Cerdas Cermat 4 Pilar Kebangsaan',
            'Lomba Debat Bahasa Indonesia',
            'Lomba Poster Digital Nasional',
            'Kompetisi Sains Madrasah (KSM)',
            'Lomba Karya Ilmiah Remaja (LKIR)',
            'Lomba Robotika Nasional',
            'Lomba Menulis Cerpen',
            'Lomba Karya Tulis Ilmiah Pelajar (LKTIP)',
            'National English Olympics',
            'Lomba Fotografi Pelajar',
            'Lomba Vlog Pendidikan',
            'Lomba Mading 3D',
            'Kompetisi Matematika Nalaria Realistik (KMNR)',
            'National Science Fair',
            'Lomba Design Poster Edukasi',
            'Youth Innovation Festival',
            'Lomba Pidato Bahasa Inggris',
            'Hackathon Pelajar Indonesia',
            'National Business Plan Competition for High School',
            'National History Olympiad',
            'Lomba Tari Tradisional Nasional',
            'Lomba Musik Akustik Pelajar',
            'Lomba Cipta Puisi',
            'Lomba Cerdas Tangkas Pramuka',
            'Lomba Inovasi Teknologi Sederhana',
            'Lomba Kewirausahaan Siswa',
            'Lomba Essay Nasional Siswa',
            'Lomba Baca Puisi Online',
            'Lomba Olimpiade Biologi Indonesia',
            'Lomba Desain Batik Digital',
            'Lomba App Development Pelajar',
            'Festival Film Pelajar Indonesia',
            'Lomba Short Movie Edukasi',
            'Olimpiade Informatika Pelajar',
            'National Debate Championship',
            'Lomba Desain Interior Miniatur Sekolah',
            'Lomba Kreasi Barang Bekas',
            'Lomba Infografis Pelajar',
            'Olimpiade Ekonomi Nasional',
            'Lomba Fisika Terapan',
            'Lomba Drama Pendidikan',
            'Kompetisi Esai Kebangsaan',
            'Olimpiade Kimia Indonesia',
            'Lomba Video Edukasi Pencegahan Narkoba',
            'Lomba Mobile Photography',
            'Olimpiade Astronomi Siswa',
            'Lomba Poster Kesetaraan Gender',
            'Lomba Sains Interaktif',
            'Lomba Presentasi Bahasa Jepang',
            'Festival Teknologi Ramah Lingkungan',
            'Lomba Karya Sastra Digital',
            'Lomba Short Story Writing',
            'Lomba Penelitian Siswa Nasional',
            'Lomba Cipta Lagu Bertema Pendidikan',
            'Olimpiade Geografi Siswa',
            'Lomba IT Networking Siswa'
        ];

        $yearsWithWeights = [
            2018 => 1,
            2019 => 2,
            2020 => 3,
            2021 => 4
        ];

        $weightedYears = [];
        foreach ($yearsWithWeights as $year => $weight) {
            for ($i = 0; $i < $weight; $i++) {
                $weightedYears[] = $year;
            }
        }

        for ($i = 0; $i < 60; $i++) {
            $student = $students->random();
            $category = $categories->random();

            $year = $faker->randomElement($weightedYears);
            $month = $faker->numberBetween(1, 12);
            $day = $faker->numberBetween(1, 28);
            $createdAt = Carbon::create($year, $month, $day)->toDateTimeString();

            PreUniversityAchievement::create([
                'user_id' => $student->user_id,
                'category_id' => $category->category_id ?? null,
                'pre_university_achievement_title' => $faker->randomElement($achievementTitles),
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
