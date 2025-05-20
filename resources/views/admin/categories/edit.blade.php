@extends('layout.app')

@section('content')
    <h1>Edit Department</h1>
    <form action="{{ route('categories.update', $category->category_id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="category_name">Category Name</label>
        <input type="text" name="category_name" value="{{ $category->category_name }}" required>
        <button type="submit">Update</button>
    </form>
@endsection
