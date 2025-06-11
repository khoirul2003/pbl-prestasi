{{-- resources/views/student/competitions/partials/modal_detail.blade.php --}}

<div class="modal fade" id="detailModal{{ $item->competition->competition_id }}"
    tabindex="-1"
    aria-labelledby="detailModalLabel{{ $item->competition->competition_id }}"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="min-height: 95vh;">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel{{ $item->competition->competition_id }}">
                    <i class="bi bi-info-circle"></i> Competition Detail
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row h-100">
                    {{-- Left Side: Image Preview --}}
                    <div class="col-md-5 d-flex align-items-center justify-content-center mb-3 mb-md-0">
                        @php
                            $extension = strtolower(pathinfo($item->competition->competition_document, PATHINFO_EXTENSION));
                            $isImage = in_array($extension, ['jpg', 'jpeg', 'png']);
                        @endphp

                        @if ($isImage && $item->competition->competition_document)
                            <div class="border rounded shadow-sm overflow-hidden"
                                style="width: 100%; max-width: 400px; height: 430px;">
                                <img src="{{ asset($item->competition->competition_document) }}"
                                     alt="Competition Image"
                                     class="w-100 h-100"
                                     style="object-fit: cover;">
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
                        <h4 class="fw-bold mb-3">{{ $item->competition->competition_tittle }}</h4>

                        <p class="mb-2">
                            <strong>Description:</strong><br>
                            {{ $item->competition->competition_description }}
                        </p>

                        <p class="mb-1">
                            <strong>Category:</strong> {{ $item->competition->category->category_name ?? '-' }}
                        </p>

                        <p class="mb-1">
                            <strong>Organizer:</strong> {{ $item->competition->competition_organizer }}
                        </p>

                        <p class="mb-1">
                            <strong>Level:</strong> {{ ucfirst($item->competition->competition_level) }}
                        </p>

                        <p class="mb-1">
                            <strong>Registration:</strong>
                            {{ \Carbon\Carbon::parse($item->competition->competition_registration_start)->format('d M Y') }} –
                            {{ \Carbon\Carbon::parse($item->competition->competition_registration_deadline)->format('d M Y') }}
                        </p>

                        @if ($item->competition->competition_registration_link)
                            <p class="mb-0">
                                <strong>Registration Link:</strong>
                                <a href="{{ $item->competition->competition_registration_link }}"
                                   target="_blank"
                                   class="text-decoration-underline">
                                    {{ $item->competition->competition_registration_link }}
                                </a>
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
