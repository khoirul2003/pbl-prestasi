@extends('layout.app')

@section('title', 'Competition List')

@section('content')
<div class="container">
    <h1 class="mb-4">Competition List</h1>

    @if($competitions->isEmpty())
        <div class="alert alert-info">
            <p class="mb-0">No competitions are currently open.</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Competition Name</th>
                        <th>Category</th>
                        <th class="text-nowrap">Registration Period</th>
                        <th class="text-nowrap">Deadline</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($competitions as $competition)
                    <tr>
                        <td>{{ $competition->competition_tittle }}</td>
                        <td>
                            <span class="badge bg-primary">
                                {{ $competition->category->category_name ?? 'Category Not Available' }}
                            </span>
                        </td>
                        <td class="text-nowrap">
                            @if($competition->competition_registration_start)
                                {{ \Carbon\Carbon::parse($competition->competition_registration_start)->format('d M Y') }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="text-nowrap">
                            @if($competition->competition_registration_deadline)
                                {{ \Carbon\Carbon::parse($competition->competition_registration_deadline)->format('d M Y') }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.recommendations.show', $competition->competition_id) }}"
                               class="btn btn-primary btn-sm">
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
@endsection
