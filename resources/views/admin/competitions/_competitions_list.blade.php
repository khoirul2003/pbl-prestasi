<table class="table table-hover align-middle">
    <thead class="table-light">
        <tr>
            <th>No</th>
            <th>Title</th>
            <th>Category</th>
            <th>Organizer</th>

            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($competitions as $index => $competition)
            <tr>
                <td>{{ $index + $competitions->firstItem() }}</td>
                <td>{{ $competition->competition_tittle }}</td>
                <td>{{ $competition->category->category_name ?? '-' }}</td>
                <td>{{ $competition->competition_organizer }}</td>
                
                <td>
                    {{-- Display status of the competition --}}
                    @if ($competition->competitionRequests->isNotEmpty())
                        @foreach ($competition->competitionRequests as $request)
                            <span class="badge
                                @if ($request->request_verified == 'pending') bg-warning text-dark
                                @elseif ($request->request_verified == 'approved') bg-success
                                @else bg-danger @endif">
                                {{ ucfirst($request->request_verified) }}
                            </span>
                        @endforeach
                    @else
                        <span class="text-muted">No requests</span>
                    @endif
                </td>
                <td>
                    <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#showModal{{ $competition->competition_id }}">
                        <i class="bi bi-eye"></i> Show
                    </button>
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $competition->competition_id }}">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    <form action="{{ route('admin.competitions.destroy', $competition->competition_id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure want to delete this competition?')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">No competitions found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="d-flex justify-content-center mt-4">
    {{ $competitions->links() }}
</div>
