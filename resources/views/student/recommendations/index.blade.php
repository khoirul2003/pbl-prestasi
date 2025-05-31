@extends('layout.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Rekomendasi Lomba Untuk Anda</h2>

    @forelse ($recommendations as $rec)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $rec->competition->competition_name }}</h5>
                <p class="card-text">
                    Deadline: {{ $rec->competition->competition_registration_deadline }}<br>
                    Skor Rekomendasi: {{ $rec->recommendation_result_score }}
                </p>
                <a href="" class="btn btn-primary">
                    Lihat Detail
                </a>
            </div>
        </div>
    @empty
        <p>Tidak ada rekomendasi lomba saat ini.</p>
    @endforelse
</div>
@endsection
