<div class="modal fade" id="editAchievementModal" tabindex="-1" aria-labelledby="editAchievementModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editAchievementForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Achievement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="achievement_id" id="edit_achievement_id">

                    <div class="mb-3">
                        <label for="edit_category_id" class="form-label">Category</label>
                        <select name="category_id" id="edit_category_id" class="form-select" required>
                            <option value="">-- Select Category --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit_achievement_title" class="form-label">Title</label>
                        <input type="text" name="achievement_title" id="edit_achievement_title" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_achievement_description" class="form-label">Description</label>
                        <textarea name="achievement_description" id="edit_achievement_description" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="edit_achievement_ranking" class="form-label">Ranking</label>
                        <input type="text" name="achievement_ranking" id="edit_achievement_ranking" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="edit_achievement_level" class="form-label">Level</label>
                        <select name="achievement_level" id="edit_achievement_level" class="form-select" required>
                            <option value="regional">Regional</option>
                            <option value="nasional">Nasional</option>
                            <option value="internasional">Internasional</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit_achievement_document" class="form-label">Document (optional)</label>
                        <input type="file" name="achievement_document" id="edit_achievement_document" class="form-control">
                        <small id="current_document_info" class="text-muted mt-1 d-block"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Update</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
