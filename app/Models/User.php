<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'password', 'role'];

    /**
     * Relasi dengan tabel mahasiswa_detail
     */
    public function mahasiswaDetail()
    {
        return $this->hasOne(MahasiswaDetail::class);
    }

    /**
     * Relasi dengan tabel dosen_detail
     */
    public function dosenDetail()
    {
        return $this->hasOne(DosenDetail::class);
    }

    /**
     * Relasi dengan tabel prestasi_mahasiswa (jika mahasiswa)
     */
    public function prestasiMahasiswa()
    {
        return $this->hasMany(PrestasiMahasiswa::class);
    }
}
