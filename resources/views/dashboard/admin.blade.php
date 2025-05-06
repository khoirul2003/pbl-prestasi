@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Dashboard Admin</h1>
        <p>Selamat datang, Admin! Anda dapat mengelola sistem ini di sini.</p>

        <!-- Manajemen Pengguna -->
        <div class="card mt-4">
            <div class="card-header">
                Manajemen Pengguna
            </div>
            <div class="card-body">
                <a href="{{ route('admin.users') }}" class="btn btn-primary">Kelola Pengguna</a>
            </div>
        </div>

        <!-- Manajemen Lomba -->
        <div class="card mt-4">
            <div class="card-header">
                Manajemen Lomba
            </div>
            <div class="card-body">
                <a href="{{ route('admin.competitions') }}" class="btn btn-primary">Kelola Lomba</a>
            </div>
        </div>

        <!-- Laporan Prestasi Mahasiswa -->
        <div class="card mt-4">
            <div class="card-header">
                Laporan Prestasi Mahasiswa
            </div>
            <div class="card-body">
                <a href="{{ route('admin.reports') }}" class="btn btn-primary">Lihat Laporan</a>
            </div>
        </div>
    </div>
@endsection
