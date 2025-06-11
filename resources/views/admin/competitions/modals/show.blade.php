<div class="modal fade" id="showModal{{ $competition->competition_id }}" tabindex="-1"
    aria-labelledby="showModalLabel{{ $competition->competition_id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="min-height: 95vh;">
            <div class="modal-header ">
                <h5 class="modal-title" id="showModalLabel{{ $competition->competition_id }}">
                    <i class="bi bi-info-circle"></i> Competition Detail
                </h5>
                <button type="button" class="btn-close btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row h-100">
                    {{-- Left Side: Image --}}
                    <div class="col-md-5 d-flex align-items-center justify-content-center mb-3 mb-md-0">
                        @php
                            $extension = strtolower(pathinfo($competition->competition_document, PATHINFO_EXTENSION));
                            $isImage = in_array($extension, ['jpg', 'jpeg', 'png']);
                        @endphp

                        @if ($isImage && $competition->competition_document)
                            <div class="border rounded shadow-sm overflow-hidden"
                                style="width: 100%; max-width: 400px; height: 430px;">
                                <img src="{{ asset($competition->competition_document) }}" alt="Competition Image"
                                    class="w-100 h-100" style="object-fit: cover;">
                            </div>
                        @else
                            <div class="text-muted text-center">
                                <i class="bi bi-file-earmark-pdf fs-1"></i>
                                <p class="mt-2">No image preview available</p>
                            </div>
                        @endif
                    </div>


                    {{-- Right Side: Details --}}
                    <div class="col-md-7">
                        <h4 class="fw-bold mb-3">{{ $competition->competition_tittle }}</h4>

                        <p class="mb-2">
                            <strong>Description:</strong><br>
                            {{ $competition->competition_description }}
                        </p>

                        <p class="mb-1">
                            <strong>Category:</strong> {{ $competition->category->category_name ?? '-' }}
                        </p>

                        <p class="mb-1">
                            <strong>Organizer:</strong> {{ $competition->competition_organizer }}
                        </p>

                        <p class="mb-1">
                            <strong>Level:</strong> {{ ucfirst($competition->competition_level) }}
                        </p>

                        <p class="mb-1">
                            <strong>Registration:</strong>
                            {{ \Carbon\Carbon::parse($competition->competition_registration_start)->format('d M Y') }} –
                            {{ \Carbon\Carbon::parse($competition->competition_registration_deadline)->format('d M Y') }}
                        </p>

                        @if ($competition->competition_registration_link)
                            <p class="mb-0">
                                <strong>Registration Link:</strong>
                                <a href="{{ $competition->competition_registration_link }}" target="_blank"
                                    class="text-decoration-underline">
                                    {{ $competition->competition_registration_link }}
                                </a>
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
