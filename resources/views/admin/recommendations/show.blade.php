@extends('layout.app')

@section('content')

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h4 class="card-title mb-4">
                Competition Recommendation Results: <strong>{{ $competition->competition_name }}</strong>
            </h4>

            @if ($results->isEmpty())
                <div class="alert alert-warning">
                    No recommendation data available.
                </div>
            @else
            <div class="mb-3 d-flex justify-content-end">

                <a href="{{ route('admin.recommendations.exportPdf', ['competitionId' => $competition->competition_id]) }}"
                   class="btn btn-danger mr-2">
                    <i class="bi bi-file-earmark-pdf"></i> Export to PDF
                </a>

                <a href="{{ route('admin.recommendations.export', ['competition' => $competition->competition_id]) }}"
                   class="btn btn-success">
                    <i class="bi bi-file-earmark-excel"></i> Export to Excel
                </a>
            </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No.</th>
                                <th>Student Name</th>
                                <th>Competition</th>
                                <th>Category</th>
                                <th>Supervisor</th>
                                <th>MOORA Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($results as $index => $result)
                                @php
                                    $student = $result['student'];
                                    $recommendation = \App\Models\RecommendationResult::where(
                                        'competition_id',
                                        $competition->competition_id,
                                    )
                                        ->where('user_id', $student->user_id)
                                        ->first();
                                    $supervisor = $recommendation?->supervisor;
                                    $hasSupervisor = $supervisor !== null;
                                @endphp
                                <tr @class(['table-success' => $hasSupervisor])>
                                    <td>{{ $results->firstItem() + $index }}</td>
                                    <td>{{ $student->user_name }}</td>
                                    <td>{{ $competition->competition_tittle }}</td>
                                    <td>{{ $competition->category->category_name ?? 'N/A' }}</td>
                                    <td>
                                        @if ($supervisor)
                                            {{ $supervisor->user->user_name ?? '-' }}
                                        @else
                                            <span class="text-muted">Not assigned</span>
                                        @endif
                                    </td>
                                    <td>{{ $result['score'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $results->links() }}
                </div>
            @endif

            <a href="{{ route('admin.recommendations.index') }}" class="btn btn-outline-primary mt-3">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>

@endsection
