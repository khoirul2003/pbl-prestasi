<div class="col-md-2">
    <div class="list-group">
        @auth
            <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action bg-primary text-white">Dashboard</a>
            @if(auth()->user()->role == 'mahasiswa')
                <a href="{{ route('dashboard.mahasiswa') }}" class="list-group-item list-group-item-action">Dashboard Mahasiswa</a>
            @elseif(auth()->user()->role == 'dosen')
                <a href="{{ route('dashboard.dosen') }}" class="list-group-item list-group-item-action">Dashboard Dosen</a>
            @elseif(auth()->user()->role == 'admin')
                <a href="{{ route('dashboard.admin') }}" class="list-group-item list-group-item-action">Dashboard Admin</a>
                <a href="{{ route('admin.users') }}" class="list-group-item list-group-item-action">Data User</a>
                <a href="{{ route('admin.competitions') }}" class="list-group-item list-group-item-action">Data Lomba</a>
                <a href="{{ route('admin.reports') }}" class="list-group-item list-group-item-action">Data Laporan</a>
            @endif
        @endauth
    </div>
</div>
