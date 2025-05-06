@extends('layouts.app')

@section('content')
    <h2>Selamat datang, {{ Auth::user()->name }}!</h2>
    <p>Ini adalah halaman dashboard Anda. Anda berhasil login.</p>

    <div>
        <a href="{{ route('prestasi.index') }}">Lihat Prestasi</a>
    </div>
@endsection
