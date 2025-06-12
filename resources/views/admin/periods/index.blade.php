@extends('layout.app')

@section('content')

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h4 class="card-title mb-4">Period Data</h4>

    <!-- Button trigger modal Add -->
    <button type="button" class="btn btn-primary btn-rounded btn-fw mb-3" data-bs-toggle="modal" data-bs-target="#addPeriodModal">
        <i class="bi bi-plus-circle me-2"></i> Add Period
    </button>

    <!-- Modal Add Period -->
    <div class="modal fade" id="addPeriodModal" tabindex="-1" aria-labelledby="addPeriodLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('admin.periods.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPeriodLabel">Add Period</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="academic_year_id" class="form-label">Academic Year</label>
                            <select name="academic_year_id" id="academic_year_id" class="form-select" required>
                                <option value="">-- Select Year --</option>
                                @foreach(App\Models\AcademicYear::all() as $ay)
                                    <option value="{{ $ay->academic_year_id }}">{{ $ay->academic_year }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="period_name" class="form-label">Period Name</label>
                            <input type="text" class="form-control" id="period_name" name="period_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Period</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Table for Periods -->
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>No.</th>
                    <th>Academic Year</th>
                    <th>Period Name</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($periods as $period)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $period->academic_year->academic_year }}</td>
                    <td>{{ $period->period_name }}</td>
                    <td>{{ \Carbon\Carbon::parse($period->start_date)->format('Y-m-d') }}</td>
                    <td>{{ \Carbon\Carbon::parse($period->end_date)->format('Y-m-d') }}</td>
                    <td>
                        <!-- Show Button -->
                        <button type="button" class="btn btn-info btn-sm text-white" data-bs-toggle="modal" data-bs-target="#showPeriodModal{{ $period->period_id }}">
                            <i class="bi bi-eye"></i>
                        </button>
                        <!-- Edit Button -->
                        <button type="button" class="btn btn-warning btn-sm text-white" data-bs-toggle="modal" data-bs-target="#editPeriodModal{{ $period->period_id }}">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <!-- Delete Button -->
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deletePeriodModal{{ $period->period_id }}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>

                <!-- Modal Show -->
                <div class="modal fade" id="showPeriodModal{{ $period->period_id }}" tabindex="-1" aria-labelledby="showPeriodLabel{{ $period->period_id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="showPeriodLabel{{ $period->period_id }}">Period Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Academic Year:</strong> {{ $period->academic_year->academic_year }}</p>
                                <p><strong>Period Name:</strong> {{ $period->period_name }}</p>
                                <p><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($period->start_date)->format('Y-m-d') }}</p>
                                <p><strong>End Date:</strong> {{ \Carbon\Carbon::parse($period->end_date)->format('Y-m-d') }}</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Edit -->
                <div class="modal fade" id="editPeriodModal{{ $period->period_id }}" tabindex="-1"
                    aria-labelledby="editPeriodLabel{{ $period->period_id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('admin.periods.update', $period->period_id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="editPeriodLabel{{ $period->period_id }}">Edit Period</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        {{-- Academic Year --}}
                        <div class="mb-3">
                            <label for="academic_year_id_{{ $period->period_id }}" class="form-label">Academic Year</label>
                            <select name="academic_year_id"
                                    id="academic_year_id_{{ $period->period_id }}"
                                    class="form-select @error('academic_year_id') is-invalid @enderror"
                                    required>
                            <option value="">-- Select Year --</option>
                            @foreach(\App\Models\AcademicYear::all() as $ay)
                                <option value="{{ $ay->academic_year_id }}"
                                {{ old('academic_year_id', $period->academic_year_id) == $ay->academic_year_id ? 'selected' : '' }}>
                                {{ $ay->academic_year }}
                                </option>
                            @endforeach
                            </select>
                            @error('academic_year_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- Period Name --}}
                        <div class="mb-3">
                            <label for="period_name_{{ $period->period_id }}" class="form-label">Period Name</label>
                            <input type="text"
                                name="period_name"
                                id="period_name_{{ $period->period_id }}"
                                class="form-control @error('period_name') is-invalid @enderror"
                                value="{{ old('period_name', $period->period_name) }}"
                                required>
                            @error('period_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- Start Date --}}
                        <div class="mb-3">
                            <label for="start_date_{{ $period->period_id }}" class="form-label">Start Date</label>
                            <input type="date"
                                name="start_date"
                                id="start_date_{{ $period->period_id }}"
                                class="form-control @error('start_date') is-invalid @enderror"
                                value="{{ old('start_date', \Carbon\Carbon::parse($period->start_date)->format('Y-m-d')) }}"
                                required>
                            @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- End Date --}}
                        <div class="mb-3">
                            <label for="end_date_{{ $period->period_id }}" class="form-label">End Date</label>
                            <input type="date"
                                name="end_date"
                                id="end_date_{{ $period->period_id }}"
                                class="form-control @error('end_date') is-invalid @enderror"
                                value="{{ old('end_date', \Carbon\Carbon::parse($period->end_date)->format('Y-m-d')) }}"
                                required>
                            @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        </div>
                        <div class="modal-footer">
                        <button type="button"
                                class="btn btn-secondary"
                                data-bs-dismiss="modal">Cancel</button>
                        <button type="submit"
                                class="btn btn-warning">Update</button>
                        </div>
                    </div>
                    </form>
                </div>
                </div>

                <!-- Modal Delete -->
                <div class="modal fade" id="deletePeriodModal{{ $period->period_id }}" tabindex="-1"
                    aria-labelledby="deletePeriodLabel{{ $period->period_id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('admin.periods.destroy', $period->period_id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="deletePeriodLabel{{ $period->period_id }}">Confirm Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        Are you sure you want to delete the period
                        "<strong>{{ $period->period_name }}</strong>"?
                        </div>
                        <div class="modal-footer">
                        <button type="button"
                                class="btn btn-secondary"
                                data-bs-dismiss="modal">Cancel</button>
                        <button type="submit"
                                class="btn btn-danger">Yes, Delete</button>
                        </div>
                    </div>
                    </form>
                </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
@endsection