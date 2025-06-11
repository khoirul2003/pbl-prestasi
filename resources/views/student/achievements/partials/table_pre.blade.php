<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Title</th>
                <th>Category</th>
                <th>Ranking</th>
                <th>Level</th>
                <th>Document</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($achievements as $achievement)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $achievement->pre_university_achievement_title }}</td>
                    <td>{{ $achievement->category->category_name ?? '-' }}</td>
                    <td>{{ $achievement->pre_university_achievement_ranking ?? '-' }}</td>
                    <td>{{ ucfirst($achievement->pre_university_achievement_level) }}</td>
                    <td>
                        @if ($achievement->pre_university_achievement_document)
                            <a href="{{ asset('documents/pre_achievements/' . $achievement->pre_university_achievement_document) }}"
                               target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-file-earmark"></i> View
                            </a>
                        @else
                            <span class="text-muted">No document</span>
                        @endif
                    </td>
                    <td>
                        <!-- Trigger modal -->
                        <button type="button" class="btn btn-secondary btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#achievementModal"
                            data-url="{{ route('student.pre_achievements.show', $achievement->pre_university_achievement_id) }}">
                            <i class="bi bi-eye"></i>
                        </button>

                        <!-- Delete -->
                        <form action="{{ route('student.pre_achievements.destroy', $achievement->pre_university_achievement_id) }}"
                              method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Delete this achievement?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No pre-university achievements found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="achievementModal" tabindex="-1" aria-labelledby="achievementModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="achievementModalContent">
            <div class="modal-header">
                <h5 class="modal-title">Detail Prestasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('achievementModal');
    const modalContent = modal.querySelector('#achievementModalContent');

    modal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const url = button.getAttribute('data-url');

        modalContent.innerHTML = `
            <div class="modal-header">
                <h5 class="modal-title">Detail Prestasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `;

        fetch(url)
            .then(response => response.text())
            .then(html => {
                modalContent.innerHTML = html;
            })
            .catch(error => {
                modalContent.innerHTML = `
                    <div class="modal-header">
                        <h5 class="modal-title">Error</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-danger">Failed to load achievement details.</p>
                    </div>
                `;
            });
    });
});
</script>
@endpush
