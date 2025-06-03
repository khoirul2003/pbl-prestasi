@extends('layout.app')


@section('content')
    <div class="card shadow-sm rounded-3 mb-4">
        <div class="card-body">
            <h4 class="card-title mb-4">Recommendation Student</h4>

            @if ($competitions->isEmpty())
                <div class="alert alert-info">
                    <p class="mb-0">No competitions are currently open.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table  table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Competition Name</th>
                                <th>Category</th>
                                <th class="text-nowrap">Registration Start</th>
                                <th class="text-nowrap">Registration Deadline</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($competitions as $competition)
                                <tr>
                                    <td>{{ $competition->competition_tittle }}</td>
                                    <td>
                                        <span class="badge bg-primary">
                                            {{ $competition->category->category_name ?? 'Category Not Available' }}
                                        </span>
                                    </td>
                                    <td class="text-nowrap">
                                        {{ $competition->competition_registration_start
                                            ? \Carbon\Carbon::parse($competition->competition_registration_start)->format('d M Y')
                                            : '-' }}
                                    </td>
                                    <td class="text-nowrap">
                                        {{ $competition->competition_registration_deadline
                                            ? \Carbon\Carbon::parse($competition->competition_registration_deadline)->format('d M Y')
                                            : '-' }}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.recommendations.show', $competition->competition_id) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="bi bi-eye"></i> View Recommendations
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

@endsection
