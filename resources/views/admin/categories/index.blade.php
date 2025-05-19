@extends('layout.app')

@section('content')
    <h1>Category</h1>
    <a href="{{ route('categories.create') }}">Create New Category</a>
    <table style="border: 1 solid">
        <thead>
            <tr>
                <th>No.</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->category_id }}</td>
                    <td>{{ $category->category_name }}</td>
                    <td>
                        <a href="{{ route('categories.show', $category->category_id) }}">Show</a>
                        <a href="{{ route('categories.edit', $category->category_id) }}">Edit</a>
                        <form action="{{ route('categories.destroy', $category->category_id) }}" method="POST" style="display:inline;">
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
