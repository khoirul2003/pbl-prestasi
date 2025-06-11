{{-- student/achievements/partials/modal_add.blade.php --}}
<div class="modal fade" id="addAchievementModal" tabindex="-1" aria-labelledby="addAchievementModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addAchievementModalLabel">
                    <i class="bi bi-plus-circle"></i> Add New Achievement
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- Tabs for selecting achievement type --}}
                <ul class="nav nav-tabs mb-3" id="achievementTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="reg-tab" data-bs-toggle="tab" data-bs-target="#reg-content" type="button" role="tab">Achievement</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pre-tab" data-bs-toggle="tab" data-bs-target="#pre-content" type="button" role="tab">Pre-University Achievement</button>
                    </li>
                </ul>
                <div class="tab-content" id="achievementTabContent">
                    {{-- Regular Achievement Form --}}
                    <div class="tab-pane fade show active" id="reg-content" role="tabpanel">
                        <form action="{{ route('student.achievements.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
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
                                <label for="achievement_title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="achievement_title" name="achievement_title" required>
                            </div>
                            <div class="mb-3">
                                <label for="achievement_description" class="form-label">Description</label>
                                <textarea class="form-control" id="achievement_description" name="achievement_description" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="achievement_ranking" class="form-label">Ranking</label>
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
                                <label for="achievement_document" class="form-label">Document</label>
                                <input type="file" class="form-control" id="achievement_document" name="achievement_document" accept=".pdf,.jpg,.jpeg,.png">
                                <small class="form-text text-muted">Max: 2MB</small>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Add Achievement</button>
                            </div>
                        </form>
                    </div>

                    {{-- Pre-University Achievement Form --}}
                    <div class="tab-pane fade" id="pre-content" role="tabpanel">
                        <form action="{{ route('student.pre_achievements.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="pre_category_id" class="form-label">Category</label>
                                <select class="form-select" id="pre_category_id" name="category_id" required>
                                    <option value="">-- Select Category --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="pre_university_achievement_title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="pre_university_achievement_title" name="pre_university_achievement_title" required>
                            </div>
                            <div class="mb-3">
                                <label for="pre_university_achievement_description" class="form-label">Description</label>
                                <textarea class="form-control" id="pre_university_achievement_description" name="pre_university_achievement_description" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="pre_university_achievement_ranking" class="form-label">Ranking</label>
                                <input type="text" class="form-control" id="pre_university_achievement_ranking" name="pre_university_achievement_ranking">
                            </div>
                            <div class="mb-3">
                                <label for="pre_university_achievement_level" class="form-label">Level</label>
                                <select class="form-select" id="pre_university_achievement_level" name="pre_university_achievement_level" required>
                                    <option value="">-- Select Level --</option>
                                    <option value="regional">Regional</option>
                                    <option value="nasional">Nasional</option>
                                    <option value="internasional">Internasional</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="pre_university_achievement_document" class="form-label">Document</label>
                                <input type="file" class="form-control" id="pre_university_achievement_document" name="pre_university_achievement_document" accept=".pdf,.jpg,.jpeg,.png">
                                <small class="form-text text-muted">Max: 2MB</small>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Add Pre-University Achievement</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
