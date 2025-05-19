@extends('layout.app')

@section('content')


    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Department Data</h4>
            <a href="{{ route('departments.create') }}" class="btn btn-primary btn-rounded btn-fw mb-2">Add
                Department</a>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th >Department</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($departments as $department)
                            <tr>
                                <td>{{ $department->department_id }}</td>
                                <td>{{ $department->department_name }}</td>
                                <td>
                                    <a href="{{ route('departments.show', $department->department_id) }}" class="btn btn-info btn-rounded btn-fw">Show</a>
                                    <a href="{{ route('departments.edit', $department->department_id) }}" class="btn btn-warning btn-rounded btn-fw">Edit</a>
                                    <form action="{{ route('departments.destroy', $department->department_id) }}"
                                        method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-rounded btn-fw">Delete</button>
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
