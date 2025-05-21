@extends('layout.app')

@section('content')

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Supervisor Data</h4>
        <a href="{{ route('supervisors.create') }}" class="btn btn-primary btn-rounded btn-fw mb-2">Add Supervisor</a>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>NIP</th>
                        <th>Department</th>
                        <th>Gender</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($supervisors as $supervisor)
                        <tr>
                            <td>{{ $supervisors->firstItem() + $loop->index }}</td>
                            <td>{{ $supervisor->user_name }}</td>
                            <td>{{ $supervisor->user_username }}</td>
                            <td>{{ $supervisor->detailSupervisor->detail_supervisor_nip ?? '-' }}</td>
                            <td>{{ $supervisor->detailSupervisor->department->department_name ?? '-' }}</td>
                            <td>{{ ucfirst($supervisor->detailSupervisor->detail_supervisor_gender ?? '-') }}</td>
                            <td>{{ $supervisor->detailSupervisor->detail_supervisor_email ?? '-' }}</td>
                            <td>{{ $supervisor->detailSupervisor->detail_supervisor_phone_no ?? '-' }}</td>
                            <td>
                                <a href="{{ route('supervisors.edit', $supervisor->user_id) }}" class="btn btn-warning btn-rounded btn-fw">Edit</a>
                                <form action="{{ route('supervisors.destroy', $supervisor->user_id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-rounded btn-fw" onclick="return confirm('Are you sure want to delete this supervisor?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $supervisors->links() }}
        </div>
    </div>
</div>

@endsection
