@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Period Data</h4>
        <a href="{{ route('periods.create') }}" class="btn btn-primary btn-rounded btn-fw mb-2">Add Period</a>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Academic Year</th>
                        <th>Period Name</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($periods as $period)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $period->academic_year->academic_year ?? '-' }}</td>
                            <td>{{ $period->period_name }}</td>
                            <td>{{ $period->start_date }}</td>
                            <td>{{ $period->end_date }}</td>
                            <td>
                                <a href="{{ route('periods.show', $period->period_id) }}" class="btn btn-info btn-rounded btn-fw">Show</a>
                                <a href="{{ route('periods.edit', $period->period_id) }}" class="btn btn-warning btn-rounded btn-fw">Edit</a>
                                <form action="{{ route('periods.destroy', $period->period_id) }}" method="POST" style="display:inline;">
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
