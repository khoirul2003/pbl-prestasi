<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xxl modal-dialog-scrollable">
        <form class="modal-content" method="POST" action="{{ route('admin.competitions.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="addModalLabel">
                    <i class="bi bi-plus-circle"></i> Add New Competition
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Left Column: Image Upload -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Upload Document (Optional)</label>
                        <div class="text-center">
                            <input type="file" name="competition_document" class="form-control" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            <small class="text-muted">Optional: Upload competition document</small>
                        </div>
                    </div>

                    <!-- Right Column: Form Fields -->
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" name="competition_tittle" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category</label>
                                <select name="category_id" class="form-select" required>
                                    <option value="">Select Category</option>
                                    @foreach(\App\Models\Category::all() as $category)
                                        <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Organizer</label>
                                <input type="text" name="competition_organizer" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Level</label>
                                <select name="competition_level" class="form-select" required>
                                    <option value="">Select Level</option>
                                    <option value="regional">Regional</option>
                                    <option value="nasional">Nasional</option>
                                    <option value="internasional">Internasional</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="competition_description" class="form-control" rows="3" required></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Start Registration</label>
                                <input type="date" name="competition_registration_start" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Deadline Registration</label>
                                <input type="date" name="competition_registration_deadline" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Registration Link</label>
                            <input type="url" name="competition_registration_link" class="form-control" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Add Competition</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Function to preview the selected image before uploading
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('imagePreview');
            output.src = reader.result;
            output.style.display = 'block';  // Show the image
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

<style>
    /* Modify modal size */
    .modal-xxl {
        max-width: 95% !important;
    }

    /* Modify header to make it smaller */
    .modal-header {
        padding: 10px 15px;
    }

    .modal-header .modal-title {
        font-size: 1.2rem;
        font-weight: 600;
    }

    /* Modify footer to make it smaller */
    .modal-footer {
        padding: 10px 15px;
    }

    .modal-footer .btn {
        font-size: 0.9rem;
        padding: 6px 12px;
    }
</style>
