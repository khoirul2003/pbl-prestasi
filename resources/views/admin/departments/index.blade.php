@extends('layout.app')

@section('content')
    <h1>Departments</h1>
    <a href="{{ route('departments.create') }}">Create New Department</a>
    <table style="border: 1 solid">
        <thead>
            <tr>
                <th>No.</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($departments as $department)
                <tr>
                    <td>{{ $department->department_id }}</td>
                    <td>{{ $department->department_name }}</td>
                    <td>
                        <a href="{{ route('departments.show', $department->department_id) }}">Show</a>
                        <a href="{{ route('departments.edit', $department->department_id) }}">Edit</a>
                        <form action="{{ route('departments.destroy', $department->department_id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
