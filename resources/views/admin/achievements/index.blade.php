@extends('layout.app')

@section('content')
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h4 class="card-title mb-4">Achievements List</h4>

        {{-- Success Message --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Filter Tabs --}}
        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <a class="nav-link {{ request('status') == null ? 'active' : '' }}"
                    href="{{ route('achievements.index') }}">
                    <i class="bi bi-list"></i> All Achievements
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'pending' ? 'active' : '' }}"
                    href="{{ route('achievements.index', ['status' => 'pending']) }}">
                    <i class="bi bi-clock"></i> Pending
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'processed' ? 'active' : '' }}"
                    href="{{ route('achievements.index', ['status' => 'processed']) }}">
                    <i class="bi bi-check-circle"></i> Processed
                </a>
            </li>
        </ul>

        {{-- Achievements Table --}}
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No.</th>
                        <th>Student</th>
                        <th>Title</th>
                        <th>Ranking</th>
                        <th>Level</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($achievements as $index => $achievement)
                        <tr>
                            <td>{{ $index + $achievements->firstItem() }}</td>
                            <td>{{ $achievement->user->user_name ?? '-' }}</td>
                            <td>{{ $achievement->achievement_title }}</td>
                            <td>{{ $achievement->achievement_ranking }}</td>
                            <td>{{ ucfirst($achievement->achievement_level) }}</td>
                            <td>
                                @if ($achievement->achievement_verified == 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif ($achievement->achievement_verified == 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @elseif ($achievement->achievement_verified == 'rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </td>
                            <td class="d-flex gap-1">
                                {{-- Show Modal --}}
                                <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#showModal{{ $achievement->achievement_id }}">
                                    <i class="bi bi-eye"></i> Show
                                </button>

                                @if ($achievement->achievement_verified == 'pending')
                                    <form action="{{ route('achievements.approve', $achievement->achievement_id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm"
                                            onclick="return confirm('Approve this achievement?')">
                                            <i class="bi bi-check"></i> Approve
                                        </button>
                                    </form>

                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#rejectModal{{ $achievement->achievement_id }}">
                                        <i class="bi bi-x-circle"></i> Reject
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No achievements found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $achievements->links() }}
        </div>
    </div>
</div>

{{-- Modals --}}
@foreach ($achievements as $achievement)
    @include('admin.achievements.modals.show')
    @include('admin.achievements.modals.reject')
@endforeach

@endsection
