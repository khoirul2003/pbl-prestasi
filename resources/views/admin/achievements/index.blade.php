@extends('layout.app')

@section('content')

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h4 class="card-title mb-4">Achievements List</h4>

        <div class="mb-3">
            <a href="{{ route('achievements.index') }}" class="btn btn-sm {{ !request('status') ? 'btn-primary' : 'btn-outline-primary' }}">
                <i class="bi bi-list"></i> All
            </a>
            <a href="{{ route('achievements.index', ['status' => 'pending']) }}" class="btn btn-sm {{ request('status') == 'pending' ? 'btn-primary' : 'btn-outline-primary' }}">
                <i class="bi bi-clock"></i> Pending
            </a>
            <a href="{{ route('achievements.index', ['status' => 'processed']) }}" class="btn btn-sm {{ request('status') == 'processed' ? 'btn-primary' : 'btn-outline-primary' }}">
                <i class="bi bi-check-circle"></i> Processed
            </a>
        </div>

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
                    @forelse ($achievements as $achievement)
                        <tr>
                            <td>{{ $achievements->firstItem() + $loop->index }}</td>
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
                            <td>
                                <a href="{{ route('achievements.show', $achievement->achievement_id) }}" class="btn btn-info btn-sm btn-rounded btn-fw">
                                    <i class="bi bi-eye"></i>
                                </a>

                                @if ($achievement->achievement_verified == 'pending')
                                    <form action="{{ route('achievements.approve', $achievement->achievement_id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm btn-rounded btn-fw" onclick="return confirm('Approve this achievement?')">
                                            <i class="bi bi-check"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('achievements.reject', $achievement->achievement_id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm btn-rounded btn-fw" onclick="return confirm('Reject this achievement?')">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No achievements found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-3">
            {{ $achievements->appends(request()->query())->links() }}
        </div>
    </div>
</div>

@endsection
