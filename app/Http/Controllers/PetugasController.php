<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Anggota;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    // Tampilkan daftar petugas
    public function index()
    {
        $eskulId = Auth::user()->eskul_id;

        $petugas = User::where('role', 'petugas')
            ->where('eskul_id', $eskulId)
            ->get();

        $anggota = Anggota::where('eskul_id', $eskulId)->get();

        return view('admin.petugas.index', compact('petugas', 'anggota'));
    }

    //  Simpan petugas baru (dipilih dari anggota)
    public function store(Request $request)
    {
        $request->validate([
            'anggota_id' => 'required|exists:anggotas,anggota_id',
            'username'   => 'required|string|unique:users,username',
            'password'   => 'required|string|min:6',
        ]);

        $anggota = Anggota::findOrFail($request->anggota_id);

        User::create([
            'nama'       => $anggota->nama,
            'username'   => $request->username,
            'password'   => Hash::make($request->password),
            'role'       => 'petugas',
            'eskul_id'   => $anggota->eskul_id,
            'anggota_id' => $anggota->anggota_id,
        ]);

        return redirect()->route('admin.petugas.index')->with('success', 'Petugas berhasil ditambahkan.');
    }

    //  Update petugas
    public function update(Request $request, User $petugas)
    {
        $request->validate([
            'anggota_id' => 'required|exists:anggotas,anggota_id',
            'username' => 'required|string|unique:users,username,' . $petugas->user_id . ',user_id',
            'password' => 'nullable|string|min:6',
        ]);
        $anggota = Anggota::findOrFail($request->anggota_id);
        $data = [
            'nama'       => $anggota->nama,
            'username'   => $request->username,
            'anggota_id' => $anggota->anggota_id,
            'eskul_id'   => $anggota->eskul_id,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $petugas->update($data);

        return redirect()->route('admin.petugas.index')->with('success', 'Petugas berhasil diperbarui.');
    }

    public function destroy(User $petugas)
    {
        $petugas->delete();
        return redirect()->route('admin.petugas.index')->with('success', 'Petugas berhasil dihapus.');
    }
}
