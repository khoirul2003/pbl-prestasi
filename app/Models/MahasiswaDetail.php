<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MahasiswaDetail extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'nim', 'program_studi', 'tanggal_lahir', 'alamat'];

    /**
     * Relasi dengan tabel user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi dengan tabel prestasi_mahasiswa
     */
    public function prestasiMahasiswa()
    {
        return $this->hasMany(PrestasiMahasiswa::class);
    }
}
