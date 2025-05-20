@extends('layout.app')

@section('content')
    <h1>Department Detail</h1>
    <p><strong>Name:</strong> {{ $department->department_name }}</p>
    <a href="{{ route('departments.index') }}">Back to Departments</a>
@endsection
