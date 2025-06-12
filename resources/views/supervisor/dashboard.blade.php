@extends('layout.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold">Welcome, Supervisor {{ $supervisor->user->user_name }}</h2>

    <!-- Row: Supervision Stats (Students Supervised + Competitions Supervised) -->
    <div class="row mb-4">
        <!-- Number of Students Supervised -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-warning text-white fw-bold">
                    Students Under Your Supervision
                </div>
                <div class="card-body">
                    <p class="h4">{{ $studentsUnderSupervisionCount }}</p>
                </div>
            </div>
        </div>

        <!-- Number of Competitions Supervised -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-primary text-white fw-bold">
                    Competitions You Are Mentoring
                </div>
                <div class="card-body">
                    <p class="h4">{{ $competitionsUnderMentorshipCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Row: Student Rankings + Open Competitions -->
    <div class="row mb-4">
        <!-- Student Rankings -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-info text-white fw-bold">
                    Top Student Rankings
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Rank</th>
                                <th>Student Name</th>
                                <th>Achievements</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($studentRankings as $rank => $student)
                                <tr>
                                    <td>{{ $rank + 1 }}</td>
                                    <td>{{ $student->user_name }}</td>
                                    <td>{{ $student->achievement_count }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Open Competitions -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-success text-white fw-bold">
                    Competitions with Open Registration
                </div>
                <div class="card-body">
                    @if($openCompetitions->count())
                        <ul class="list-group list-group-flush">
                            @foreach($openCompetitions as $competition)
                                <li class="list-group-item">
                                    <strong>{{ $competition->competition_tittle }}</strong><br>
                                    <small class="text-muted">Deadline: {{ \Carbon\Carbon::parse($competition->competition_registration_deadline)->format('d M Y') }}</small>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">No competitions with open registration.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
