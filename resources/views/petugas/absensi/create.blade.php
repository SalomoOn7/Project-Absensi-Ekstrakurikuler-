<x-sidebar-layout>
  <x-slot name="title">Isi Absensi</x-slot>

  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Isi Absensi Anggota</h1>

    <form action="{{ route('petugas.absensi.store') }}" method="POST">
      @csrf
      <input type="hidden" name="jadwal_id" value="{{ $jadwal_id }}">

      <div class="mb-4">
        <label class="font-semibold block mb-1">Tanggal</label>
        <input type="date" name="tanggal" class="border rounded p-2" required>
      </div>

      <div class="mb-4">
        <p class="text-gray-700 mb-2">Pilih siapa saja yang <strong>TIDAK HADIR</strong>:</p>
        <div class="overflow-x-auto">
          <table class="w-full border text-sm">
            <thead class="bg-gray-100">
              <tr>
                <th class="border p-2">#</th>
                <th class="border p-2">Nama</th>
                <th class="border p-2">Status</th>
                <th class="border p-2">Keterangan</th>
              </tr>
            </thead>
            <tbody>
              @foreach($anggota as $i => $a)
                <tr>
                  <td class="border p-2 text-center">{{ $i+1 }}</td>
                  <td class="border p-2">{{ $a->nama }}</td>
                  <td class="border p-2 text-center">
                    <select name="tidak_hadir[{{ $a->anggota_id }}][status]" class="border rounded p-1">
                      <option value="">Hadir (Default)</option>
                      <option value="Izin">Izin</option>
                      <option value="Sakit">Sakit</option>
                      <option value="Alpha">Alpha</option>
                    </select>
                  </td>
                  <td class="border p-2">
                    <input type="text" name="tidak_hadir[{{ $a->anggota_id }}][keterangan]" 
                           class="w-full border rounded p-1" placeholder="Opsional">
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

      <div class="flex justify-end">
        <x-primary-button type="submit">Simpan Absensi</x-primary-button>
      </div>
    </form>
  </div>
</x-sidebar-layout>
