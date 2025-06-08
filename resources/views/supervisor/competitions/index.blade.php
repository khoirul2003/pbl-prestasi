@extends('layout.app')

@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h4 class="card-title mb-4">Competition Requests</h4>

            <!-- Filter buttons similar to admin interface -->
            <div class="mb-3">
                <a href="{{ route('supervisor.competitions.index') }}"
                    class="btn btn-sm {{ request('status') == null ? 'btn-primary' : 'btn-outline-primary' }}">
                    <i class="bi bi-list"></i> All
                </a>
                <a href="{{ route('supervisor.competitions.index', ['status' => 'pending']) }}"
                    class="btn btn-sm {{ request('status') == 'pending' ? 'btn-primary' : 'btn-outline-primary' }}">
                    <i class="bi bi-clock"></i> Pending
                </a>
                <a href="{{ route('supervisor.competitions.index', ['status' => 'approved']) }}"
                    class="btn btn-sm {{ request('status') == 'approved' ? 'btn-primary' : 'btn-outline-primary' }}">
                    <i class="bi bi-check-circle"></i> Approved
                </a>
                <a href="{{ route('supervisor.competitions.index', ['status' => 'rejected']) }}"
                    class="btn btn-sm {{ request('status') == 'rejected' ? 'btn-primary' : 'btn-outline-primary' }}">
                    <i class="bi bi-x-circle"></i> Rejected
                </a>
            </div>

            <!-- Submit button -->
            <div class="mb-3">
                <button type="button" class="btn btn-primary btn-rounded btn-fw" data-bs-toggle="modal" data-bs-target="#addCompetitionModal">
                    <i class="bi bi-plus-circle me-2"></i> Add Competition Request
                </button>
            </div>

            <!-- Modal Add Competition -->
            <div class="modal fade" id="addCompetitionModal" tabindex="-1" aria-labelledby="addCompetitionLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <form action="{{ route('supervisor.competitions.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="addCompetitionLabel">
                                    <i class="bi bi-plus-circle"></i> New Competition Request
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Category</label>
                                    <select name="category_id" id="category_id" class="form-select" required>
                                        <option value="">-- Select Category --</option>
                                        @foreach(\App\Models\Category::all() as $category)
                                            <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="competition_tittle" class="form-label">Competition Title</label>
                                    <input type="text" class="form-control" name="competition_tittle" required>
                                </div>
                                <div class="mb-3">
                                    <label for="competition_description" class="form-label">Description</label>
                                    <textarea class="form-control" name="competition_description" rows="3" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="competition_organizer" class="form-label">Organizer</label>
                                    <input type="text" class="form-control" name="competition_organizer" required>
                                </div>
                                <div class="mb-3">
                                    <label for="competition_level" class="form-label">Level</label>
                                    <select name="competition_level" class="form-select" required>
                                        <option value="regional">Regional</option>
                                        <option value="nasional">Nasional</option>
                                        <option value="internasional">Internasional</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="competition_registration_start" class="form-label">Registration Start</label>
                                    <input type="date" class="form-control" name="competition_registration_start" required>
                                </div>
                                <div class="mb-3">
                                    <label for="competition_registration_deadline" class="form-label">Registration Deadline</label>
                                    <input type="date" class="form-control" name="competition_registration_deadline" required>
                                </div>
                                <div class="mb-3">
                                    <label for="competition_registion_link" class="form-label">Registration Link (optional)</label>
                                    <input type="url" class="form-control" name="competition_registion_link">
                                </div>
                                <div class="mb-3">
                                    <label for="competition_document" class="form-label">Upload Document</label>
                                    <input type="file" class="form-control" name="competition_document" accept=".pdf,.docx" required>
                                    <small class="text-muted">Max size: 2MB</small>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Submit Request</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Table for Competition Requests -->
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Organizer</th>
                            <th>Level</th>
                            <th>Deadline</th>
                            <th>Status</th>
                            <th>Document</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($requests as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->competition->competition_tittle }}</td>
                            <td>{{ $item->competition->category->category_name ?? '-' }}</td>
                            <td>{{ $item->competition->competition_organizer }}</td>
                            <td>{{ ucfirst($item->competition->competition_level) }}</td>
                            <td>{{ $item->competition->competition_registration_deadline }}</td>
                            <td>
                                @if($item->request_verified === 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @elseif($item->request_verified === 'rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>
                            <td>
                                @if ($item->competition->competition_document)
                                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#pdfModal{{ $item->request_id }}">
                                        <i class="bi bi-file-earmark-pdf"></i> View PDF
                                    </button>
                                @else
                                    <span class="text-muted">No document</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-secondary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#detailModal{{ $item->competition->competition_id }}">
                                    <i class="bi bi-eye"></i> Show
                                </button>

                                @if($item->request_verified === 'pending')
                                    <a href="{{ route('supervisor.competitions.edit', $item->competition->competition_id) }}" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>

                                    <form action="{{ route('supervisor.competitions.destroy', $item->competition->competition_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this request?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" type="submit">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted">No action</span>
                                @endif
                            </td>
                        </tr>

                        <!-- Modal Detail -->
                        <div class="modal fade" id="detailModal{{ $item->competition->competition_id }}"
                            tabindex="-1"
                            aria-labelledby="detailModalLabel{{ $item->competition->competition_id }}"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title"
                                            id="detailModalLabel{{ $item->competition->competition_id }}">
                                            <i class="bi bi-info-circle"></i> Competition Detail
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white"
                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item"><strong>Title:</strong>
                                                {{ $item->competition->competition_tittle }}</li>
                                            <li class="list-group-item"><strong>Description:</strong>
                                                {{ $item->competition->competition_description }}</li>
                                            <li class="list-group-item"><strong>Organizer:</strong>
                                                {{ $item->competition->competition_organizer }}</li>
                                            <li class="list-group-item"><strong>Level:</strong>
                                                {{ $item->competition->competition_level }}</li>
                                            <li class="list-group-item"><strong>Category:</strong>
                                                {{ $item->competition->category->category_name ?? '-' }}</li>
                                            <li class="list-group-item"><strong>Registration Start:</strong>
                                                {{ $item->competition->competition_registration_start }}
                                            </li>
                                            <li class="list-group-item"><strong>Deadline:</strong>
                                                {{ $item->competition->competition_registration_deadline }}
                                            </li>
                                            @if ($item->competition->competition_registion_link)
                                                <li class="list-group-item">
                                                    <strong>Link:</strong> <a
                                                        href="{{ $item->competition->competition_registion_link }}"
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
                        @if ($item->competition->competition_document)
                            <div class="modal fade" id="pdfModal{{ $item->request_id }}" tabindex="-1"
                                aria-labelledby="pdfModalLabel{{ $item->request_id }}"
                                aria-hidden="true">
                                <div class="modal-dialog modal-xl modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title"
                                                id="pdfModalLabel{{ $item->request_id }}">
                                                <i class="bi bi-file-earmark-pdf"></i> Document -
                                                {{ $item->competition->competition_tittle }}
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-0">
                                            <div
                                                class="d-flex justify-content-between align-items-center p-3 bg-light border-bottom">
                                                <small class="text-muted">
                                                    Document for:
                                                    <strong>{{ $item->competition->competition_tittle }}</strong>
                                                </small>
                                                <div>
                                                    <a href="{{ asset($item->competition->competition_document) }}"
                                                        target="_blank"
                                                        class="btn btn-outline-primary btn-sm me-2">
                                                        <i class="bi bi-box-arrow-up-right"></i> Open in New Tab
                                                    </a>
                                                    <a href="{{ asset($item->competition->competition_document) }}"
                                                        download class="btn btn-outline-success btn-sm">
                                                        <i class="bi bi-download"></i> Download
                                                    </a>
                                                </div>
                                            </div>
                                            <div style="height: 75vh;">
                                                <iframe
                                                    src="{{ asset($item->competition->competition_document) }}"
                                                    width="100%" height="100%" style="border: none;"
                                                    title="PDF Document">
                                                    <p>Your browser does not support PDFs.
                                                        <a href="{{ asset($item->competition->competition_document) }}"
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

                        @empty
                        <tr>
                            <td colspan="9" class="text-center">No competition requests found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
