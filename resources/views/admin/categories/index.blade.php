@extends('layout.app')

@section('content')

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h4 class="card-title mb-4">Category Data</h4>

        <!-- Button to Open Add Category Modal -->
        <button type="button" class="btn btn-primary btn-rounded btn-fw mb-3" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
            <i class="bi bi-plus-circle me-2"></i> Add Category
        </button>

        <!-- Modal Add Category -->
        <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addCategoryLabel">Add Category</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="category_name" class="form-label">Category Name</label>
                                <input type="text" class="form-control" id="category_name" name="category_name" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add Category</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table for Categories -->
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No.</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $category->category_name }}</td>
                        <td>
                            <!-- Show Button -->
                            <button type="button" class="btn btn-info btn-rounded btn-sm text-white" data-bs-toggle="modal" data-bs-target="#showCategoryModal{{ $category->category_id }}">
                                <i class="bi bi-eye"></i> Show
                            </button>

                            <!-- Edit Button -->
                            <button type="button" class="btn btn-warning btn-rounded btn-sm text-white" data-bs-toggle="modal" data-bs-target="#editCategoryModal{{ $category->category_id }}">
                                <i class="bi bi-pencil-square"></i> Edit
                            </button>

                            <!-- Delete Button -->
                            <button type="button" class="btn btn-danger btn-rounded btn-sm" data-bs-toggle="modal" data-bs-target="#deleteCategoryModal{{ $category->category_id }}">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </td>
                    </tr>

                    <!-- Show Category Modal -->
                    <div class="modal fade" id="showCategoryModal{{ $category->category_id }}" tabindex="-1" aria-labelledby="showCategoryLabel{{ $category->category_id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="showCategoryLabel{{ $category->category_id }}">Category Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>ID:</strong> {{ $category->category_id }}</p>
                                    <p><strong>Category Name:</strong> {{ $category->category_name }}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Category Modal -->
                    <div class="modal fade" id="editCategoryModal{{ $category->category_id }}" tabindex="-1" aria-labelledby="editCategoryLabel{{ $category->category_id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('categories.update', $category->category_id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editCategoryLabel{{ $category->category_id }}">Edit Category</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="category_name_{{ $category->category_id }}" class="form-label">Category Name</label>
                                            <input type="text" class="form-control" id="category_name_{{ $category->category_id }}" name="category_name" value="{{ $category->category_name }}" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-warning">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Delete Category Modal -->
                    <div class="modal fade" id="deleteCategoryModal{{ $category->category_id }}" tabindex="-1" aria-labelledby="deleteCategoryLabel{{ $category->category_id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('categories.destroy', $category->category_id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteCategoryLabel{{ $category->category_id }}">Confirm Delete</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete the category "<strong>{{ $category->category_name }}</strong>"?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-3">
            {{ $categories->links() }}
        </div>

    </div>
</div>

@endsection
