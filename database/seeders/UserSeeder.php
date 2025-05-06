<?php

namespace Database\Seeders;

use App\Models\DosenDetail;
use App\Models\MahasiswaDetail;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@domain.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Seeder untuk Mahasiswa
        $mahasiswa = User::create([
            'name' => 'Mahasiswa User',
            'email' => 'mahasiswa@domain.com',
            'password' => Hash::make('password123'),
            'role' => 'mahasiswa',
        ]);

        // Menambahkan detail mahasiswa
        MahasiswaDetail::create([
            'user_id' => $mahasiswa->id,
            'nim' => '1234567890',
            'program_studi' => 'Teknik Informatika',
            'tanggal_lahir' => '2000-01-01',
            'alamat' => 'Jl. Contoh Mahasiswa No. 123',
        ]);

        // Seeder untuk Dosen
        $dosen = User::create([
            'name' => 'Dosen User',
            'email' => 'dosen@domain.com',
            'password' => Hash::make('password123'),
            'role' => 'dosen',
        ]);

        // Menambahkan detail dosen
        DosenDetail::create([
            'user_id' => $dosen->id,
            'nip' => '9876543210',
            'program_studi' => 'Teknik Informatika',
            'jabatan' => 'Dosen Senior',
        ]);
    }
}
