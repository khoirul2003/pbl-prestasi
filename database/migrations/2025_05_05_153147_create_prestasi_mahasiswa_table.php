<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('prestasi_mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mahasiswa_id');
            $table->string('kategori'); // misalnya akademik, teknologi, seni, dll.
            $table->string('deskripsi');
            $table->string('bukti_prestasi'); // bisa berupa URL file PDF/JPG/PNG
            $table->timestamps();

            $table->foreign('mahasiswa_id')->references('id')->on('mahasiswa_details')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestasi_mahasiswa');
    }
};
