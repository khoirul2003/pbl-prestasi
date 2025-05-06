@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Selamat datang, Dosen!</h1>
        <p>Ini adalah halaman dashboard untuk dosen. Anda dapat melihat mahasiswa bimbingan Anda dan memberikan rekomendasi lomba.</p>

        <div class="card mt-4">
            <div class="card-header">
                Mahasiswa Bimbingan
            </div>
            <div class="card-body">
                <p>Berikut adalah daftar mahasiswa yang Anda bimbing:</p>
                <!-- Daftar mahasiswa bimbingan bisa ditampilkan di sini -->
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                Rekomendasi Lomba
            </div>
            <div class="card-body">
                <p>Anda dapat memberikan rekomendasi lomba untuk mahasiswa bimbingan Anda:</p>
                <!-- Form atau daftar lomba yang dapat direkomendasikan bisa ditampilkan di sini -->
            </div>
        </div>
    </div>
@endsection
