@extends('layout.app')

@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h4 class="card-title mb-4">Competition Requests</h4>

            <div class="mb-3">
                <a href="{{ route('admin.requests.index') }}"
                    class="btn btn-sm {{ request('status') == null ? 'btn-primary' : 'btn-outline-primary' }}">
                    <i class="bi bi-list"></i> All
                </a>
                <a href="{{ route('admin.requests.index', ['status' => 'pending']) }}"
                    class="btn btn-sm {{ request('status') == 'pending' ? 'btn-primary' : 'btn-outline-primary' }}">
                    <i class="bi bi-clock"></i> Pending
                </a>
                <a href="{{ route('admin.requests.index', ['status' => 'approved']) }}"
                    class="btn btn-sm {{ request('status') == 'approved' ? 'btn-primary' : 'btn-outline-primary' }}">
                    <i class="bi bi-check-circle"></i> Approved
                </a>
                <a href="{{ route('admin.requests.index', ['status' => 'rejected']) }}"
                    class="btn btn-sm {{ request('status') == 'rejected' ? 'btn-primary' : 'btn-outline-primary' }}">
                    <i class="bi bi-x-circle"></i> Rejected
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>User</th>
                            <th>Competition Title</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Document</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($requests as $requestItem)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $requestItem->user->user_name ?? '-' }}</td>
                                <td>{{ $requestItem->competition->competition_tittle ?? '-' }}</td>
                                <td>{{ $requestItem->competition->category->category_name ?? '-' }}</td>
                                <td>
                                    @if ($requestItem->request_verified == 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif ($requestItem->request_verified == 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @elseif ($requestItem->request_verified == 'rejected')
                                        <span class="badge bg-danger">Rejected</span>
                                    @endif
                                </td>

                                <td>
                                    @if ($requestItem->competition->competition_document)
                                        <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#pdfModal{{ $requestItem->request_id }}">
                                            <i class="bi bi-file-earmark-pdf"></i> View PDF
                                        </button>
                                    @else
                                        <span class="text-muted">No document</span>
                                    @endif
                                </td>

                                <td>
                                    <button class="btn btn-secondary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#detailModal{{ $requestItem->competition->competition_id }}">
                                        <i class="bi bi-eye"></i> Show
                                    </button>


                                    <!-- Modal Detail -->
                                    <div class="modal fade" id="detailModal{{ $requestItem->competition->competition_id }}"
                                        tabindex="-1"
                                        aria-labelledby="detailModalLabel{{ $requestItem->competition->competition_id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title"
                                                        id="detailModalLabel{{ $requestItem->competition->competition_id }}">
                                                        <i class="bi bi-info-circle"></i> Competition Detail
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item"><strong>Title:</strong>
                                                            {{ $requestItem->competition->competition_tittle }}</li>
                                                        <li class="list-group-item"><strong>Description:</strong>
                                                            {{ $requestItem->competition->competition_description }}</li>
                                                        <li class="list-group-item"><strong>Organizer:</strong>
                                                            {{ $requestItem->competition->competition_organizer }}</li>
                                                        <li class="list-group-item"><strong>Level:</strong>
                                                            {{ $requestItem->competition->competition_level }}</li>
                                                        <li class="list-group-item"><strong>Category:</strong>
                                                            {{ $requestItem->competition->category->category_name }}</li>
                                                        <li class="list-group-item"><strong>Registration Start:</strong>
                                                            {{ $requestItem->competition->competition_registration_start }}
                                                        </li>
                                                        <li class="list-group-item"><strong>Deadline:</strong>
                                                            {{ $requestItem->competition->competition_registration_deadline }}
                                                        </li>
                                                        @if ($requestItem->competition->competition_registion_link)
                                                            <li class="list-group-item">
                                                                <strong>Link:</strong> <a
                                                                    href="{{ $requestItem->competition->competition_registion_link }}"
                                                                    target="_blank">View</a>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Modal PDF Viewer -->
                                    @if ($requestItem->competition->competition_document)

                                        <div class="modal fade" id="pdfModal{{ $requestItem->request_id }}" tabindex="-1"
                                            aria-labelledby="pdfModalLabel{{ $requestItem->request_id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-primary text-white">
                                                        <h5 class="modal-title"
                                                            id="pdfModalLabel{{ $requestItem->request_id }}">
                                                            <i class="bi bi-file-earmark-pdf"></i> Document -
                                                            {{ $requestItem->user->user_name ?? 'Unknown User' }}
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body p-0">
                                                        <div
                                                            class="d-flex justify-content-between align-items-center p-3 bg-light border-bottom">
                                                            <small class="text-muted">
                                                                Document for:
                                                                <strong>{{ $requestItem->competition->competition_tittle }}</strong>
                                                            </small>
                                                            <div>
                                                                <a href="{{ asset($requestItem->competition->competition_document) }}"
                                                                    target="_blank"
                                                                    class="btn btn-outline-primary btn-sm me-2">
                                                                    <i class="bi bi-box-arrow-up-right"></i> Open in New Tab
                                                                </a>
                                                                <a href="{{ asset($requestItem->competition->competition_document) }}"
                                                                    download class="btn btn-outline-success btn-sm">
                                                                    <i class="bi bi-download"></i> Download
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div style="height: 75vh;">
                                                            <iframe
                                                                src="{{ asset($requestItem->competition->competition_document) }}"
                                                                width="100%" height="100%" style="border: none;"
                                                                title="PDF Document">
                                                                <p>Your browser does not support PDFs.
                                                                    <a href="{{ asset($requestItem->competition->competition_document) }}"
                                                                        target="_blank">
                                                                        Click here to download the PDF
                                                                    </a>
                                                                </p>
                                                            </iframe>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($requestItem->request_verified == 'pending')
                                        <form action="{{ route('admin.requests.update', $requestItem->request_id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="request_verified" value="approved">
                                            <button type="submit" class="btn btn-success btn-sm"
                                                onclick="return confirm('Approve this request?')">
                                                <i class="bi bi-check-circle"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.requests.update', $requestItem->request_id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="request_verified" value="rejected">
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Reject this request?')">
                                                <i class="bi bi-x-circle"></i>
                                            </button>
                                        </form>
                                    @else
                                        <i class="text-muted">No action</i>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No competition requests found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
