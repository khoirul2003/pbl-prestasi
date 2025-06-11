<div class="modal fade" id="editModal{{ $competition->competition_id }}" tabindex="-1"
    aria-labelledby="editModalLabel{{ $competition->competition_id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <form id="editForm{{ $competition->competition_id }}" class="modal-content"
            action="{{ route('admin.competitions.update', $competition->competition_id) }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editModalLabel{{ $competition->competition_id }}">
                    <i class="bi bi-pencil-square"></i> Edit Competition
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <div class="alert alert-danger d-none" id="editErrors{{ $competition->competition_id }}"></div>


                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="competition_tittle" class="form-control"
                        value="{{ $competition->competition_tittle }}" required>
                </div>


                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-select" required>
                        @foreach(\App\Models\Category::all() as $category)
                            <option value="{{ $category->category_id }}"
                                {{ $category->category_id == $competition->category_id ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <div class="mb-3">
                    <label class="form-label">Organizer</label>
                    <input type="text" name="competition_organizer" class="form-control"
                        value="{{ $competition->competition_organizer }}" required>
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
                    <input type="date" name="competition_registration_start" class="form-control"
                        value="{{ $competition->competition_registration_start }}" required>
                </div>


                <div class="mb-3">
                    <label class="form-label">Deadline Registration</label>
                    <input type="date" name="competition_registration_deadline" class="form-control"
                        value="{{ $competition->competition_registration_deadline }}" required>
                </div>


                <div class="mb-3">
                    <label class="form-label">Registration Link</label>
                    <input type="url" name="competition_registration_link" class="form-control"
                        value="{{ $competition->competition_registration_link }}" required>
                </div>


                <div class="mb-3">
                    <label class="form-label">Upload Document</label>
                    <input type="file" name="competition_document" class="form-control" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
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
