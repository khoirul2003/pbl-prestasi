@extends('layout.app')

@section('content')

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h4 class="card-title mb-4">Skill Data</h4>

        <!-- Button trigger modal Add -->
        <button type="button" class="btn btn-primary btn-rounded btn-fw mb-3" data-bs-toggle="modal" data-bs-target="#addSkillModal">
            <i class="bi bi-plus-circle"></i> Add Skill
        </button>

        <!-- Modal Add Skill -->
        <div class="modal fade" id="addSkillModal" tabindex="-1" aria-labelledby="addSkillLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('skills.store') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addSkillLabel">Add Skill</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="skill_name" class="form-label">Skill Name</label>
                                <input type="text" class="form-control" id="skill_name" name="skill_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Category</label>
                                <select class="form-select" id="category_id" name="category_id" required>
                                    <option disabled selected>-- Select Category --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add Skill</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table with Skills -->
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No.</th>
                        <th>Skill</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($skills as $skill)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $skill->skill_name }}</td>
                            <td>{{ $skill->category->category_name ?? '-' }}</td>
                            <td>
                                <!-- Show Button -->
                                <button type="button" class="btn btn-info btn-sm btn-rounded btn-fw" data-bs-toggle="modal" data-bs-target="#showSkillModal{{ $skill->skill_id }}">
                                    <i class="bi bi-eye"></i> Show
                                </button>

                                <!-- Edit Button -->
                                <button type="button" class="btn btn-warning btn-sm btn-rounded btn-fw" data-bs-toggle="modal" data-bs-target="#editSkillModal{{ $skill->skill_id }}">
                                    <i class="bi bi-pencil"></i> Edit
                                </button>

                                <!-- Delete Button -->
                                <button type="button" class="btn btn-danger btn-sm btn-rounded btn-fw" data-bs-toggle="modal" data-bs-target="#deleteSkillModal{{ $skill->skill_id }}">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </td>
                        </tr>

                        <!-- Modal Show Skill -->
                        <div class="modal fade" id="showSkillModal{{ $skill->skill_id }}" tabindex="-1" aria-labelledby="showSkillLabel{{ $skill->skill_id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="showSkillLabel{{ $skill->skill_id }}">Skill Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>ID:</strong> {{ $skill->skill_id }}</p>
                                        <p><strong>Name:</strong> {{ $skill->skill_name }}</p>
                                        <p><strong>Category:</strong> {{ $skill->category->category_name ?? '-' }}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Edit Skill -->
                        <div class="modal fade" id="editSkillModal{{ $skill->skill_id }}" tabindex="-1" aria-labelledby="editSkillLabel{{ $skill->skill_id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="{{ route('skills.update', $skill->skill_id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editSkillLabel{{ $skill->skill_id }}">Edit Skill</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="skill_name_{{ $skill->skill_id }}" class="form-label">Skill Name</label>
                                                <input type="text" class="form-control" id="skill_name_{{ $skill->skill_id }}" name="skill_name" value="{{ $skill->skill_name }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="category_id_{{ $skill->skill_id }}" class="form-label">Category</label>
                                                <select class="form-select" id="category_id_{{ $skill->skill_id }}" name="category_id" required>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->category_id }}" {{ $skill->category_id == $category->category_id ? 'selected' : '' }}>
                                                            {{ $category->category_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
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

                        <!-- Modal Delete Skill -->
                        <div class="modal fade" id="deleteSkillModal{{ $skill->skill_id }}" tabindex="-1" aria-labelledby="deleteSkillLabel{{ $skill->skill_id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="{{ route('skills.destroy', $skill->skill_id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteSkillLabel{{ $skill->skill_id }}">Confirm Delete</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete the skill "<strong>{{ $skill->skill_name }}</strong>"?
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
        <div class="mt-3">
            {{ $skills->links() }}
        </div>
    </div>
</div>

@endsection
