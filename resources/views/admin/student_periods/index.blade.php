@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Student Period Data</h4>
        <a href="{{ route('student_periods.create') }}" class="btn btn-primary btn-rounded btn-fw mb-2">Add Student Period</a>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Period</th>
                        <th>Detail Student</th>
                        <th>IPK</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($student_periods as $student_period)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $student_period->period->period_name ?? '-' }}</td>
                            <td>{{ $student_period->detailStudent->student_name ?? '-' }}</td>
                            <td>{{ $student_period->ipk }}</td>
                            <td>
                                <a href="{{ route('student_periods.show', $student_period->student_period_id) }}" class="btn btn-info btn-rounded btn-fw">Show</a>
                                <a href="{{ route('student_periods.edit', $student_period->student_period_id) }}" class="btn btn-warning btn-rounded btn-fw">Edit</a>
                                <form action="{{ route('student_periods.destroy', $student_period->student_period_id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-rounded btn-fw" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
