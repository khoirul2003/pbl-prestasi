@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Selamat datang, Mahasiswa!</h1>
        <p>Ini adalah halaman dashboard untuk mahasiswa. Anda dapat melihat prestasi yang telah dicatat dan lomba yang direkomendasikan untuk Anda.</p>

        <div class="card mt-4">
            <div class="card-header">
                Prestasi Anda
            </div>
            <div class="card-body">
                <p>Anda telah mencapai beberapa prestasi yang mengesankan selama studi Anda.</p>
                <!-- Daftar prestasi mahasiswa bisa ditampilkan di sini -->
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                Lomba yang Direkomendasikan
            </div>
            <div class="card-body">
                <p>Berikut adalah lomba-lomba yang kami rekomendasikan untuk Anda berdasarkan minat dan prestasi Anda:</p>
                <!-- Daftar lomba yang relevan bisa ditampilkan di sini -->
            </div>
        </div>
    </div>
@endsection
