@extends('layout.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Recommended Competitions for You</h2>

    @forelse ($recommendations as $rec)
        <div class="card mb-4 shadow-sm">
            <div class="row g-0">
                {{-- Left side: Competition document preview --}}
                <div class="col-md-4">
                    @if (!empty($rec->competition->competition_document))
                        <img src="{{ asset($rec->competition->competition_document) }}"
                             alt="Competition Document"
                             class="img-fluid h-100 object-fit-cover"
                             style="min-height: 250px; max-height: 250px; width: 100%; object-fit: cover;">
                    @else
                        <div class="d-flex align-items-center justify-content-center h-100 text-muted bg-light"
                             style="min-height: 250px;">
                            No document available
                        </div>
                    @endif
                </div>


                {{-- Right side: Competition details --}}
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">{{ $rec->competition->competition_tittle ?? 'Untitled Competition' }}</h5>
                        <p class="card-text">
                            <strong>Deadline:</strong>
                            {{ \Carbon\Carbon::parse($rec->competition->competition_registration_deadline)->format('F d, Y') }}<br>

                            <strong>Recommendation Score:</strong>
                            {{ number_format($rec->recommendation_result_score, 2) }}<br>

                            <strong>Supervisor:</strong>
                            {{ $rec->supervisor && $rec->supervisor->user ? $rec->supervisor->user->user_name : 'Not Assigned' }}
                        </p>

                        <p class="card-text">
                            {{ $rec->competition->competition_description }}
                        </p>

                        @if (!empty($rec->competition->competition_registration_link))
                            <a href="{{ $rec->competition->competition_registration_link }}" target="_blank" class="btn btn-outline-primary">
                                Visit Competition Link
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-info">
            No competition recommendations available at the moment.
        </div>
    @endforelse
</div>
@endsection
