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
                <a class="nav-link {{ request('status') == null ? 'active' : '' }}" href="{{ route('achievements.index') }}">
                    <i class="bi bi-list"></i> All Achievements
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'pending' ? 'active' : '' }}" href="{{ route('achievements.index', ['status' => 'pending']) }}">
                    <i class="bi bi-clock"></i> Pending Achievements
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'processed' ? 'active' : '' }}" href="{{ route('achievements.index', ['status' => 'processed']) }}">
                    <i class="bi bi-check-circle"></i> Processed Achievements
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
                                    <span class="badge badge-warning">Pending</span>
                                @elseif ($achievement->achievement_verified == 'approved')
                                    <span class="badge badge-success">Approved</span>
                                @elseif ($achievement->achievement_verified == 'rejected')
                                    <span class="badge badge-danger">Rejected</span>
                                @endif
                            </td>
                            <td class="d-flex gap-1">
                                <a href="{{ route('achievements.show', $achievement->achievement_id) }}" class="btn btn-secondary btn-sm btn-rounded btn-fw">
                                    <i class="bi bi-eye"></i> Show
                                </a>

                                @if ($achievement->achievement_verified == 'pending')
                                    <form action="{{ route('achievements.approve', $achievement->achievement_id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm btn-rounded btn-fw" onclick="return confirm('Approve this achievement?')">
                                            <i class="bi bi-check"></i> Approve
                                        </button>
                                    </form>
                                    <form action="#" method="POST" class="d-inline" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $achievement->achievement_id }}">
                                        @csrf
                                        <button type="button" class="btn btn-danger btn-sm btn-rounded btn-fw">
                                            <i class="bi bi-x-circle"></i> Reject
                                        </button>
                                    </form>
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

{{-- Reject Modal for each Achievement --}}
@foreach ($achievements as $achievement)
    <div class="modal fade" id="rejectModal{{ $achievement->achievement_id }}" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('achievements.reject', $achievement->achievement_id) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="rejectModalLabel">Reject Achievement</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="rejectionDescription" class="form-label">Rejection Description</label>
                            <textarea class="form-control" id="rejectionDescription" name="rejection_description" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Reject Achievement</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

@endsection
