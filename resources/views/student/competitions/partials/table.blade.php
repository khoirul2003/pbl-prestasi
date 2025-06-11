<table class="table table-bordered table-striped">
    <thead>
        <th>#</th>
        <th>Tittle</th>
        <th>Category</th>
        <th>Organizer</th>
        <th>Level</th>
        <th>Registration Date</th>
        <th>Status</th>
        <th>Action</th>
    </thead>
    <tbody>
        @foreach ($requests as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->competition->competition_tittle }}</td>
                <td>{{ $item->competition->category->category_name ?? '-' }}</td>
                <td>{{ $item->competition->competition_organizer }}</td>
                <td>{{ ucfirst($item->competition->competition_level) }}</td>
                <td>{{ $item->competition->competition_registration_start . ' - ' . $item->competition->competition_registration_deadline }}
                </td>
                <td>
                    @if ($item->request_verified === 'approved')
                        <span class="badge bg-success">Approved</span>
                    @elseif($item->request_verified === 'rejected')
                        <span class="badge bg-danger">Rejected</span>
                    @else
                        <span class="badge bg-warning text-dark">Pending</span>
                    @endif
                </td>

                <td>
                    <button class="btn btn-secondary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#detailModal{{ $item->competition->competition_id }}">
                        <i class="bi bi-eye"></i> Show
                    </button>

                    @if ($item->request_verified === 'pending')
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                            data-bs-target="#editCompetitionModal{{ $item->competition->competition_id }}">
                            <i class="bi bi-pencil-square"></i>
                        </button>

                        <form action="{{ route('student.competitions.destroy', $item->competition->competition_id) }}"
                            method="POST" class="d-inline" onsubmit="return confirm('Delete this request?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" type="submit">
                                <i class="bi bi-trash"></i> 
                            </button>
                        </form>
                    @else
                        <span class="text-muted">No action</span>
                    @endif
                </td>
            </tr>

            @include('student.competitions.partials.modal_detail', ['item' => $item])
            @include('student.competitions.partials.modal_pdf', ['item' => $item])
            @include('student.competitions.partials.modal_edit', ['request' => $item])

        @endforeach
    </tbody>
</table>
