<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrestasiMahasiswa extends Model
{
    use HasFactory;

    protected $fillable = ['mahasiswa_id', 'kategori', 'deskripsi', 'bukti_prestasi'];

    /**
     * Relasi dengan tabel mahasiswa_detail
     */
    public function mahasiswaDetail()
    {
        return $this->belongsTo(MahasiswaDetail::class, 'mahasiswa_id');
    }

    /**
     * Relasi dengan tabel rekomendasi_lomba
     */
    public function rekomendasiLomba()
    {
        return $this->hasMany(RekomendasiLomba::class);
    }
}
