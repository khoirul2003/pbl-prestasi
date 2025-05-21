@extends('layout.app')

@section('content')

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Student Data</h4>
        <a href="{{ route('students.create') }}" class="btn btn-primary btn-rounded btn-fw mb-2">Add Student</a>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>NIM</th>
                        <th>Study Program</th>
                        <th>Gender</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <td>{{ $students->firstItem() + $loop->index }}</td>
                            <td>{{ $student->user_name }}</td>
                            <td>{{ $student->user_username }}</td>
                            <td>{{ $student->detailStudent->detail_student_nim ?? '-' }}</td>
                            <td>{{ $student->detailStudent->studyProgram->study_program_name ?? '-' }}</td>
                            <td>{{ ucfirst($student->detailStudent->detail_student_gender ?? '-') }}</td>
                            <td>{{ $student->detailStudent->detail_student_email ?? '-' }}</td>
                            <td>{{ $student->detailStudent->detail_student_phone_no ?? '-' }}</td>
                            <td>
                                <a href="{{ route('students.edit', $student->user_id) }}" class="btn btn-warning btn-rounded btn-fw">Edit</a>
                                <form action="{{ route('students.destroy', $student->user_id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-rounded btn-fw" onclick="return confirm('Are you sure want to delete this student?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $students->links() }}
        </div>
    </div>
</div>

@endsection
