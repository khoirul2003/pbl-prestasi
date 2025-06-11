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
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Achievement::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $faker = Faker::create('id_ID');
        $students = User::where('role_id', 3)->get();
        $categories = Category::all();

        $titlesByCategory = [
            'Innovation & Technology' => [
                'Inovasi Smart Farming Berbasis IoT' => 'Mengembangkan sistem pertanian cerdas berbasis IoT yang memantau kelembapan tanah dan suhu udara secara real-time untuk meningkatkan produktivitas petani lokal.',
                'Aplikasi Deteksi Banjir Otomatis' => 'Membuat sistem pendeteksi banjir yang mengirimkan notifikasi ke warga melalui aplikasi seluler saat permukaan air sungai mulai meningkat secara drastis.'
            ],
            'Business & Entrepreneurship' => [
                'Juara Lomba Business Plan Nasional' => 'Merancang bisnis sosial berupa platform digital yang mempertemukan UMKM dengan investor mikro, untuk membantu pertumbuhan ekonomi berbasis komunitas.',
                'Start-Up Inkubasi Digital UMKM' => 'Berpartisipasi dalam inkubator start-up untuk mengembangkan sistem POS berbasis cloud yang menyederhanakan manajemen stok dan laporan penjualan untuk UMKM kecil.'
            ],
            'Design & Creative Arts' => [
                'Finalis Kompetisi Desain UI/UX Nasional' => 'Merancang tampilan antarmuka aplikasi donasi darah yang memudahkan pengguna menemukan lokasi donor terdekat dan melakukan registrasi dengan cepat.',
                'Pemenang Lomba Ilustrasi Digital' => 'Membuat ilustrasi bertema pelestarian lingkungan untuk kampanye sosial yang digunakan dalam berbagai media cetak dan digital oleh NGO lingkungan.'
            ],
            'E-Sports & Gaming' => [
                'Juara Turnamen MLBB Nasional' => 'Memimpin tim dalam kompetisi nasional Mobile Legends, menunjukkan strategi permainan dan komunikasi tim yang solid hingga menjuarai babak final.',
                'Top Valorant College Championship' => 'Menjadi anggota tim universitas yang berhasil mencapai posisi lima besar dalam kompetisi e-sports Valorant tingkat nasional antarperguruan tinggi.'
            ],
            'Academic & Research' => [
                'Publikasi Jurnal Ilmiah Nasional' => 'Meneliti pengaruh metode flipped classroom terhadap hasil belajar mahasiswa Teknik Informatika, diterbitkan di jurnal pendidikan bereputasi.',
                'Juara Olimpiade Fisika Mahasiswa' => 'Meraih medali emas dalam kompetisi olimpiade fisika tingkat nasional dengan topik soal mekanika klasik dan elektromagnetik lanjutan.'
            ],
            'Arts & Culture' => [
                'Juara Festival Tari Nusantara' => 'Menampilkan Tari Piring dalam festival budaya tingkat nasional, dengan koreografi kolaboratif dan kostum autentik dari daerah Minangkabau.',
                'Musikalisasi Puisi Pemenang Nasional' => 'Mewakili kampus dalam lomba musikalisasi puisi bertema perjuangan, menyatukan syair, musik dan narasi visual dalam sebuah pertunjukan.'
            ],
            'Sports' => [
                'Medali Perak Kejuaraan Atletik Mahasiswa' => 'Meraih posisi kedua pada lomba lari jarak 400 meter putra di kejuaraan atletik nasional mahasiswa antar PTN dan PTS.',
                'Juara Pencak Silat Antar Kampus' => 'Memenangkan kompetisi pencak silat kelas B putri tingkat nasional, dengan teknik kuncian dan stamina yang unggul selama tiga babak penuh.'
            ],
            'Leadership & Organization' => [
                'Ketua BEM Periode 2024' => 'Memimpin organisasi mahasiswa fakultas dalam menyelenggarakan program kerja tahunan seperti seminar nasional, pelatihan soft skill, dan advokasi kebijakan kampus.',
                'Delegasi Forum Kepemudaan ASEAN' => 'Mewakili Indonesia dalam forum kepemudaan ASEAN untuk membahas kolaborasi lintas negara dalam isu pendidikan dan kesetaraan akses digital.'
            ],
            'Social & Environmental' => [
                'Program Bank Sampah Kampus' => 'Menginisiasi dan memimpin proyek bank sampah kampus dengan melibatkan lebih dari 300 mahasiswa, menghasilkan 1 ton limbah organik dan anorganik terkelola tiap bulan.',
                'Pemenang Eco Green Project Challenge' => 'Mempresentasikan proyek pengolahan limbah rumah tangga menjadi briket bahan bakar dalam kompetisi inovasi lingkungan tingkat nasional.'
            ],
        ];

        $yearsWithWeights = [
            2022 => 1,
            2023 => 2,
            2024 => 3,
            2025 => 4
        ];

        $weightedYears = [];
        foreach ($yearsWithWeights as $year => $weight) {
            for ($i = 0; $i < $weight; $i++) {
                $weightedYears[] = $year;
            }
        }

        $statusWeights = ['approved' => 80, 'pending' => 10, 'rejected' => 10];

        function weightedStatus($weights)
        {
            $rand = mt_rand(1, array_sum($weights));
            $total = 0;
            foreach ($weights as $key => $value) {
                $total += $value;
                if ($rand <= $total) return $key;
            }
            return 'pending';
        }

        foreach ($titlesByCategory as $categoryName => $entries) {
            $category = Category::where('category_name', $categoryName)->first();
            foreach ($entries as $title => $description) {
                $student = $students->random();
                $year = $faker->randomElement($weightedYears);
                $date = Carbon::create($year, rand(1, 12), rand(1, 28));
                Achievement::create([
                    'user_id' => $student->user_id,
                    'category_id' => $category->category_id,
                    'achievement_title' => $title,
                    'achievement_description' => $description,
                    'achievement_ranking' => $faker->numberBetween(1, 3),
                    'achievement_level' => $faker->randomElement(['regional', 'nasional', 'internasional']),
                    'achievement_document' => null,
                    'achievement_verified' => weightedStatus($statusWeights),
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);
            }
        }
    }
}
