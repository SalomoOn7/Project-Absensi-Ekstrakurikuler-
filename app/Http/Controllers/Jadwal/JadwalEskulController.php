<?php

namespace App\Http\Controllers\Jadwal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JadwalEskul;

class JadwalEskulController extends Controller
{
    /**
     * Menampilkan semua jadwal untuk eskul admin yang login
     */
    public function index()
    {
        $eskulId = Auth::user()->eskul_id;
        $jadwals = JadwalEskul::where('eskul_id', $eskulId)->get();

        return view('admin.jadwal.index', compact('jadwals'));
    }

    /**
     * Menyimpan jadwal baru (dengan pengecekan bentrok)
     */
    public function store(Request $request)
    {
        $request->validate([
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
        ]);

        $hari = $request->hari;
        $mulai = $request->waktu_mulai;
        $selesai = $request->waktu_selesai;

        // 🔍 Cek apakah jadwal bentrok dengan eskul lain
        $adaBentrok = JadwalEskul::where('hari', $hari)
            ->where(function ($q) use ($mulai, $selesai) {
                $q->where('waktu_mulai', '<', $selesai)
                  ->where('waktu_selesai', '>', $mulai);
            })
            ->with('eskul')
            ->first();

        if ($adaBentrok) {
            $namaEskul = $adaBentrok->eskul->nama_eskul;
            return redirect()->back()->with('error', "Jadwal bentrok dengan eskul $namaEskul ! , Coba Hubungi Pembina Eskul $namaEskul");
        }

        JadwalEskul::create([
            'eskul_id' => Auth::user()->eskul_id,
            'hari' => $hari,
            'waktu_mulai' => $mulai,
            'waktu_selesai' => $selesai,
        ]);

        return redirect()->back()->with('success', 'Jadwal berhasil ditambahkan!');
    }

    /**
     * Mengupdate jadwal (dengan pengecekan bentrok juga)
     */
    public function update(Request $request, $id)
    {
        $jadwal = JadwalEskul::findOrFail($id);

        $request->validate([
        'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
        'waktu_mulai' => 'required',
        'waktu_selesai' => 'required|after:waktu_mulai',
    ]);


        $hari = $request->hari;
        $mulai = $request->waktu_mulai;
        $selesai = $request->waktu_selesai;

        // 🔍 Cek bentrok, tapi abaikan jadwal yang sedang diedit
        $adaBentrok = JadwalEskul::where('hari', $hari)
            ->where('jadwal_id', '!=', $id)
            ->where(function ($q) use ($mulai, $selesai) {
                $q->where('waktu_mulai', '<', $selesai)
                  ->where('waktu_selesai', '>', $mulai);
            })
            ->exists();

        if ($adaBentrok) {
            return redirect()->back()->with('error', 'Jadwal bentrok dengan eskul lain!');
        }

        // Update data
        $jadwal->update([
            'hari' => $hari,
            'waktu_mulai' => $mulai,
            'waktu_selesai' => $selesai,
        ]);

        return redirect()->back()->with('success', 'Jadwal berhasil diperbarui!');
    }

    /**
     * Menghapus jadwal
     */
    public function destroy($id)
    {
        $jadwal = JadwalEskul::findOrFail($id);

        $jadwal->delete();

        return redirect()->back()->with('success', 'Jadwal berhasil dihapus!');
    }
}
