@extends('layout.app')

@section('content')
<div class="container py-1">
    <h2 class="mb-4 sticky-top" style=" padding: 10px 0;">Recommended Competitions for You</h2>

    {{-- Display a message if no recommendations or students under supervision --}}
    @if (isset($message))
        <div class="alert alert-info">
            {{ $message }}
        </div>
    @endif

    {{-- Check if there are no recommendations or supervised students --}}
    @if($recommendations->isEmpty())
        <div class="alert alert-info">
            @if (isset($message))
                No students are currently under your supervision or no recommendations have been made.
            @else
                No recommendations available for your students.
            @endif
        </div>
    @else
        {{-- Scrollable recommendations container --}}
        <div class="recommendations-container" style="max-height: 400px; overflow-y: auto;">
            <div class="row">
                @foreach ($recommendations as $rec)
                    <div class="col-12 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">{{ $rec->competition->competition_tittle }}</h5>

                                {{-- Display student's name --}}
                                <p><strong>Student:</strong> {{ $rec->user->user_name }}</p>

                                <p class="card-text">
                                    <strong>Deadline:</strong> {{ \Carbon\Carbon::parse($rec->competition->competition_registration_deadline)->format('F d, Y') }}<br>
                                    <strong>Recommendation Score:</strong> {{ number_format($rec->recommendation_result_score, 2) }}
                                </p>
                                <p class="card-text">
                                    {{ $rec->competition->competition_description }}
                                </p>

                                @if ($rec->competition->competition_registration_link)
                                    <a href="{{ $rec->competition->competition_registration_link }}" target="_blank" class="btn btn-outline-primary">
                                        Visit Competition Link
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>
@endsection
