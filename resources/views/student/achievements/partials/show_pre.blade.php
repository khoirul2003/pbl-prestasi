<div class="modal-header">
    <h5 class="modal-title">Detail Pre-University Achievement</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <h5>{{ $achievement->pre_university_achievement_title }}</h5>
    <p><strong>Kategori:</strong> {{ $achievement->category->category_name ?? '-' }}</p>
    <p><strong>Peringkat:</strong> {{ $achievement->pre_university_achievement_ranking ?? '-' }}</p>
    <p><strong>Tingkat:</strong> {{ $achievement->pre_university_achievement_level }}</p>
    <p><strong>Deskripsi:</strong><br>{{ $achievement->pre_university_achievement_description ?? '-' }}</p>

    @if ($achievement->pre_university_achievement_document)
        <a href="{{ asset('documents/pre_achievements/' . $achievement->pre_university_achievement_document) }}"
           target="_blank" class="btn btn-primary mt-3">
            Lihat Dokumen
        </a>
    @else
        <p class="text-muted">Tidak ada dokumen</p>
    @endif
</div>
