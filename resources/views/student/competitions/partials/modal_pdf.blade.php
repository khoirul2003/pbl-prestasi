{{-- resources/views/student/competitions/partials/modal_pdf.blade.php --}}

@if ($item->competition->competition_document)
    <div class="modal fade" id="pdfModal{{ $item->request_id }}" tabindex="-1"
        aria-labelledby="pdfModalLabel{{ $item->request_id }}" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="pdfModalLabel{{ $item->request_id }}">
                        <i class="bi bi-file-earmark-pdf"></i> Document -
                        {{ $item->competition->competition_tittle }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body p-0">
                    <div class="d-flex justify-content-between align-items-center p-3 bg-light border-bottom">
                        <small class="text-muted">
                            Document for:
                            <strong>{{ $item->competition->competition_tittle }}</strong>
                        </small>
                        <div>
                            <a href="{{ asset($item->competition->competition_document) }}" target="_blank"
                                class="btn btn-outline-primary btn-sm me-2">
                                <i class="bi bi-box-arrow-up-right"></i> Open in New Tab
                            </a>
                            <a href="{{ asset($item->competition->competition_document) }}" download
                                class="btn btn-outline-success btn-sm">
                                <i class="bi bi-download"></i> Download
                            </a>
                        </div>
                    </div>

                    <div style="height: 75vh;">
                        <iframe src="{{ asset($item->competition->competition_document) }}"
                            width="100%" height="100%" style="border: none;" title="PDF Document">
                            <p>Your browser does not support PDFs.
                                <a href="{{ asset($item->competition->competition_document) }}" target="_blank">
                                    Click here to view the document
                                </a>
                            </p>
                        </iframe>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endif
