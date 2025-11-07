<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Anggota;

class AnggotaController extends Controller
{
    public function index()
    {
        $eskulId = Auth::user()->eskul_id;
        $anggotas = Anggota::where('eskul_id', $eskulId)->get();
        return view('admin.anggota.index', compact('anggotas'));
    }

    public function create()
    {
        return view('admin.anggota.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'kelas' => 'required|string|max:50',
            'nis' => 'required|string|max:50|unique:anggotas,nis',
            'jenis_kelamin' => 'required|in:L,P',
            'no_hp' => 'nullable|string|max:20',
        ]);

        Anggota::create([
            'eskul_id' => Auth::user()->eskul_id,
            'nama' => $request->nama,
            'kelas' => $request->kelas,
            'nis' => $request->nis,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_hp' => $request->no_hp,
        ]);

        return redirect()->route('admin.anggota.index')->with('success', 'Anggota berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $anggota = Anggota::findOrFail($id);
        if ($anggota->eskul_id != Auth::user()->eskul_id) {
            abort(403, 'Akses ditolak.');
        }
        return view('admin.anggota.edit', compact('anggota'));
    }

    public function update(Request $request, $id)
    {
        $anggota = Anggota::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:100',
            'kelas' => 'required|string|max:50',
            'nis' => 'required|string|max:50|unique:anggotas,nis,' . $id . ',anggota_id',
            'jenis_kelamin' => 'required|in:L,P',
            'no_hp' => 'nullable|string|max:20',
        ]);

        if ($anggota->eskul_id != Auth::user()->eskul_id) {
            abort(403, 'Akses ditolak.');
        }

        $anggota->update($request->only(['nama', 'kelas', 'nis', 'jenis_kelamin', 'no_hp']));

        return redirect()->route('admin.anggota.index')->with('success', 'Data anggota berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $anggota = Anggota::findOrFail($id);
        if ($anggota->eskul_id != Auth::user()->eskul_id) {
            abort(403, 'Akses ditolak.');
        }
        $anggota->delete();

        return redirect()->route('admin.anggota.index')->with('success', 'Anggota berhasil dihapus!');
    }
}
