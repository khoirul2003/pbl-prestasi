@extends('layout.app')

@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h4 class="card-title mb-4">Competition List</h4>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

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
                            <th>Document</th>
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
                                    @if ($competition->competition_document)
                                        <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#pdfModal{{ $competition->competition_id }}">
                                            <i class="bi bi-file-earmark-pdf"></i> View PDF
                                        </button>
                                    @else
                                        <span class="text-muted">No document</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#showModal{{ $competition->competition_id }}">
                                        <i class="bi bi-eye"></i> Show
                                    </button>
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $competition->competition_id }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <form action="{{ route('competitions.destroy', $competition->competition_id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure want to delete this competition?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            {{-- Modal Show --}}
                            <div class="modal fade" id="showModal{{ $competition->competition_id }}" tabindex="-1"
                                aria-labelledby="showModalLabel{{ $competition->competition_id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="showModalLabel{{ $competition->competition_id }}">
                                                <i class="bi bi-info-circle"></i> Competition Detail
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item"><strong>Title:</strong> {{ $competition->competition_tittle }}</li>
                                                <li class="list-group-item"><strong>Category:</strong> {{ $competition->category->category_name ?? '-' }}</li>
                                                <li class="list-group-item"><strong>Organizer:</strong> {{ $competition->competition_organizer }}</li>
                                                <li class="list-group-item"><strong>Description:</strong> {{ $competition->competition_description }}</li>
                                                <li class="list-group-item"><strong>Level:</strong> {{ $competition->competition_level }}</li>
                                                <li class="list-group-item"><strong>Registration Start:</strong> {{ $competition->competition_registration_start }}</li>
                                                <li class="list-group-item"><strong>Deadline:</strong> {{ $competition->competition_registration_deadline }}</li>
                                                @if ($competition->competition_registion_link)
                                                    <li class="list-group-item">
                                                        <strong>Link:</strong> <a href="{{ $competition->competition_registion_link }}" target="_blank">View</a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Modal PDF Viewer --}}
                            @if ($competition->competition_document)
                                <div class="modal fade" id="pdfModal{{ $competition->competition_id }}" tabindex="-1"
                                    aria-labelledby="pdfModalLabel{{ $competition->competition_id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-xl modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title" id="pdfModalLabel{{ $competition->competition_id }}">
                                                    <i class="bi bi-file-earmark-pdf"></i> Document - {{ $competition->competition_tittle }}
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-0">
                                                <div class="d-flex justify-content-between align-items-center p-3 bg-light border-bottom">
                                                    <small class="text-muted">
                                                        Document for: <strong>{{ $competition->competition_tittle }}</strong>
                                                    </small>
                                                    <div>
                                                        <a href="{{ asset($competition->competition_document) }}" target="_blank"
                                                            class="btn btn-outline-primary btn-sm me-2">
                                                            <i class="bi bi-box-arrow-up-right"></i> Open in New Tab
                                                        </a>
                                                        <a href="{{ asset($competition->competition_document) }}" download
                                                            class="btn btn-outline-success btn-sm">
                                                            <i class="bi bi-download"></i> Download
                                                        </a>
                                                    </div>
                                                </div>
                                                <div style="height: 75vh;">
                                                    <iframe src="{{ asset($competition->competition_document) }}" width="100%" height="100%"
                                                        style="border: none;" title="PDF Document">
                                                        <p>Your browser does not support PDFs.
                                                            <a href="{{ asset($competition->competition_document) }}" target="_blank">
                                                                Click here to download the PDF
                                                            </a>
                                                        </p>
                                                    </iframe>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- Modal Edit --}}
                            <div class="modal fade" id="editModal{{ $competition->competition_id }}" tabindex="-1"
                                aria-labelledby="editModalLabel{{ $competition->competition_id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                    <form class="modal-content" method="POST" action="{{ route('competitions.update', $competition->competition_id) }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="editModalLabel{{ $competition->competition_id }}">
                                                <i class="bi bi-pencil-square"></i> Edit Competition
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Title</label>
                                                <input type="text" name="competition_tittle" class="form-control" value="{{ $competition->competition_tittle }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Category</label>
                                                <select name="category_id" class="form-select" required>
                                                    @foreach(\App\Models\Category::all() as $category)
                                                        <option value="{{ $category->category_id }}" {{ $category->category_id == $competition->category_id ? 'selected' : '' }}>
                                                            {{ $category->category_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Organizer</label>
                                                <input type="text" name="competition_organizer" class="form-control" value="{{ $competition->competition_organizer }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Description</label>
                                                <textarea name="competition_description" class="form-control" rows="3" required>{{ $competition->competition_description }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Level</label>
                                                <select name="competition_level" class="form-select" required>
                                                    <option value="regional" {{ $competition->competition_level == 'regional' ? 'selected' : '' }}>Regional</option>
                                                    <option value="nasional" {{ $competition->competition_level == 'nasional' ? 'selected' : '' }}>Nasional</option>
                                                    <option value="internasional" {{ $competition->competition_level == 'internasional' ? 'selected' : '' }}>Internasional</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Start Registration</label>
                                                <input type="date" name="competition_registration_start" class="form-control" value="{{ $competition->competition_registration_start }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Deadline Registration</label>
                                                <input type="date" name="competition_registration_deadline" class="form-control" value="{{ $competition->competition_registration_deadline }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Registration Link</label>
                                                <input type="url" name="competition_registion_link" class="form-control" value="{{ $competition->competition_registion_link }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Upload Document</label>
                                                <input type="file" name="competition_document" class="form-control">
                                                @if ($competition->competition_document)
                                                    <small class="text-muted">Current: {{ basename($competition->competition_document) }}</small>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
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

    {{-- Modal Add Competition --}}
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <form class="modal-content" method="POST" action="{{ route('competitions.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="addModalLabel">
                        <i class="bi bi-plus-circle"></i> Add New Competition
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="competition_tittle" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-select" required>
                            <option value="">Select Category</option>
                            @foreach(\App\Models\Category::all() as $category)
                                <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Organizer</label>
                        <input type="text" name="competition_organizer" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="competition_description" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Level</label>
                        <select name="competition_level" class="form-select" required>
                            <option value="">Select Level</option>
                            <option value="regional">Regional</option>
                            <option value="nasional">Nasional</option>
                            <option value="internasional">Internasional</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Start Registration</label>
                        <input type="date" name="competition_registration_start" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deadline Registration</label>
                        <input type="date" name="competition_registration_deadline" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Registration Link</label>
                        <input type="url" name="competition_registion_link" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Upload Document</label>
                        <input type="file" name="competition_document" class="form-control">
                        <small class="text-muted">Optional: Upload competition document (PDF recommended)</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Add Competition</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
@endsection
