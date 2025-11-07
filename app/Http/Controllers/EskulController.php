<?php

namespace App\Http\Controllers;
use App\Models\Eskul;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class EskulController extends Controller
{

    public function index()
    {
        $eskuls = Eskul::with('pembina')->get();
        return view('superadmin.eskul.index', compact('eskuls'));
    }

    public function create()
    {
        return view('superadmin.eskul.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_eskul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'nama_pembina' => 'required|string|max:255',
            'username_pembina' => 'required|string|unique:users,username',
            'password_pembina' => 'required|string|min:6',
        ]);

        //Untuk menyimpan data eskul
        $eskul =  Eskul::create([
            'nama_eskul' => $request->nama_eskul,
            'deskripsi' => $request->deskripsi,
        ]);

        User::create([
            'eskul_id' => $eskul->eskul_id,
            'nama' => $request->nama_pembina,
            'username' => $request->username_pembina,
            'password' => Hash::make($request->password_pembina),
            'role' => 'admin',
        ]);
        return redirect()->route('superadmin.eskul.index')->with('success', 'Data berhasil dibuat');
    }

    public function show(string $id)
    {
        //
    }

    public function edit( $id)
    {
        $eskul = Eskul::with('pembina')->findOrFail($id);
        return view('superadmin.eskul.edit', compact('eskul'));
    }

    public function update(Request $request, $id)
    {
        $eskul = Eskul::with('pembina')->findOrFail($id);

        $request->validate([
            'nama_eskul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'nama_pembina' => 'required|string|max:255',
            'username_pembina' => 'required|string|unique:users,username,' . $eskul->pembina->user_id . ',user_id',
            'password_pembina' => 'nullable|string|min:6',
        ]);

         $eskul->update([
            'nama_eskul' => $request->nama_eskul,
            'deskripsi' => $request->deskripsi,
        ]);

         if ($eskul->pembina) {
        $eskul->pembina->nama = $request->nama_pembina;
        $eskul->pembina->username = $request->username_pembina;

        if ($request->filled('password_pembina')) {
            $eskul->pembina->password = bcrypt($request->password_pembina);
        }

        $eskul->pembina->save();
    } else {
        User::create([
            'eskul_id' => $eskul->eskul_id,
            'nama'     => $request->nama_pembina,
            'username' => $request->username_pembina,
            'password' => bcrypt($request->password_pembina ?: 'password123'),
            'role'     => 'admin',
        ]);
    }

        return redirect()->route('superadmin.eskul.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy( $id)
    {
        $eskul = Eskul::with('pembina')->findOrFail($id);

        // Hapus juga akun pembina jika ada
        if ($eskul->pembina) {
            $eskul->pembina->delete();
        }

    $eskul->delete();
        return redirect()->route('superadmin.eskul.index')->with('success', 'Data berhasil dihapus');
    }
}
