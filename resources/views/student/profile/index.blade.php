@extends('layout.app')

@section('content')
    <div class="container py-5">
        <div class="row g-4">

            {{-- Sidebar Profile --}}
            <div class="col-lg-4 col-md-5">
                <div class="card text-center border-0 shadow rounded-4">
                    <div class="card-body py-5">
                        <img src="{{ asset($student->detail_student_photo ? 'photos/students/' . $student->detail_student_photo : 'photos/avatar-default.png') }}"
                            alt="Photo" class="rounded-circle shadow-sm mb-3"
                            style="width: 110px; height: 110px; object-fit: cover; border: 4px solid #f1f1f1;">

                        <h5 class="fw-semibold mb-1">{{ $student->user->user_name }}</h5>
                        <p class="text-muted small mb-0">{{ $student->detail_student_email }}</p>

                        @if ($student->studentSkills->count())
                            <hr class="my-3">
                            <h6 class="fw-semibold">Skills</h6>
                            <div class="d-flex flex-wrap justify-content-center gap-2">
                                @foreach ($student->studentSkills as $studentSkill)
                                    <span class="badge bg-primary-subtle text-primary px-3 py-1 rounded-pill">
                                        {{ $studentSkill->skill->skill_name }}
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
                            <div class="col-sm-4 text-muted">NIM</div>
                            <div class="col-sm-8">{{ $student->detail_student_nim }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">Gender</div>
                            <div class="col-sm-8">{{ $student->detail_student_gender }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">Date of Birth</div>
                            <div class="col-sm-8">{{ $student->detail_student_dob }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">Phone</div>
                            <div class="col-sm-8">{{ $student->detail_student_phone_no }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">Email</div>
                            <div class="col-sm-8">{{ $student->detail_student_email }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">Address</div>
                            <div class="col-sm-8">{{ $student->detail_student_address }}</div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">Study Program</div>
                            <div class="col-sm-8">{{ $student->studyProgram->study_program_name ?? '-' }}</div>
                        </div>

                        @if (isset($averageIpk))
                            <div class="row mb-3">
                                <div class="col-sm-4 text-muted">Average IPK</div>
                                <div class="col-sm-8">{{ number_format($averageIpk, 2) }}</div>
                            </div>
                        @endif

                        @if (isset($latestPeriod) && $semesterCount)
                            <div class="row mb-4">
                                <div class="col-sm-4 text-muted">Latest Semester</div>
                                <div class="col-sm-8">
                                    Semester {{ $semesterCount }} -
                                    {{ $latestPeriod->period_name }}
                                    ({{ \Carbon\Carbon::parse($latestPeriod->start_date)->format('M Y') }} -
                                    {{ \Carbon\Carbon::parse($latestPeriod->end_date)->format('M Y') }})
                                </div>
                            </div>
                        @endif

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
      <form action="{{ route('student.profile.update') }}" method="POST" enctype="multipart/form-data" class="modal-content">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body row g-3">
          <div class="col-md-6">
            <label class="form-label">Name</label>
            <input type="text" name="user_name" class="form-control" value="{{ $student->user->user_name }}" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="email" name="detail_student_email" class="form-control" value="{{ $student->detail_student_email }}" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Gender</label>
            <select name="detail_student_gender" class="form-select" required>
              <option value="Male" {{ $student->detail_student_gender == 'Male' ? 'selected' : '' }}>Male</option>
              <option value="Female" {{ $student->detail_student_gender == 'Female' ? 'selected' : '' }}>Female</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">Date of Birth</label>
            <input type="date" name="detail_student_dob" class="form-control" value="{{ $student->detail_student_dob }}" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Phone</label>
            <input type="text" name="detail_student_phone_no" class="form-control" value="{{ $student->detail_student_phone_no }}" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Address</label>
            <input type="text" name="detail_student_address" class="form-control" value="{{ $student->detail_student_address }}" required>
          </div>
          <div class="col-12">
            <label class="form-label">Photo</label>
            <input type="file" name="detail_student_photo" class="form-control">
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
