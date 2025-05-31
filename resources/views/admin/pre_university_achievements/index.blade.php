@extends('layout.app')

@section('content')

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h4 class="card-title mb-4">Pre-University Achievements List</h4>

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
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($preUniversityAchievements as $achievement)
                        <tr>
                            <td>{{ $preUniversityAchievements->firstItem() + $loop->index }}</td>
                            <td>{{ $achievement->user->user_name ?? '-' }}</td>
                            <td>{{ $achievement->category->category_name ?? '-' }}</td>
                            <td>{{ $achievement->pre_university_achievement_title }}</td>
                            <td>{{ $achievement->pre_university_achievement_ranking ?? '-' }}</td>
                            <td>{{ ucfirst($achievement->pre_university_achievement_level ?? '-') }}</td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm btn-rounded btn-fw text-white"
                                        data-bs-toggle="modal"
                                        data-bs-target="#showAchievementModal{{ $achievement->pre_university_achievement_id }}">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Modal Show Achievement -->
                        <div class="modal fade" id="showAchievementModal{{ $achievement->pre_university_achievement_id }}" tabindex="-1" aria-labelledby="showAchievementLabel{{ $achievement->pre_university_achievement_id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="showAchievementLabel{{ $achievement->pre_university_achievement_id }}">Achievement Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-4 text-center">
                                                @if($achievement->pre_university_achievement_photo)
                                                <img src="{{ asset('photos/achievements/' . $achievement->pre_university_achievement_photo) }}" alt="Achievement Photo" class="img-fluid rounded shadow-sm mb-3" style="max-height: 250px; object-fit: cover;">
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
                                                    <dd class="col-sm-8">{{ $achievement->pre_university_achievement_title }}</dd>

                                                    <dt class="col-sm-4">Description</dt>
                                                    <dd class="col-sm-8">{{ $achievement->pre_university_achievement_description ?? '-' }}</dd>

                                                    <dt class="col-sm-4">Ranking</dt>
                                                    <dd class="col-sm-8">{{ $achievement->pre_university_achievement_ranking ?? '-' }}</dd>

                                                    <dt class="col-sm-4">Level</dt>
                                                    <dd class="col-sm-8">{{ ucfirst($achievement->pre_university_achievement_level ?? '-') }}</dd>

                                                    <dt class="col-sm-4">Event Date</dt>
                                                    <dd class="col-sm-8">{{ $achievement->pre_university_achievement_date ?? '-' }}</dd>

                                                    <dt class="col-sm-4">Location</dt>
                                                    <dd class="col-sm-8">{{ $achievement->pre_university_achievement_location ?? '-' }}</dd>

                                                    @if($achievement->pre_university_achievement_certificate)
                                                    <dt class="col-sm-4">Certificate</dt>
                                                    <dd class="col-sm-8">
                                                        <a href="{{ asset('certificates/' . $achievement->pre_university_achievement_certificate) }}" target="_blank" class="btn btn-sm btn-outline-primary">
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

                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No achievements found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-3">
            {{ $preUniversityAchievements->links() }}
        </div>
    </div>
</div>

@endsection
