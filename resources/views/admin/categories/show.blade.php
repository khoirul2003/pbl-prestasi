@extends('layout.app')

@section('content')
    <h1>Category Detail</h1>
    <p><strong>Name:</strong> {{ $category->category_name }}</p>
    <a href="{{ route('categories.index') }}">Back to Category</a>
@endsection
