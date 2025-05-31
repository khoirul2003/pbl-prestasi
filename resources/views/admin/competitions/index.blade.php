@extends('layout.app')

@section('content')

<div class="card shadow-sm rounded-3 mb-4">
    <div class="card-body">
        <h4 class="card-title mb-3">Competition Data</h4>

        <a href="{{ route('competitions.create') }}" class="btn btn-primary btn-rounded btn-fw mb-2">
            <i class="bi bi-plus-circle me-2"></i> Add Competition
        </a>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No.</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Organizer</th>
                        <th>Level</th>
                        <th>Registration Deadline</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($competitions as $competition)
                        <tr>
                            <td>{{ $competition->competition_id }}</td>
                            <td>{{ $competition->competition_tittle }}</td>
                            <td>{{ $competition->category->category_name ?? '-' }}</td>
                            <td>{{ $competition->competition_organizer }}</td>
                            <td>{{ ucfirst($competition->competition_level) }}</td>
                            <td>{{ \Carbon\Carbon::parse($competition->competition_registration_deadline)->format('d-m-Y') }}</td>
                            <td class="d-flex">
                                <a href="{{ route('competitions.show', $competition->competition_id) }}" class="btn btn-info btn-sm btn-rounded me-2" data-bs-toggle="tooltip" title="Show Details">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('competitions.edit', $competition->competition_id) }}" class="btn btn-warning btn-sm btn-rounded me-2" data-bs-toggle="tooltip" title="Edit Competition">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('competitions.destroy', $competition->competition_id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm btn-rounded" onclick="return confirm('Are you sure want to delete this competition?')" data-bs-toggle="tooltip" title="Delete Competition">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $competitions->links() }}
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Activate tooltips
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@endpush
