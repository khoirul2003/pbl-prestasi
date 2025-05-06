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
        Schema::create('rekomendasi_lomba', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prestasi_mahasiswa_id');
            $table->unsignedBigInteger('lomba_id');
            $table->timestamps();

            $table->foreign('prestasi_mahasiswa_id')->references('id')->on('prestasi_mahasiswa')->onDelete('cascade');
            $table->foreign('lomba_id')->references('id')->on('lomba')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekomendasi_lomba');
    }
};
