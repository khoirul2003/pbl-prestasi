<?php

namespace App\Http\Controllers;

use App\Models\DosenDetail;
use App\Models\Lomba;
use App\Models\MahasiswaDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();  // Ambil semua data pengguna
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }


    // Menampilkan form untuk tambah pengguna
    public function create()
    {
        return view('admin.users.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:mahasiswa,dosen,admin',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        // Tambahkan detail mahasiswa atau dosen sesuai dengan role
        if ($validated['role'] == 'mahasiswa') {
            MahasiswaDetail::create([
                'user_id' => $user->id,
                'nim' => 'NIM123456',
                'program_studi' => 'Teknik Informatika',
                'tanggal_lahir' => '2000-01-01',
                'alamat' => 'Alamat Mahasiswa',
            ]);
        } elseif ($validated['role'] == 'dosen') {
            DosenDetail::create([
                'user_id' => $user->id,
                'nip' => 'NIP123456',
                'program_studi' => 'Teknik Informatika',
                'jabatan' => 'Dosen Senior',
            ]);
        }

        return redirect()->route('admin.users')->with('success', 'Pengguna berhasil ditambahkan');
    }

    // Menampilkan form edit pengguna
    public function edit(User $user)
    {
        $detail = null;

        if ($user->role == 'mahasiswa') {
            $detail = $user->mahasiswaDetail; // Ambil detail mahasiswa (NIM, program studi, dll.)
        } elseif ($user->role == 'dosen') {
            $detail = $user->dosenDetail; // Ambil detail dosen (NIP, jabatan, dll.)
        }

        // Kirimkan data user dan detail ke tampilan
        return view('admin.users.edit', compact('user', 'detail'));
    }

    // Proses edit pengguna
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:mahasiswa,dosen,admin',
        ]);

        // Perbarui data pengguna
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'password' => $validated['password'] ? Hash::make($validated['password']) : $user->password,
        ]);

        // Perbarui data detail mahasiswa jika role adalah mahasiswa
        if ($validated['role'] == 'mahasiswa') {
            $user->mahasiswaDetail->update([
                'nim' => $request->nim,
                'program_studi' => $request->program_studi,
            ]);
        }

        // Perbarui data detail dosen jika role adalah dosen
        elseif ($validated['role'] == 'dosen') {
            $user->dosenDetail->update([
                'nip' => $request->nip,
                'jabatan' => $request->jabatan,
            ]);
        }

        return redirect()->route('admin.users')->with('success', 'Pengguna berhasil diperbarui');
    }

    // Hapus pengguna
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'Pengguna berhasil dihapus');
    }

    public function competitions()
    {
        $lombas = Lomba::all();  // Ambil semua data lomba
        return view('admin.competitions.index', compact('lombas'));
    }

    // Fungsi untuk menampilkan form tambah lomba
    public function createCompetition()
    {
        return view('admin.competitions.create');
    }

    // Fungsi untuk menyimpan lomba baru
    public function storeCompetition(Request $request)
    {
        $validated = $request->validate([
            'nama_lomba' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'penyelenggara' => 'required|string|max:255',
            'tanggal_pendaftaran_mulai' => 'required|date',
            'tanggal_pendaftaran_selesai' => 'required|date|after_or_equal:tanggal_pendaftaran_mulai',
        ]);

        Lomba::create($validated);  // Simpan lomba baru ke database

        return redirect()->route('admin.competitions')->with('success', 'Lomba berhasil ditambahkan');
    }

    // Fungsi untuk menampilkan form edit lomba
    public function editCompetition(Lomba $competition)
    {
        return view('admin.competitions.edit', compact('competition'));
    }

    // Fungsi untuk memperbarui lomba
    public function updateCompetition(Request $request, Lomba $competition)
    {
        $validated = $request->validate([
            'nama_lomba' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'penyelenggara' => 'required|string|max:255',
            'tanggal_pendaftaran_mulai' => 'required|date',
            'tanggal_pendaftaran_selesai' => 'required|date|after_or_equal:tanggal_pendaftaran_mulai',
        ]);

        $competition->update($validated);  // Perbarui lomba di database

        return redirect()->route('admin.competitions')->with('success', 'Lomba berhasil diperbarui');
    }

    // Fungsi untuk menghapus lomba
    public function destroyCompetition(Lomba $competition)
    {
        $competition->delete();  // Hapus lomba dari database
        return redirect()->route('admin.competitions')->with('success', 'Lomba berhasil dihapus');
    }
}
