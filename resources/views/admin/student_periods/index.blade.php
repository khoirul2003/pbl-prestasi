@extends('layout.app')

@section('content')
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h4 class="card-title mb-4">Student Period Data</h4>

        <!-- Button trigger modal Add -->
        <button type="button" class="btn btn-primary btn-rounded btn-fw mb-3" data-bs-toggle="modal" data-bs-target="#addStudentPeriodModal">
            <i class="bi bi-plus-circle me-2"></i> Add Student Period
        </button>

        <!-- Modal Add Student Period -->
        <div class="modal fade" id="addStudentPeriodModal" tabindex="-1" aria-labelledby="addStudentPeriodLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('admin.student_periods.store') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addStudentPeriodLabel">Add Student Period</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="detail_student_id" class="form-label">Student</label>
                                <select name="detail_student_id" id="detail_student_id" class="form-select" required>
                                    <option value="">-- Select Student --</option>
                                    @foreach($students as $student)
                                        <option value="{{ $student->detail_student_id }}">{{ $student->user->user_name }} ({{ $student->user->user_username }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="period_id" class="form-label">Period</label>
                                <select name="period_id" id="period_id" class="form-select" required>
                                    <option value="">-- Select Period --</option>
                                    @foreach($periods as $period)
                                        <option value="{{ $period->period_id }}">{{ $period->academic_year->academic_year }} - {{ $period->period_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="ipk" class="form-label">IPK</label>
                                <input type="number" step="0.01" min="0" max="4" class="form-control" id="ipk" name="ipk" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table for Student Periods -->
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No.</th>
                        <th>Student</th>
                        <th>Period</th>
                        <th>IPK</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($studentPeriods as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->detailStudent->user->user_name }} ({{ $item->detailStudent->user->user_username }})</td>
                        <td>{{ $item->period->academic_year->academic_year }} - {{ $item->period->period_name }}</td>
                        <td>{{ number_format($item->ipk, 2) }}</td>
                        <td>
                            <!-- Show Button -->
                            <button type="button" class="btn btn-info btn-sm text-white" data-bs-toggle="modal" data-bs-target="#showStudentPeriodModal{{ $item->student_period_id }}">
                                <i class="bi bi-eye"></i>
                            </button>
                            <!-- Edit Button -->
                            <button type="button" class="btn btn-warning btn-sm text-white" data-bs-toggle="modal" data-bs-target="#editStudentPeriodModal{{ $item->student_period_id }}">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <!-- Delete Button -->
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteStudentPeriodModal{{ $item->student_period_id }}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>

                    <!-- Modal Show -->
                    <div class="modal fade" id="showStudentPeriodModal{{ $item->student_period_id }}" tabindex="-1" aria-labelledby="showStudentPeriodLabel{{ $item->student_period_id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="showStudentPeriodLabel{{ $item->student_period_id }}">Student Period Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Student:</strong> {{ $item->detailStudent->user->user_name }} ({{ $item->detailStudent->user->user_username }})</p>
                                    <p><strong>Period:</strong> {{ $item->period->academic_year->academic_year }} - {{ $item->period->period_name }}</p>
                                    <p><strong>IPK:</strong> {{ number_format($item->ipk, 2) }}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Edit -->
                    <div class="modal fade" id="editStudentPeriodModal{{ $item->student_period_id }}" tabindex="-1" aria-labelledby="editStudentPeriodLabel{{ $item->student_period_id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('admin.student_periods.update', $item->student_period_id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editStudentPeriodLabel{{ $item->student_period_id }}">Edit Student Period</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="detail_student_id_{{ $item->student_period_id }}" class="form-label">Student</label>
                                            <select name="detail_student_id" id="detail_student_id_{{ $item->student_period_id }}" class="form-select @error('detail_student_id') is-invalid @enderror" required>
                                                <option value="">-- Select Student --</option>
                                                @foreach($students as $student)
                                                    <option value="{{ $student->detail_student_id }}" {{ old('detail_student_id', $item->detail_student_id)==$student->detail_student_id?'selected':'' }}>{{ $student->user->user_name }} ({{ $student->user->user_username }})</option>
                                                @endforeach
                                            </select>
                                            @error('detail_student_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="period_id_{{ $item->student_period_id }}" class="form-label">Period</label>
                                            <select name="period_id" id="period_id_{{ $item->student_period_id }}" class="form-select @error('period_id') is-invalid @enderror" required>
                                                <option value="">-- Select Period --</option>
                                                @foreach($periods as $period)
                                                    <option value="{{ $period->period_id }}" {{ old('period_id', $item->period_id)==$period->period_id?'selected':'' }}>{{ $period->academic_year->academic_year }} - {{ $period->period_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('period_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="ipk_{{ $item->student_period_id }}" class="form-label">IPK</label>
                                            <input type="number" step="0.01" min="0" max="4" name="ipk" id="ipk_{{ $item->student_period_id }}" class="form-control @error('ipk') is-invalid @enderror" value="{{ old('ipk', $item->ipk) }}" required>
                                            @error('ipk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-warning">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Modal Delete -->
                    <div class="modal fade" id="deleteStudentPeriodModal{{ $item->student_period_id }}" tabindex="-1" aria-labelledby="deleteStudentPeriodLabel{{ $item->student_period_id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('admin.student_periods.destroy', $item->student_period_id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteStudentPeriodLabel{{ $item->student_period_id }}">Confirm Delete</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete the student period record for
                                        "<strong>{{ $item->detailStudent->user->user_name }}</strong>"?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>

          <div class="mt-3">
            {{ $studentPeriods->links() }}
          </div>

        </div>
    </div>
</div>
@endsection