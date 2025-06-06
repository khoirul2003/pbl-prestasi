<div class="modal fade" id="showModal{{ $competition->competition_id }}" tabindex="-1"
    aria-labelledby="showModalLabel{{ $competition->competition_id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="showModalLabel{{ $competition->competition_id }}">
                    <i class="bi bi-info-circle"></i> Competition Detail
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Title:</strong> {{ $competition->competition_tittle }}</li>
                    <li class="list-group-item"><strong>Category:</strong> {{ $competition->category->category_name ?? '-' }}</li>
                    <li class="list-group-item"><strong>Organizer:</strong> {{ $competition->competition_organizer }}</li>
                    <li class="list-group-item"><strong>Description:</strong> {{ $competition->competition_description }}</li>
                    <li class="list-group-item"><strong>Level:</strong> {{ $competition->competition_level }}</li>
                    <li class="list-group-item"><strong>Registration Start:</strong> {{ $competition->competition_registration_start }}</li>
                    <li class="list-group-item"><strong>Deadline:</strong> {{ $competition->competition_registration_deadline }}</li>
                    @if ($competition->competition_registion_link)
                        <li class="list-group-item">
                            <strong>Link:</strong> <a href="{{ $competition->competition_registion_link }}" target="_blank">View</a>
                        </li>
                    @endif
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
