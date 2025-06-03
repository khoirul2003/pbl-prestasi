@extends('layout.app')

@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h4 class="card-title mb-4">My Achievements</h4>


            <!-- Add Achievement button -->
            <div class="mb-3">
                <button type="button" class="btn btn-primary btn-rounded btn-fw" data-bs-toggle="modal" data-bs-target="#addAchievementModal">
                    <i class="bi bi-plus-circle me-2"></i> Add Achievement
                </button>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Modal Add Achievement -->
            <div class="modal fade" id="addAchievementModal" tabindex="-1" aria-labelledby="addAchievementLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <form action="{{ route('student.achievements.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="addAchievementLabel">
                                    <i class="bi bi-plus-circle"></i> Add New Achievement
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Category</label>
                                    <select class="form-select" id="category_id" name="category_id" required>
                                        <option value="">-- Select Category --</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="achievement_title" class="form-label">Achievement Title</label>
                                    <input type="text" class="form-control" id="achievement_title" name="achievement_title" required>
                                </div>
                                <div class="mb-3">
                                    <label for="achievement_description" class="form-label">Description</label>
                                    <textarea class="form-control" id="achievement_description" name="achievement_description" rows="3"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="achievement_ranking" class="form-label">Ranking (e.g., 1st Place, Gold Medal)</label>
                                    <input type="text" class="form-control" id="achievement_ranking" name="achievement_ranking">
                                </div>
                                <div class="mb-3">
                                    <label for="achievement_level" class="form-label">Level</label>
                                    <select class="form-select" id="achievement_level" name="achievement_level" required>
                                        <option value="">-- Select Level --</option>
                                        <option value="regional">Regional</option>
                                        <option value="nasional">Nasional</option>
                                        <option value="internasional">Internasional</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="achievement_document" class="form-label">Document (PDF, JPG, PNG)</label>
                                    <input type="file" class="form-control" id="achievement_document" name="achievement_document" accept=".pdf,.jpg,.jpeg,.png">
                                    <small class="form-text text-muted">Max file size: 2MB</small>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Add Achievement</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Table for Achievements -->
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Ranking</th>
                            <th>Level</th>
                            <th>Status</th>
                            <th>Document</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($achievements as $achievement)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $achievement->achievement_title }}</td>
                            <td>{{ $achievement->category->category_name ?? '-' }}</td>
                            <td>{{ $achievement->achievement_ranking ?? '-' }}</td>
                            <td>{{ ucfirst($achievement->achievement_level ?? '-') }}</td>
                            <td>
                                @if ($achievement->achievement_verified == 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @elseif ($achievement->achievement_verified == 'rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>
                            <td>
                                @if ($achievement->achievement_document)
                                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#documentModal{{ $achievement->achievement_id }}">
                                        <i class="bi bi-file-earmark-text"></i> View
                                    </button>
                                @else
                                    <span class="text-muted">No document</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-secondary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#detailModal{{ $achievement->achievement_id }}">
                                    <i class="bi bi-eye"></i> Show
                                </button>

                                @if($achievement->achievement_verified === 'pending')
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $achievement->achievement_id }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $achievement->achievement_id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                @else
                                    <span class="text-muted">No action</span>
                                @endif
                            </td>
                        </tr>

                        <!-- Modal Detail -->
                        <div class="modal fade" id="detailModal{{ $achievement->achievement_id }}" tabindex="-1"
                            aria-labelledby="detailModalLabel{{ $achievement->achievement_id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="detailModalLabel{{ $achievement->achievement_id }}">
                                            <i class="bi bi-info-circle"></i> Achievement Details
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item"><strong>Title:</strong> {{ $achievement->achievement_title }}</li>
                                            <li class="list-group-item"><strong>Category:</strong> {{ $achievement->category->category_name ?? '-' }}</li>
                                            <li class="list-group-item"><strong>Description:</strong> {{ $achievement->achievement_description ?? '-' }}</li>
                                            <li class="list-group-item"><strong>Ranking:</strong> {{ $achievement->achievement_ranking ?? '-' }}</li>
                                            <li class="list-group-item"><strong>Level:</strong> {{ ucfirst($achievement->achievement_level ?? '-') }}</li>
                                            <li class="list-group-item"><strong>Status:</strong>
                                                @if ($achievement->achievement_verified == 'approved')
                                                    <span class="badge bg-success">Approved</span>
                                                @elseif ($achievement->achievement_verified == 'rejected')
                                                    <span class="badge bg-danger">Rejected</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                @endif
                                            </li>
                                            @if ($achievement->achievement_document)
                                                <li class="list-group-item">
                                                    <strong>Document:</strong>
                                                    <a href="{{ asset('documents/achievements/' . $achievement->achievement_document) }}" target="_blank">View Document</a>
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

                        <!-- Modal Document Viewer -->
                        @if ($achievement->achievement_document)
                            <div class="modal fade" id="documentModal{{ $achievement->achievement_id }}" tabindex="-1"
                                aria-labelledby="documentModalLabel{{ $achievement->achievement_id }}" aria-hidden="true">
                                <div class="modal-dialog modal-xl modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="documentModalLabel{{ $achievement->achievement_id }}">
                                                <i class="bi bi-file-earmark-text"></i> Document - {{ $achievement->achievement_title }}
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-0">
                                            <div class="d-flex justify-content-between align-items-center p-3 bg-light border-bottom">
                                                <small class="text-muted">
                                                    Document for: <strong>{{ $achievement->achievement_title }}</strong>
                                                </small>
                                                <div>
                                                    <a href="{{ asset('documents/achievements/' . $achievement->achievement_document) }}"
                                                        target="_blank" class="btn btn-outline-primary btn-sm me-2">
                                                        <i class="bi bi-box-arrow-up-right"></i> Open in New Tab
                                                    </a>
                                                    <a href="{{ asset('documents/achievements/' . $achievement->achievement_document) }}"
                                                        download class="btn btn-outline-success btn-sm">
                                                        <i class="bi bi-download"></i> Download
                                                    </a>
                                                </div>
                                            </div>
                                            <div style="height: 75vh;">
                                                @php
                                                    $extension = pathinfo($achievement->achievement_document, PATHINFO_EXTENSION);
                                                @endphp
                                                @if(in_array($extension, ['pdf']))
                                                    <iframe src="{{ asset('documents/achievements/' . $achievement->achievement_document) }}"
                                                        width="100%" height="100%" style="border: none;" title="Document">
                                                        <p>Your browser does not support PDFs.
                                                            <a href="{{ asset('documents/achievements/' . $achievement->achievement_document) }}" target="_blank">
                                                                Click here to download the PDF
                                                            </a>
                                                        </p>
                                                    </iframe>
                                                @else
                                                    <div class="text-center p-5">
                                                        <img src="{{ asset('documents/achievements/' . $achievement->achievement_document) }}"
                                                            class="img-fluid" alt="Achievement Document" style="max-height: 65vh;">
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Modal Edit -->
                        <div class="modal fade" id="editModal{{ $achievement->achievement_id }}" tabindex="-1"
                            aria-labelledby="editModalLabel{{ $achievement->achievement_id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                <form action="{{ route('student.achievements.update', $achievement->achievement_id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header bg-warning text-dark">
                                            <h5 class="modal-title" id="editModalLabel{{ $achievement->achievement_id }}">
                                                <i class="bi bi-pencil-square"></i> Edit Achievement
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="edit_category_id_{{ $achievement->achievement_id }}" class="form-label">Category</label>
                                                <select class="form-select" id="edit_category_id_{{ $achievement->achievement_id }}" name="category_id" required>
                                                    <option value="">-- Select Category --</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->category_id }}" {{ $achievement->category_id == $category->category_id ? 'selected' : '' }}>
                                                            {{ $category->category_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="edit_achievement_title_{{ $achievement->achievement_id }}" class="form-label">Achievement Title</label>
                                                <input type="text" class="form-control" id="edit_achievement_title_{{ $achievement->achievement_id }}" name="achievement_title" value="{{ $achievement->achievement_title }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="edit_achievement_description_{{ $achievement->achievement_id }}" class="form-label">Description</label>
                                                <textarea class="form-control" id="edit_achievement_description_{{ $achievement->achievement_id }}" name="achievement_description" rows="3">{{ $achievement->achievement_description }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="edit_achievement_ranking_{{ $achievement->achievement_id }}" class="form-label">Ranking</label>
                                                <input type="text" class="form-control" id="edit_achievement_ranking_{{ $achievement->achievement_id }}" name="achievement_ranking" value="{{ $achievement->achievement_ranking }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="edit_achievement_level_{{ $achievement->achievement_id }}" class="form-label">Level</label>
                                                <select class="form-select" id="edit_achievement_level_{{ $achievement->achievement_id }}" name="achievement_level" required>
                                                    <option value="">-- Select Level --</option>
                                                    <option value="regional" {{ $achievement->achievement_level == 'regional' ? 'selected' : '' }}>Regional</option>
                                                    <option value="nasional" {{ $achievement->achievement_level == 'nasional' ? 'selected' : '' }}>Nasional</option>
                                                    <option value="internasional" {{ $achievement->achievement_level == 'internasional' ? 'selected' : '' }}>Internasional</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="edit_achievement_document_{{ $achievement->achievement_id }}" class="form-label">Document (PDF, JPG, PNG)</label>
                                                <input type="file" class="form-control" id="edit_achievement_document_{{ $achievement->achievement_id }}" name="achievement_document" accept=".pdf,.jpg,.jpeg,.png">
                                                <small class="form-text text-muted">Leave blank to keep current document. Max file size: 2MB</small>
                                                @if ($achievement->achievement_document)
                                                    <p class="mt-2">Current Document:
                                                        <a href="{{ asset('documents/achievements/' . $achievement->achievement_document) }}" target="_blank">
                                                            {{ $achievement->achievement_document }}
                                                        </a>
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-warning">Update Achievement</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Modal Delete -->
                        <div class="modal fade" id="deleteModal{{ $achievement->achievement_id }}" tabindex="-1"
                            aria-labelledby="deleteModalLabel{{ $achievement->achievement_id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="{{ route('student.achievements.destroy', $achievement->achievement_id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $achievement->achievement_id }}">
                                                <i class="bi bi-trash"></i> Confirm Delete
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete the achievement:</p>
                                            <p><strong>"{{ $achievement->achievement_title }}"</strong></p>
                                            <p class="text-danger"><small><i class="bi bi-exclamation-triangle"></i> This action cannot be undone.</small></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        @empty
                        <tr>
                            <td colspan="8" class="text-center">No achievements found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
