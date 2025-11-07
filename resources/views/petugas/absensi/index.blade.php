<x-sidebar-layout>
  <x-slot name="title">Absensi Anggota</x-slot>

  <div class="container mx-auto p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
      <div>
        <h1 class="text-2xl font-bold text-gray-800">Pilih Jadwal Latihan</h1>
        <p class="text-gray-500 text-sm mt-1">Silakan pilih jadwal latihan untuk melakukan absensi anggota eskul.</p>
      </div>
    </div>

    <!-- Notifikasi -->

    @if(session('warning'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        icon: 'warning',
        title: 'Sudah Diisi!',
        text: '{{ session('warning') }}',
        confirmButtonText: 'OK',
        confirmButtonColor: '#1f2937'
    });
});
</script>
@endif


    @if(session('success'))
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
        });
    });
</script>
    @endif

    <!-- Tabel Jadwal -->
    <div class="overflow-x-auto bg-white shadow-md rounded-xl border border-gray-200">
      <table class="min-w-full border-collapse text-sm">
        <thead class="bg-gray-100 border-b border-gray-200">
          <tr class="text-left text-gray-700 font-semibold">
            <th class="px-6 py-3">Hari</th>
            <th class="px-6 py-3">Waktu</th>
            <th class="px-6 py-3 text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($jadwals as $j)
            <tr class="border-b hover:bg-gray-50 transition">
              <td class="px-6 py-3">{{ $j->hari }}</td>
              <td class="px-6 py-3">{{ $j->waktu_mulai }} - {{ $j->waktu_selesai }}</td>
              <td class="px-6 py-3 text-center">
                <x-primary-button
  x-data="{
    cekJadwal(hariJadwal) {
      const hariSekarang = '{{ $hariSekarang }}';

      if (hariSekarang !== hariJadwal) {
        Swal.fire({
          icon: 'warning',
          title: 'Tidak Bisa Absen!',
          text: 'Absensi hanya dapat dilakukan pada hari latihan (' + hariJadwal + ').',
          confirmButtonText: 'OK',
          confirmButtonColor: '#1f2937'
        });
        return;
      }

      // Jika hari cocok, buka modal absensi
      $dispatch('open-modal', 'isi-absensi');
      $dispatch('set-jadwal', {
        id: '{{ $j->jadwal_id }}',
        hari: hariJadwal,
        waktu_mulai: '{{ $j->waktu_mulai }}',
        waktu_selesai: '{{ $j->waktu_selesai }}'
      });
    }
  }"
  x-on:click="cekJadwal('{{ $j->hari }}')"
>
  Isi Absensi
</x-primary-button>

              </td>
            </tr>
          @empty
            <tr>
              <td colspan="3" class="text-center text-gray-500 py-4">Belum ada jadwal latihan.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- Modal Isi Absensi -->
  <x-modal name="isi-absensi" focusable>
    <div class="p-6" 
         x-data="{ id: '', hari: '', waktu_mulai: '', waktu_selesai: '' }" 
         x-on:set-jadwal.window="
            if($event.detail){
              id=$event.detail.id;
              hari=$event.detail.hari;
              waktu_mulai=$event.detail.waktu_mulai;
              waktu_selesai=$event.detail.waktu_selesai;
            }
         ">

      <h2 class="text-lg font-semibold text-gray-900 mb-2">Isi Absensi</h2>
      <p class="text-gray-700 mb-2">Jadwal: <span class="font-semibold" x-text="hari"></span></p>
      <p class="text-gray-700 mb-4">Waktu: <span x-text="waktu_mulai"></span> - <span x-text="waktu_selesai"></span></p>

      <form action="{{ route('petugas.absensi.store') }}" method="POST">
        @csrf
        <input type="hidden" name="jadwal_id" x-model="id">
        <input type="hidden" name="tanggal" value="{{ now()->toDateString() }}">

        <div class="overflow-x-auto mb-4 max-h-[400px] overflow-y-auto">
          <table class="w-full border text-sm">
            <thead class="bg-gray-100">
              <tr>
                <th class="border p-2">#</th>
                <th class="border p-2">Nama</th>
                <th class="border p-2">Status</th>
                <th class="border p-2">Keterangan</th>
              </tr>
            </thead>
            <tbody id="anggotaBody">
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

          <div class="flex justify-center mt-4 space-x-2" id="pagination"></div>
        </div>

        <div class="flex justify-end space-x-2">
          <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
          <x-primary-button type="submit">
            Simpan Absensi
          </x-primary-button>
        </div>
      </form>
    </div>
  </x-modal>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const rows = document.querySelectorAll("#anggotaBody tr");
      const perPage = 5; 
      const totalRows = rows.length;
      const totalPages = Math.ceil(totalRows / perPage);
      const pagination = document.getElementById("pagination");
      let currentPage = 1;

      function showPage(page) {
        currentPage = page;

        rows.forEach(row => row.style.display = "none");

        const start = (page - 1) * perPage;
        const end = start + perPage;
        for (let i = start; i < end && i < totalRows; i++) {
          rows[i].style.display = "";
        }

        renderPagination();
      }

      function renderPagination() {
        pagination.innerHTML = "";
        for (let i = 1; i <= totalPages; i++) {
          const btn = document.createElement("button");
          btn.textContent = i;
          btn.className =
            `px-3 py-1 rounded-md border ${i === currentPage
              ? "bg-[#1f2937] text-white"
              : "bg-white hover:bg-blue-100"
            }`;
          btn.addEventListener("click", () => showPage(i));
          pagination.appendChild(btn);
        }
      }

      showPage(1);
    });
  </script>
</x-sidebar-layout>
