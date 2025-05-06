@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Detail Pengguna: {{ $user->name }}</h1>
        <table class="table">
            <tr>
                <th>Nama</th>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <th>Role</th>
                <td>{{ ucfirst($user->role) }}</td>
            </tr>
            @if($user->role == 'mahasiswa')
                <tr>
                    <th>NIM</th>
                    <td>{{ $user->mahasiswaDetail->nim }}</td>
                </tr>
                <tr>
                    <th>Program Studi</th>
                    <td>{{ $user->mahasiswaDetail->program_studi }}</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td>{{ $user->mahasiswaDetail->alamat }}</td>
                </tr>
            @elseif($user->role == 'dosen')
                <tr>
                    <th>NIP</th>
                    <td>{{ $user->dosenDetail->nip }}</td>
                </tr>
                <tr>
                    <th>Jabatan</th>
                    <td>{{ $user->dosenDetail->jabatan }}</td>
                </tr>
            @endif
        </table>

        <a href="{{ route('admin.users') }}" class="btn btn-secondary">Kambali</a>
        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">Edit Pengguna</a>

        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Hapus Pengguna</button>
        </form>
    </div>
@endsection
