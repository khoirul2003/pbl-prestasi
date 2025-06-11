<div class="modal-header">
    <h5 class="modal-title">Detail Prestasi</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <h5>{{ $achievement->achievement_title }}</h5>
    <p><strong>Kategori:</strong> {{ $achievement->category->category_name ?? '-' }}</p>
    <p><strong>Peringkat:</strong> {{ $achievement->achievement_ranking ?? '-' }}</p>
    <p><strong>Tingkat:</strong> {{ $achievement->achievement_level }}</p>
    <p><strong>Deskripsi:</strong><br>{{ $achievement->achievement_description ?? '-' }}</p>

    @if ($achievement->achievement_document)
        <a href="{{ asset('documents/achievements/' . $achievement->achievement_document) }}"
           target="_blank" class="btn btn-primary mt-3">
            Lihat Dokumen
        </a>
    @else
        <p class="text-muted">Tidak ada dokumen</p>
    @endif
</div>
