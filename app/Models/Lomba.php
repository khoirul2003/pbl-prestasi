<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lomba extends Model
{
    use HasFactory;

    protected $fillable = ['nama_lomba', 'kategori', 'penyelenggara', 'tanggal_pendaftaran_mulai', 'tanggal_pendaftaran_selesai'];

    /**
     * Relasi dengan tabel rekomendasi_lomba
     */
    public function rekomendasiLomba()
    {
        return $this->hasMany(RekomendasiLomba::class);
    }
}
