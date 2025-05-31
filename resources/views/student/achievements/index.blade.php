@extends('layout.app')

@section('content')
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h4 class="card-title mb-4">My Achievements</h4>

        <button type="button" class="btn btn-primary btn-rounded btn-fw mb-3" data-bs-toggle="modal" data-bs-target="#addAchievementModal">
            <i class="bi bi-plus-circle me-2"></i> Add Achievement
        </button>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="modal fade" id="addAchievementModal" tabindex="-1" aria-labelledby="addAchievementLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('student.achievements.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addAchievementLabel">Add New Achievement</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Category</label>
                                <select class="form-select" id="category_id" name="category_id" required>
                                    <option value="">Select Category</option>
                                    {{-- Assuming $categories is passed from the controller --}}
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
                                <label for="achievement_level" class="form-label">Level (e.g., National, International)</label>
                                <input type="text" class="form-control" id="achievement_level" name="achievement_level">
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

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No.</th>
                        <th>Category</th>
                        <th>Title</th>
                        <th>Ranking</th>
                        <th>Level</th>
                        <th>Document</th>
                        <th>Verified</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($achievements as $achievement)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $achievement->category->category_name ?? 'N/A' }}</td>
                        <td>{{ $achievement->achievement_title }}</td>
                        <td>{{ $achievement->achievement_ranking ?? '-' }}</td>
                        <td>{{ $achievement->achievement_level ?? '-' }}</td>
                        <td>
                            @if ($achievement->achievement_document)
                                <a href="{{ asset('documents/achievements/' . $achievement->achievement_document) }}" target="_blank" class="btn btn-sm btn-outline-info">View Document</a>
                            @else
                                No Document
                            @endif
                        </td>
                        <td>
                            {{-- Updated logic for achievement_verified enum --}}
                            @if ($achievement->achievement_verified == 'approved')
                                <span class="badge bg-success">Approved</span>
                            @elseif ($achievement->achievement_verified == 'rejected')
                                <span class="badge bg-danger">Rejected</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending</span>
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-info btn-rounded btn-sm text-white" data-bs-toggle="modal" data-bs-target="#showAchievementModal{{ $achievement->achievement_id }}">
                                <i class="bi bi-eye"></i> Show
                            </button>

                            <button type="button" class="btn btn-warning btn-rounded btn-sm text-white" data-bs-toggle="modal" data-bs-target="#editAchievementModal{{ $achievement->achievement_id }}">
                                <i class="bi bi-pencil-square"></i> Edit
                            </button>

                            <button type="button" class="btn btn-danger btn-rounded btn-sm" data-bs-toggle="modal" data-bs-target="#deleteAchievementModal{{ $achievement->achievement_id }}">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </td>
                    </tr>

                    <div class="modal fade" id="showAchievementModal{{ $achievement->achievement_id }}" tabindex="-1" aria-labelledby="showAchievementLabel{{ $achievement->achievement_id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="showAchievementLabel{{ $achievement->achievement_id }}">Achievement Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Category:</strong> {{ $achievement->category->category_name ?? 'N/A' }}</p>
                                    <p><strong>Title:</strong> {{ $achievement->achievement_title }}</p>
                                    <p><strong>Description:</strong> {{ $achievement->achievement_description ?? '-' }}</p>
                                    <p><strong>Ranking:</strong> {{ $achievement->achievement_ranking ?? '-' }}</p>
                                    <p><strong>Level:</strong> {{ $achievement->achievement_level ?? '-' }}</p>
                                    <p><strong>Document:</strong>
                                        @if ($achievement->achievement_document)
                                            <a href="{{ asset('documents/achievements/' . $achievement->achievement_document) }}" target="_blank">View Document</a>
                                        @else
                                            No Document
                                        @endif
                                    </p>
                                    <p><strong>Verified:</strong>
                                        {{-- Updated logic for achievement_verified enum in show modal --}}
                                        @if ($achievement->achievement_verified == 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @elseif ($achievement->achievement_verified == 'rejected')
                                            <span class="badge bg-danger">Rejected</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="editAchievementModal{{ $achievement->achievement_id }}" tabindex="-1" aria-labelledby="editAchievementLabel{{ $achievement->achievement_id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('student.achievements.update', $achievement->achievement_id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editAchievementLabel{{ $achievement->achievement_id }}">Edit Achievement</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="edit_category_id_{{ $achievement->achievement_id }}" class="form-label">Category</label>
                                            <select class="form-select" id="edit_category_id_{{ $achievement->achievement_id }}" name="category_id" required>
                                                <option value="">Select Category</option>
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
                                            <input type="text" class="form-control" id="edit_achievement_level_{{ $achievement->achievement_id }}" name="achievement_level" value="{{ $achievement->achievement_level }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit_achievement_document_{{ $achievement->achievement_id }}" class="form-label">Document (PDF, JPG, PNG)</label>
                                            <input type="file" class="form-control" id="edit_achievement_document_{{ $achievement->achievement_id }}" name="achievement_document" accept=".pdf,.jpg,.jpeg,.png">
                                            <small class="form-text text-muted">Leave blank to keep current document. Max file size: 2MB</small>
                                            @if ($achievement->achievement_document)
                                                <p class="mt-2">Current Document: <a href="{{ asset('documents/achievements/' . $achievement->achievement_document) }}" target="_blank">{{ $achievement->achievement_document }}</a></p>
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

                    <div class="modal fade" id="deleteAchievementModal{{ $achievement->achievement_id }}" tabindex="-1" aria-labelledby="deleteAchievementLabel{{ $achievement->achievement_id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('student.achievements.destroy', $achievement->achievement_id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteAchievementLabel{{ $achievement->achievement_id }}">Confirm Delete</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete the achievement "<strong>{{ $achievement->achievement_title }}</strong>"?
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
