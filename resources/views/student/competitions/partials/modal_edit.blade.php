<div class="modal fade" id="editCompetitionModal{{ $request->competition->competition_id }}" tabindex="-1" aria-labelledby="editCompetitionLabel{{ $request->competition->competition_id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" style="max-width: 95%;">
        <form action="{{ route('student.competitions.update', $request->competition->competition_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCompetitionLabel{{ $request->competition->competition_id }}">
                        <i class="bi bi-pencil-square"></i> Edit Competition Request
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <!-- Left Column: Image Preview -->
                        <div class="col-md-5 mb-3">
                            <label class="form-label">File Preview (Image Only)</label>
                            <div class="border rounded p-2 bg-light text-center" style="min-height: 360px;">
                                <img id="editFilePreview{{ $request->competition->competition_id }}"
                                     src="{{ asset($request->competition->competition_document) }}"
                                     alt="Preview"
                                     style="max-width: 100%; max-height: 440px; {{ in_array(pathinfo($request->competition->competition_document, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']) ? '' : 'display:none;' }} border-radius: 10px;">
                            </div>
                        </div>

                        <!-- Right Column: Form Fields -->
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="category_id" class="form-label">Category</label>
                                    <select name="category_id" class="form-select" disabled>
                                        @foreach(\App\Models\Category::all() as $category)
                                            <option value="{{ $category->category_id }}" {{ $category->category_id == $request->competition->category_id ? 'selected' : '' }}>
                                                {{ $category->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="competition_tittle" class="form-label">Competition Title</label>
                                    <input type="text" class="form-control" name="competition_tittle" value="{{ $request->competition->competition_tittle }}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="competition_description" class="form-label">Description</label>
                                <textarea class="form-control" name="competition_description" rows="3" required>{{ $request->competition->competition_description }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="competition_organizer" class="form-label">Organizer</label>
                                    <input type="text" class="form-control" name="competition_organizer" value="{{ $request->competition->competition_organizer }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="competition_level" class="form-label">Level</label>
                                    <select name="competition_level" class="form-select" required>
                                        <option value="regional" {{ $request->competition->competition_level == 'regional' ? 'selected' : '' }}>Regional</option>
                                        <option value="nasional" {{ $request->competition->competition_level == 'nasional' ? 'selected' : '' }}>Nasional</option>
                                        <option value="internasional" {{ $request->competition->competition_level == 'internasional' ? 'selected' : '' }}>Internasional</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="competition_registration_start" class="form-label">Registration Start</label>
                                    <input type="date" class="form-control" name="competition_registration_start" value="{{ $request->competition->competition_registration_start }}" disabled>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="competition_registration_deadline" class="form-label">Registration Deadline</label>
                                    <input type="date" class="form-control" name="competition_registration_deadline" value="{{ $request->competition->competition_registration_deadline }}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="competition_registration_link" class="form-label">Registration Link (optional)</label>
                                <input type="url" class="form-control" name="competition_registration_link" value="{{ $request->competition->competition_registration_link }}">
                            </div>

                            <div class="mb-3">
                                <label for="competition_document" class="form-label">Upload New Document (optional)</label>
                                <input type="file" class="form-control"
                                       name="competition_document"
                                       accept=".pdf,.docx,.jpg,.jpeg,.png"
                                       onchange="previewEditFile(event, '{{ $request->competition->competition_id }}')">
                                <small class="text-muted">Max 2MB | Allowed: jpg, png</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Request</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function previewEditFile(event, id) {
        const file = event.target.files[0];
        const preview = document.getElementById('editFilePreview' + id);
        const validImageTypes = ['image/jpeg', 'image/png', 'image/jpg'];

        if (file && validImageTypes.includes(file.type)) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
        }
    }
</script>
<style>
    .modal-xxl {
    max-width: 95% !important;
}
</style>
