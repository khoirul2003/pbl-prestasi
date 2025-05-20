@extends('layout.app')

@section('content')

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Category Data</h4>
        <a href="{{ route('categories.create') }}" class="btn btn-primary btn-rounded btn-fw mb-2">Add Category</a>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $categories->firstItem() + $loop->index }}</td>
                            <td>{{ $category->category_name }}</td>
                            <td>
                                <a href="{{ route('categories.show', $category->category_id) }}" class="btn btn-info btn-rounded btn-fw">Show</a>
                                <a href="{{ route('categories.edit', $category->category_id) }}" class="btn btn-warning btn-rounded btn-fw">Edit</a>
                                <form action="{{ route('categories.destroy', $category->category_id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-rounded btn-fw" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

      
        <div class="mt-3">
            {{ $categories->links() }}
        </div>
    </div>
</div>

@endsection
