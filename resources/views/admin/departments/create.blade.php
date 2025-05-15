@extends('layout.app')

@section('content')
    <h1>Create New Department</h1>
    <form action="{{ route('departments.store') }}" method="POST">
        @csrf
        <label for="department_name">Department Name</label>
        <input type="text" name="department_name" required>
        <button type="submit">Save</button>
    </form>
@endsection
