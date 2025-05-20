@extends('layout.app')

@section('content')

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Study Program Data</h4>
            <a href="" class="btn btn-primary btn-rounded btn-fw mb-2">Add Study Program</a>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Department</th>
                            <th>Study Program</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($study_programs as $study_program)
                            <tr>
                                <td>{{ $study_program->study_program_id }}</td>
                                <td>{{ $study_program->departments->department_name }}</td>
                                <td>{{ $study_program->study_program_name }}</td>
                                <td>
                                    <a href="" class="btn btn-info btn-rounded btn-fw">Show</a>
                                    <a href="" class="btn btn-warning btn-rounded btn-fw">Edit</a>
                                    <form action="" method="POST" style="display:inline;">
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
