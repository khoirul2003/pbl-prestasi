<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekomendasiLomba extends Model
{
    use HasFactory;

    protected $fillable = ['prestasi_mahasiswa_id', 'lomba_id'];

    /**
     * Relasi dengan tabel prestasi_mahasiswa
     */
    public function prestasiMahasiswa()
    {
        return $this->belongsTo(PrestasiMahasiswa::class, 'prestasi_mahasiswa_id');
    }

    /**
     * Relasi dengan tabel lomba
     */
    public function lomba()
    {
        return $this->belongsTo(Lomba::class);
    }
}
