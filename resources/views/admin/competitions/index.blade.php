@extends('layout.app')

@section('content')

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Competition Data</h4>
        <a href="{{ route('competitions.create') }}" class="btn btn-primary btn-rounded btn-fw mb-2">Add Competition</a>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Organizer</th>
                        <th>Level</th>
                        <th>Registration Deadline</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($competitions as $competition)
                        <tr>
                            <td>{{ $competition->competition_id }}</td>
                            <td>{{ $competition->competition_tittle }}</td>
                            <td>{{ $competition->category->category_name ?? '-' }}</td>
                            <td>{{ $competition->competition_organizer }}</td>
                            <td>{{ ucfirst($competition->competition_level) }}</td>
                            <td>{{ \Carbon\Carbon::parse($competition->competition_registration_deadline)->format('d-m-Y') }}</td>
                            <td>
                                <a href="{{ route('competitions.show', $competition->competition_id) }}" class="btn btn-info btn-rounded btn-fw">Show</a>
                                <a href="{{ route('competitions.edit', $competition->competition_id) }}" class="btn btn-warning btn-rounded btn-fw">Edit</a>
                                <form action="{{ route('competitions.destroy', $competition->competition_id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-rounded btn-fw" onclick="return confirm('Are you sure want to delete this competition?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $competitions->links() }}
        </div>
    </div>
</div>

@endsection
