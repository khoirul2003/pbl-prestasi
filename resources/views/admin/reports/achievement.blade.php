@extends('layout.app')

@section('content')
<div class="container py-4">

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h4 class="card-title mb-4 text-primary">Achievement Report</h4>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Student</th>
                            <th>Category</th>
                            <th>Title</th>
                            <th>Ranking</th>
                            <th>Level</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($achievements as $achievement)
                            <tr>
                                <td>{{ $achievements->firstItem() + $loop->index }}</td>
                                <td>{{ $achievement->user->user_name ?? '-' }}</td>
                                <td>{{ $achievement->category->category_name ?? '-' }}</td>
                                <td>{{ $achievement->achievement_title }}</td>
                                <td>{{ $achievement->achievement_ranking ?? '-' }}</td>
                                <td>{{ ucfirst($achievement->achievement_level ?? '-') }}</td>
                            </tr>

                            <!-- Modal Show Achievement -->
                            <div class="modal fade" id="showAchievementModal{{ $achievement->achievement_id }}" tabindex="-1" aria-labelledby="showAchievementLabel{{ $achievement->achievement_id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-dark text-white">
                                            <h5 class="modal-title" id="showAchievementLabel{{ $achievement->achievement_id }}">Achievement Details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-4 text-center">
                                                    @if($achievement->achievement_photo)
                                                        <img src="{{ asset('photos/achievements/' . $achievement->achievement_photo) }}" alt="Achievement Photo" class="img-fluid rounded shadow-sm mb-3" style="max-height: 250px; object-fit: cover;">
                                                    @else
                                                        <div class="border rounded d-flex align-items-center justify-content-center mb-3" style="height: 250px; background-color: #f8f9fa; color: #6c757d;">
                                                            No Photo
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-md-8">
                                                    <dl class="row">
                                                        <dt class="col-sm-4">Student</dt>
                                                        <dd class="col-sm-8">{{ $achievement->user->user_name ?? '-' }}</dd>

                                                        <dt class="col-sm-4">Category</dt>
                                                        <dd class="col-sm-8">{{ $achievement->category->category_name ?? '-' }}</dd>

                                                        <dt class="col-sm-4">Title</dt>
                                                        <dd class="col-sm-8">{{ $achievement->achievement_title }}</dd>

                                                        <dt class="col-sm-4">Description</dt>
                                                        <dd class="col-sm-8">{{ $achievement->achievement_description ?? '-' }}</dd>

                                                        <dt class="col-sm-4">Ranking</dt>
                                                        <dd class="col-sm-8">{{ $achievement->achievement_ranking ?? '-' }}</dd>

                                                        <dt class="col-sm-4">Level</dt>
                                                        <dd class="col-sm-8">{{ ucfirst($achievement->achievement_level ?? '-') }}</dd>

                                                        <dt class="col-sm-4">Event Date</dt>
                                                        <dd class="col-sm-8">{{ $achievement->achievement_date ?? '-' }}</dd>

                                                        <dt class="col-sm-4">Location</dt>
                                                        <dd class="col-sm-8">{{ $achievement->achievement_location ?? '-' }}</dd>

                                                        @if($achievement->achievement_certificate)
                                                            <dt class="col-sm-4">Certificate</dt>
                                                            <dd class="col-sm-8">
                                                                <a href="{{ asset('certificates/' . $achievement->achievement_certificate) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                                    <i class="bi bi-file-earmark-pdf"></i> View Certificate
                                                                </a>
                                                            </dd>
                                                        @endif
                                                    </dl>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination Links -->
            <div class="mt-3">
                {{ $achievements->links() }}
            </div>
        </div>
    </div>
</div>

@endsection
