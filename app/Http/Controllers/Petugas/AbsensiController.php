<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\JadwalEskul;
use App\Models\Anggota;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class AbsensiController extends Controller
{

    public function index()
{
    $eskulId = Auth::user()->eskul_id;

    $jadwals = JadwalEskul::where('eskul_id', $eskulId)->get();
    $anggota = Anggota::where('eskul_id', $eskulId)->get();

    // Ambil nama hari sekarang (misal: "Senin")
    $hariSekarang = now()->locale('id')->translatedFormat('l');

    return view('petugas.absensi.index', compact('jadwals', 'anggota', 'hariSekarang'));
}


    /**
     * Menampilkan form absensi untuk jadwal tertentu
     */
    public function create($jadwal_id)
    {
        $eskulId = Auth::user()->eskul_id;

        // Cek jadwal apakah milik eskul petugas
        $jadwal = JadwalEskul::where('eskul_id', $eskulId)
            ->where('jadwal_id', $jadwal_id)
            ->firstOrFail();

        // Ambil semua anggota eskul
        $anggota = Anggota::where('eskul_id', $eskulId)->get();

        return view('petugas.absensi.create', compact('anggota', 'jadwal_id'));
    }

    /**
     * Menyimpan hasil absensi
     */
    public function store(Request $request)
    {
        $request->validate([
        'jadwal_id' => 'required|exists:jadwal_eskul,jadwal_id',
        'tanggal' => 'required|date',
        'tidak_hadir' => 'array',
    ]);

    $eskulId = Auth::user()->eskul_id;
    $user_id = Auth::id();

    // untuk mengecek apakah absensi hari ini untuk jadwal ini sudah pernah diisi
    $sudahAda = Absensi::where('jadwal_id', $request->jadwal_id)
        ->where('eskul_id', $eskulId)
        ->whereDate('tanggal', $request->tanggal)
        ->exists();

    if ($sudahAda) {
        return redirect()->route('petugas.absensi.index')
        ->with('warning', 'Absensi untuk jadwal ini hari ini sudah diisi.');
    }

    // Ambil semua anggota eskul
    $anggotaList = Anggota::where('eskul_id', $eskulId)->get();

    foreach ($anggotaList as $a) {
    $anggotaId = $a->anggota_id;
    $status = 'Hadir';
    $keterangan = null;

    if (!empty($request->tidak_hadir[$anggotaId]['status'])) {
        $status = $request->tidak_hadir[$anggotaId]['status'];
        $keterangan = $request->tidak_hadir[$anggotaId]['keterangan'] ?? null;
    }

    Absensi::updateOrCreate(
        [
            'jadwal_id' => $request->jadwal_id,
            'anggota_id' => $anggotaId,
            'tanggal' => $request->tanggal,
        ],
        [
            'user_id' => Auth::user()->user_id,
            'eskul_id' => $eskulId,
            'status' => $status,
            'keterangan' => $keterangan,
        ]
    );
}
    return redirect()->route('petugas.absensi.index')->with('success', 'Absensi berhasil disimpan!');
    }

}
