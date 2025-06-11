<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Competition;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class CompetitionSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Competition::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $faker = Faker::create('id_ID');
        $categories = Category::all();

        $realCompetitions = [
            [
                'title' => 'Gemastik',
                'organizer' => 'Kemendikbud & Telkom University',
                'description' => 'Kompetisi nasional untuk mahasiswa di bidang TIK meliputi pemrograman, keamanan siber, desain UI/UX, dan lainnya.'
            ],
            [
                'title' => 'Olimpiade Sains Nasional (OSN)',
                'organizer' => 'Puspresnas Kemendikbud',
                'description' => 'Kompetisi sains tingkat nasional bagi pelajar dan mahasiswa di bidang matematika, fisika, kimia, biologi, dan komputer.'
            ],
            [
                'title' => 'Hackathon Merdeka',
                'organizer' => 'Code4Nation & Kominfo',
                'description' => 'Ajang lomba membangun solusi digital untuk permasalahan publik melalui coding dalam waktu terbatas.'
            ],
            [
                'title' => 'National Business Plan Competition',
                'organizer' => 'Universitas Indonesia',
                'description' => 'Kompetisi merancang rencana bisnis inovatif untuk mahasiswa tingkat nasional.'
            ],
            [
                'title' => 'KMI Expo',
                'organizer' => 'Kemendikbud Dikti',
                'description' => 'Kompetisi dan pameran karya kewirausahaan mahasiswa dari seluruh Indonesia.'
            ],
            [
                'title' => 'Indonesia Robot Contest (KRI)',
                'organizer' => 'Pusat Prestasi Nasional (Puspresnas)',
                'description' => 'Kompetisi robot antar mahasiswa dengan berbagai kategori seperti robot ABU, pemadam api, dan sepak bola.'
            ],
            [
                'title' => 'UI/UX Design Challenge',
                'organizer' => 'Dicoding & Baparekraf Digital Talent',
                'description' => 'Lomba desain antarmuka dan pengalaman pengguna aplikasi digital.'
            ],
            [
                'title' => 'National IT Festival',
                'organizer' => 'Institut Teknologi Sepuluh Nopember (ITS)',
                'description' => 'Festival dan kompetisi bidang teknologi informasi skala nasional.'
            ],
            [
                'title' => 'PKM (Program Kreativitas Mahasiswa)',
                'organizer' => 'Ditjen Belmawa Kemendikbud',
                'description' => 'Kompetisi ide kreatif mahasiswa dalam bidang penelitian, pengabdian masyarakat, teknologi, dan lainnya.'
            ],
            [
                'title' => 'Digital Innovation Challenge',
                'organizer' => 'Baparekraf & Microsoft Indonesia',
                'description' => 'Kompetisi inovasi digital untuk meningkatkan daya saing UMKM dan sektor kreatif.'
            ]
        ];

        foreach ($realCompetitions as $comp) {
            $category = $categories->random();
            $title = $comp['title'] . ' - ' . $category->category_name;

            Competition::create([
                'category_id' => $category->category_id,
                'competition_tittle' => $title,
                'competition_description' => $comp['description'],
                'competition_organizer' => $comp['organizer'],
                'competition_level' => $faker->randomElement(['regional', 'nasional', 'internasional']),
                'competition_registration_start' => $faker->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
                'competition_registration_deadline' => $faker->dateTimeBetween('+1 month', '+2 months')->format('Y-m-d'),
                'competition_registration_link' => $faker->url,
                'competition_document' => null,
            ]);
        }
    }
}
