<div class="modal fade" id="showModal{{ $achievement->achievement_id }}" tabindex="-1"
    aria-labelledby="showModalLabel{{ $achievement->achievement_id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="min-height: 95vh;">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="showModalLabel{{ $achievement->achievement_id }}">
                    <i class="bi bi-eye"></i> Achievement Detail
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row h-100">
                    {{-- Left Side: Image or Document --}}
                    <div class="col-md-5 d-flex align-items-center justify-content-center mb-3 mb-md-0">
                        @php
                            $extension = strtolower(pathinfo($achievement->achievement_document, PATHINFO_EXTENSION));
                            $isImage = in_array($extension, ['jpg', 'jpeg', 'png']);
                        @endphp

                        @if ($isImage && $achievement->achievement_document)
                            <div class="border rounded shadow-sm overflow-hidden"
                                style="width: 100%; max-width: 400px; height: 430px;">
                                <img src="{{ asset($achievement->achievement_document) }}" alt="Achievement Image"
                                    class="w-100 h-100" style="object-fit: cover;">
                            </div>
                        @elseif($achievement->achievement_document)
                            <div class="text-center">
                                <i class="bi bi-file-earmark-pdf fs-1 text-muted"></i>
                                <p class="mt-2">Document available</p>
                                <a href="{{ asset($achievement->achievement_document) }}" target="_blank"
                                    class="btn btn-outline-primary btn-sm">
                                    View Document
                                </a>
                            </div>
                        @else
                            <div class="text-muted text-center">
                                <i class="bi bi-file-earmark-x fs-1"></i>
                                <p class="mt-2">No document uploaded</p>
                            </div>
                        @endif
                    </div>

                    {{-- Right Side: Details --}}
                    <div class="col-md-7">
                        <h4 class="fw-bold mb-3">{{ $achievement->achievement_title }}</h4>

                        <p class="mb-2"><strong>Student:</strong> {{ $achievement->user->user_name ?? '-' }}</p>
                        <p class="mb-2"><strong>Ranking:</strong> {{ $achievement->achievement_ranking }}</p>
                        <p class="mb-2"><strong>Level:</strong> {{ ucfirst($achievement->achievement_level) }}</p>
                        <p class="mb-2">
                            <strong>Status:</strong>
                            @if ($achievement->achievement_verified === 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif ($achievement->achievement_verified === 'approved')
                                <span class="badge bg-success">Approved</span>
                            @elseif ($achievement->achievement_verified === 'rejected')
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </p>

                        @if ($achievement->achievement_verified === 'rejected' && $achievement->achievement_rejection_description)
                            <div class="alert alert-danger">
                                <strong>Rejection Reason:</strong><br>
                                {{ $achievement->achievement_rejection_description }}
                            </div>
                        @endif

                        <p class="mb-2"><strong>Description:</strong><br>{{ $achievement->achievement_description }}</p>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
