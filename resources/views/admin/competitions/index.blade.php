@extends('layout.app')

@section('content')
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h4 class="card-title mb-4">Competition List</h4>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Filter Tabs --}}
        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <a class="nav-link {{ request('status') == null ? 'active' : '' }}"
                    href="{{ route('admin.competitions.index') }}">
                    <i class="bi bi-list"></i> All Competitions
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'pending' ? 'active' : '' }}"
                    href="{{ route('admin.competitions.index', ['status' => 'pending']) }}">
                    <i class="bi bi-clock"></i> Pending Requests
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'approved' ? 'active' : '' }}"
                    href="{{ route('admin.competitions.index', ['status' => 'approved']) }}">
                    <i class="bi bi-check-circle"></i> Approved Requests
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'rejected' ? 'active' : '' }}"
                    href="{{ route('admin.competitions.index', ['status' => 'rejected']) }}">
                    <i class="bi bi-x-circle"></i> Rejected Requests
                </a>
            </li>
        </ul>

        <div class="mb-3">
            <button class="btn btn-primary btn-rounded btn-fw mb-3" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="bi bi-plus-circle me-2"></i> Add Competition
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Organizer</th>
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

                            @php $request = $competition->competitionRequests->first(); @endphp

                            <td class="d-flex flex-wrap gap-1">
                                {{-- Show Button --}}
                                <button class="btn btn-secondary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#showModal{{ $competition->competition_id }}">
                                    <i class="bi bi-eye"></i>
                                </button>

                                {{-- Edit & Delete only if NOT pending --}}
                                @if(!$request || $request->request_verified !== 'pending')
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $competition->competition_id }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                    <form action="{{ route('admin.competitions.destroy', $competition->competition_id) }}"
                                        method="POST" class="d-inline"
                                        onsubmit="return confirm('Are you sure want to delete this competition?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endif

                                {{-- Approve & Reject only if pending --}}
                                @if($request && $request->request_verified === 'pending')
                                    <form action="{{ route('admin.competitions.update-status', $request->request_id) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="request_verified" value="approved">
                                        <button class="btn btn-success btn-sm" type="submit"
                                            onclick="return confirm('Approve this request?')">
                                            <i class="bi bi-check-circle"></i> Approve
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.competitions.update-status', $request->request_id) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="request_verified" value="rejected">
                                        <button class="btn btn-danger btn-sm" type="submit"
                                            onclick="return confirm('Reject this request?')">
                                            <i class="bi bi-x-circle"></i> Reject
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No competitions found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $competitions->links() }}
        </div>
    </div>
</div>

{{-- Include Modals After the Table --}}
@foreach ($competitions as $competition)
    @include('admin.competitions.modals.show', ['competition' => $competition])
    @include('admin.competitions.modals.pdf', ['competition' => $competition])
    @include('admin.competitions.modals.edit', ['competition' => $competition])
@endforeach

{{-- Modal Add Competition --}}
@include('admin.competitions.modals.add')
@endsection
