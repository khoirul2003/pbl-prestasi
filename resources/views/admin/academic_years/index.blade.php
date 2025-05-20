@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Academic Year Data</h4>
        <a href="{{ route('academic_years.create') }}" class="btn btn-primary btn-rounded btn-fw mb-2">Add Academic Year</a>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Academic Year</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($academic_years as $academic_year)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $academic_year->academic_year }}</td>
                            <td>{{ $academic_year->start_date }}</td>
                            <td>{{ $academic_year->end_date }}</td>
                            <td>
                                <a href="" class="btn btn-info btn-rounded btn-fw">Show</a>
                                <a href="" class="btn btn-warning btn-rounded btn-fw">Edit</a>
                                <form action="" method="POST" style="display:inline;">
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
