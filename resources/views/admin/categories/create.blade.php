@extends('layout.app')

@section('content')
    <h1>Create New Category</h1>
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <label for="category_name">Department Name</label>
        <input type="text" name="category_name" required>
        <button type="submit">Save</button>
    </form>
@endsection
