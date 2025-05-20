@extends('layout.app')

@section('content')
    <h1>Edit Department</h1>
    <form action="{{ route('departments.update', $department->department_id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="department_name">Department Name</label>
        <input type="text" name="department_name" value="{{ $department->department_name }}" required>
        <button type="submit">Update</button>
    </form>
@endsection
