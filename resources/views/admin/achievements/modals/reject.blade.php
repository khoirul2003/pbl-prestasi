<div class="modal fade" id="rejectModal{{ $achievement->achievement_id }}" tabindex="-1" aria-labelledby="rejectModalLabel{{ $achievement->achievement_id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('achievements.reject', $achievement->achievement_id) }}" method="POST">
                @csrf
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="rejectModalLabel{{ $achievement->achievement_id }}">
                        <i class="bi bi-x-circle"></i> Reject Achievement
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to reject the achievement <strong>{{ $achievement->achievement_title }}</strong> by <strong>{{ $achievement->user->user_name ?? '-' }}</strong>?</p>
                    <div class="mb-3">
                        <label for="rejectionDescription{{ $achievement->achievement_id }}" class="form-label">Rejection Reason</label>
                        <textarea class="form-control" id="rejectionDescription{{ $achievement->achievement_id }}" name="rejection_description" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject</button>
                </div>
            </form>
        </div>
    </div>
</div>
