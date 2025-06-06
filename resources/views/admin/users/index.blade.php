@extends('layout.app')

@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h4 class="card-title mb-4">User Data</h4>

            {{-- Filter Tabs --}}
            <ul class="nav nav-tabs mb-4">
                <li class="nav-item">
                    <a class="nav-link {{ request('role') == 'student' || request('role') == null ? 'active' : '' }}"
                        href="{{ route('admin.users.index', ['role' => 'student']) }}">
                        <i class="bi bi-person"></i> Students
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('role') == 'supervisor' ? 'active' : '' }}"
                        href="{{ route('admin.users.index', ['role' => 'supervisor']) }}">
                        <i class="bi bi-person"></i> Supervisors
                    </a>
                </li>
            </ul>

            {{-- Add User Button --}}
            <button type="button" class="btn btn-primary btn-rounded btn-fw mb-2" data-bs-toggle="modal"
                data-bs-target="#addUserModal">
                <i class="bi bi-plus-circle me-2"></i> Add User
            </button>

            {{-- Modal Add User --}}
            @include('admin.users.modals.add')

            {{-- Table for Students and Supervisors --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Role</th>

                            <!-- Dynamic columns based on role -->
                            @if (request('role') == 'student' || request('role') == null)
                                <th>NIM</th>
                                <th>Study Program</th>
                            @else
                                <th>NIP</th>
                                <th>Department</th>
                            @endif
                            <th>Email</th>

                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $users->firstItem() + $loop->index }}</td>
                                <td>{{ $user->user_name }}</td>
                                <td>{{ $user->user_username }}</td>
                                <td>{{ ucfirst($user->role->role_name) }}</td>

                                <!-- Dynamic columns based on role -->
                                @if ($user->role->role_name == 'Student')
                                    <td>{{ optional($user->detailStudent)->detail_student_nim }}</td>
                                    <td>{{ optional($user->detailStudent->studyProgram)->study_program_name ?? '-' }}</td>
                                    <td>{{ $user->detailStudent->detail_student_email }}</td>
                                @else
                                    <td>{{ optional($user->detailSupervisor)->detail_supervisor_nip }}</td>
                                    <td>{{ optional($user->detailSupervisor->department)->department_name ?? '-' }}</td>
                                    <td>{{ $user->detailSupervisor->detail_supervisor_email }}</td>
                                @endif




                                <td>
                                    <!-- Show User Modal -->
                                    <button type="button" class="btn btn-secondary btn-rounded btn-fw text-white"
                                        data-bs-toggle="modal" data-bs-target="#showUserModal{{ $user->user_id }}">
                                        <i class="bi bi-eye"></i> Show
                                    </button>
                                    <!-- Edit User Modal -->
                                    <button type="button" class="btn btn-warning btn-rounded btn-fw "
                                        data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->user_id }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <!-- Delete User Modal -->
                                    <button type="button" class="btn btn-danger btn-rounded btn-fw" data-bs-toggle="modal"
                                        data-bs-target="#deleteUserModal{{ $user->user_id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>

                            {{-- Modal Show --}}
                            @include('admin.users.modals.show')

                            {{-- Modal Edit --}}
                            @include('admin.users.modals.edit')

                            {{-- Modal Delete --}}
                            <div class="modal fade" id="deleteUserModal{{ $user->user_id }}" tabindex="-1"
                                aria-labelledby="deleteUserModalLabel{{ $user->user_id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteUserModalLabel{{ $user->user_id }}">Delete
                                                User</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete this user?
                                        </div>
                                        <div class="modal-footer">
                                            <form
                                                action="{{ route('admin.users.destroy', ['role' => request('role'), 'id' => $user->user_id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $users->appends(['role' => request('role')])->links() }}
            </div>
        </div>
    </div>

    <script>
        // Toggle fields for students and supervisors based on role
        document.getElementById('role').addEventListener('change', function(e) {
            var role = e.target.value;
            if (role === 'student') {
                document.getElementById('studentFields').style.display = 'block';
                document.getElementById('supervisorFields').style.display = 'none';
            } else if (role === 'supervisor') {
                document.getElementById('studentFields').style.display = 'none';
                document.getElementById('supervisorFields').style.display = 'block';
            }
        });

        // Initialize form fields based on the current role in request
        window.addEventListener('DOMContentLoaded', function() {
            var currentRole = "{{ request('role', 'student') }}"; // Default to 'student' if role is not set
            if (currentRole === 'student') {
                document.getElementById('studentFields').style.display = 'block';
                document.getElementById('supervisorFields').style.display = 'none';
            } else if (currentRole === 'supervisor') {
                document.getElementById('studentFields').style.display = 'none';
                document.getElementById('supervisorFields').style.display = 'block';
            }
        });
    </script>
@endsection
