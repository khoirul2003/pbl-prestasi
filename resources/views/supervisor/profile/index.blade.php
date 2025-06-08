@extends('layout.app')

@section('content')
    <div class="container py-5">
        <div class="row g-4">

            {{-- Sidebar Profile --}}
            <div class="col-lg-4 col-md-5">
                <div class="card text-center border-0 shadow rounded-4">
                    <div class="card-body py-5">
                        <img src="{{ asset($supervisor->detail_supervisor_photo ? 'photos/supervisors/' . $supervisor->detail_supervisor_photo : 'photos/avatar-default.png') }}"
                            alt="Photo" class="rounded-circle shadow-sm mb-3"
                            style="width: 110px; height: 110px; object-fit: cover; border: 4px solid #f1f1f1;">

                        <h5 class="fw-semibold mb-1">{{ $supervisor->user->user_name }}</h5>
                        <p class="text-muted small mb-0">{{ $supervisor->detail_supervisor_email }}</p>

                        @if ($supervisor->supervisorSkills->count())
                            <hr class="my-3">
                            <h6 class="fw-semibold">Skills</h6>
                            <div class="d-flex flex-wrap justify-content-center gap-2">
                                @foreach ($supervisor->supervisorSkills as $supervisorSkill)
                                    <span class="badge bg-primary-subtle text-primary px-3 py-1 rounded-pill">
                                        {{ $supervisorSkill->skill->skill_name }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Profile Info --}}
            <div class="col-lg-8 col-md-7">
                <div class="card border-0 shadow rounded-4">
                    <div class="card-header bg-transparent border-bottom-0 px-4 py-3">
                        <h5 class="mb-0 fw-semibold">Profile Information</h5>
                    </div>
                    <div class="card-body px-4 py-4">
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">NIP</div>
                            <div class="col-sm-8">{{ $supervisor->detail_supervisor_nip }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">Gender</div>
                            <div class="col-sm-8">{{ $supervisor->detail_supervisor_gender }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">Date of Birth</div>
                            <div class="col-sm-8">{{ $supervisor->detail_supervisor_dob }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">Phone</div>
                            <div class="col-sm-8">{{ $supervisor->detail_supervisor_phone_no }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">Email</div>
                            <div class="col-sm-8">{{ $supervisor->detail_supervisor_email }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">Address</div>
                            <div class="col-sm-8">{{ $supervisor->detail_supervisor_address }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">Department</div>
                            <div class="col-sm-8">{{ $supervisor->department->department_name ?? '-' }}</div>
                        </div>

                        <div class="text-end">
                            <button class="btn btn-outline-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                                Edit Profile
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <form action="{{ route('supervisor.profile.update') }}" method="POST" enctype="multipart/form-data" class="modal-content">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body row g-3">
          <div class="col-md-6">
            <label class="form-label">Name</label>
            <input type="text" name="user_name" class="form-control" value="{{ $supervisor->user->user_name }}" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="email" name="detail_supervisor_email" class="form-control" value="{{ $supervisor->detail_supervisor_email }}" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Gender</label>
            <select name="detail_supervisor_gender" class="form-select" required>
              <option value="Male" {{ $supervisor->detail_supervisor_gender == 'Male' ? 'selected' : '' }}>Male</option>
              <option value="Female" {{ $supervisor->detail_supervisor_gender == 'Female' ? 'selected' : '' }}>Female</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">Date of Birth</label>
            <input type="date" name="detail_supervisor_dob" class="form-control" value="{{ $supervisor->detail_supervisor_dob }}" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Phone</label>
            <input type="text" name="detail_supervisor_phone_no" class="form-control" value="{{ $supervisor->detail_supervisor_phone_no }}" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Address</label>
            <input type="text" name="detail_supervisor_address" class="form-control" value="{{ $supervisor->detail_supervisor_address }}" required>
          </div>
          <div class="col-12">
            <label class="form-label">Photo</label>
            <input type="file" name="detail_supervisor_photo" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
      </form>
    </div>
  </div>

@endsection
