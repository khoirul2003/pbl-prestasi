<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Tittle</th>
            <th>Category</th>
            <th>Rangking</th>
            <th>Level</th>

            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($achievements as $index => $achievement)
            @php
                $isPre = $achievement instanceof \App\Models\PreUniversityAchievement;
                $title = $isPre ? $achievement->pre_university_achievement_title : $achievement->achievement_title;
                $ranking = $isPre ? $achievement->pre_university_achievement_ranking : $achievement->achievement_ranking;
                $level = $isPre ? $achievement->pre_university_achievement_level : $achievement->achievement_level;
                $document = $isPre ? $achievement->pre_university_achievement_document : $achievement->achievement_document;
                $path = $isPre ? 'documents/pre_achievements/' : 'documents/achievements/';
                $verified = $isPre ? null : $achievement->achievement_verified;
            @endphp
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $title }}</td>
                <td>{{ $achievement->category->category_name ?? '-' }}</td>
                <td>{{ $ranking }}</td>
                <td>{{ $level }}</td>

                <td>
                    @if (!$isPre)
                        @if ($verified === 'approved')
                            <span class="badge bg-success">Approved</span>
                        @elseif ($verified === 'rejected')
                            <span class="badge bg-danger">Rejected</span>
                        @else
                            <span class="badge bg-warning text-dark">Pending</span>
                        @endif
                    @else
                        <span class="badge bg-secondary">Pre-University</span>
                    @endif
                </td>
                <td>
                    <!-- Show -->
                    <button type="button" class="btn btn-secondary btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#achievementModal"
                        data-url="{{ $isPre
                            ? route('student.pre_achievements.show', $achievement->pre_university_achievement_id)
                            : route('student.achievements.show', $achievement->achievement_id) }}">
                        <i class="bi bi-eye"></i>
                    </button>

                    <!-- Edit only if 'pending' -->
                    @if (!$isPre && $verified === 'pending')
                        <button type="button" class="btn btn-warning btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#editAchievementModal"
                            data-id="{{ $achievement->achievement_id }}">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                    @endif

                    <!-- Delete -->
                    <form action="{{ $isPre
                        ? route('student.pre_achievements.destroy', $achievement->pre_university_achievement_id)
                        : route('student.achievements.destroy', $achievement->achievement_id) }}"
                        method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this achievement?')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center">No achievements found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<!-- Modal for show (loaded via AJAX) -->
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
            .catch(() => {
                modalContent.innerHTML = `
                    <div class="modal-header">
                        <h5 class="modal-title">Error</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-danger">
                        Failed to load achievement details.
                    </div>
                `;
            });
    });
});
</script>
@endpush
