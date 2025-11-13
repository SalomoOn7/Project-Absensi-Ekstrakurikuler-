{{-- Notifikasi error --}}
@if(session('error'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: '{{ session('error') }}',
        confirmButtonText: 'OK',
    });
});
</script>
@endif

    {{-- Notifikasi sukses --}}
    @if(session('success'))
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 500,
            timerProgressBar: true,
        });
    });
  </script>
    @endif

<x-sidebar-layout>
  <x-slot name="title">Daftar Jadwal</x-slot>

  <div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Jadwal Latihan Ekstrakurikuler</h1>

    {{-- Tombol Tambah Jadwal --}}
    <div class="mb-4 flex justify-end">
      <x-primary-button x-on:click="$dispatch('open-modal', 'tambah-jadwal')">
        <i class="fa-solid fa-plus mr-2"></i> Tambah Jadwal
      </x-primary-button>
    </div>

    {{-- Tabel Jadwal --}}
<div class="overflow-x-auto bg-white shadow-md rounded-xl border border-gray-200">
  <table class="min-w-full text-sm text-gray-700">
    <thead class="bg-gray-100 text-gray-800 uppercase text-xs font-semibold border border-gray-200">
      <tr>
        <th class="py-3 px-4 text-left">#</th>
        <th class="py-3 px-4 text-left">Hari</th>
        <th class="py-3 px-4 text-left">Waktu Mulai</th>
        <th class="py-3 px-4 text-left">Waktu Selesai</th>
        <th class="py-3 px-4 text-center">Aksi</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
      @forelse ($jadwals as $i => $j)
        <tr class="hover:bg-gray-50 transition">
          <td class="py-3 px-4">{{ $i + 1 }}</td>
          <td class="py-3 px-4">{{ $j->hari }}</td>
          <td class="py-3 px-4">{{ $j->waktu_mulai }}</td>
          <td class="py-3 px-4">{{ $j->waktu_selesai }}</td>
          <td class="py-3 px-4 text-center">
            <div class="flex justify-center gap-3">
              <x-secondary-button 
                x-on:click="$dispatch('open-modal', 'edit-jadwal'); 
                            $dispatch('set-edit-data', {
                              id: '{{ $j->jadwal_id }}',
                              hari: '{{ $j->hari }}',
                              waktu_mulai: '{{ $j->waktu_mulai }}',
                              waktu_selesai: '{{ $j->waktu_selesai }}'
                            })">
                <i class="fa-solid fa-pen mr-1"></i> Edit
              </x-secondary-button>

              <x-danger-button 
                x-on:click="
                  $dispatch('open-modal', 'hapus-jadwal');
                  $dispatch('set-delete-id', '{{ $j->jadwal_id }}')
                ">
                <i class="fa-solid fa-trash mr-1"></i> Hapus
              </x-danger-button>
            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="5" class="py-4 text-center text-gray-500">Belum ada jadwal latihan.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>


    {{-- Modal Tambah Jadwal --}}
    <x-modal name="tambah-jadwal" focusable>
      <div class="p-6 bg-white rounded-lg shadow-lg">
        <h2 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">
          Tambah Jadwal Latihan
        </h2>

        <form action="{{ route('admin.jadwal.store') }}" method="POST" class="space-y-5">
          @csrf
          <div>
            <label class="block text-gray-700 font-medium mb-1">Hari</label>
            <select name="hari" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
              <option value="">-- Pilih Hari --</option>
              @foreach (['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $hari)
                <option value="{{ $hari }}">{{ $hari }}</option>
              @endforeach
            </select>
          </div>

          <div>
            <label class="block text-gray-700 font-medium mb-1">Waktu Mulai</label>
            <input type="time" name="waktu_mulai" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
          </div>

          <div>
            <label class="block text-gray-700 font-medium mb-1">Waktu Selesai</label>
            <input type="time" name="waktu_selesai" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
          </div>

          <div class="flex justify-end space-x-3 pt-4 border-t">
            <x-secondary-button x-on:click="$dispatch('close')">
              Batal
            </x-secondary-button>
            <x-primary-button type="submit">
              Simpan
            </x-primary-button>
          </div>
        </form>
      </div>
    </x-modal>

    {{-- Modal Edit Jadwal --}}

    <x-modal name="edit-jadwal" focusable>
  <div class="p-6 bg-white rounded-lg shadow-lg"
       x-data="{ id: '', hari: '', waktu_mulai: '', waktu_selesai: '' }"
       x-on:set-edit-data.window="
         id = $event.detail.id;
         hari = $event.detail.hari;
         waktu_mulai = $event.detail.waktu_mulai;
         waktu_selesai = $event.detail.waktu_selesai;
       ">
    
    <h2 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">
      Edit Jadwal Latihan
    </h2>

    {{-- Gunakan form dengan route update yang fix --}}
    <form :action="`{{ route('admin.jadwal.update', '') }}/${id}`" method="POST" class="space-y-5">
      @csrf
      @method('PUT')
      
      <div>
        <label class="block text-gray-700 font-medium mb-1">Hari</label>
        <select name="hari" x-model="hari" class="w-full border-gray-300 rounded-md" required>
          <option value="">-- Pilih Hari --</option>
          @foreach (['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $hari)
            <option value="{{ $hari }}">{{ $hari }}</option>
          @endforeach
        </select>
      </div>

      <div>
        <label class="block text-gray-700 font-medium mb-1">Waktu Mulai</label>
        <input type="time" name="waktu_mulai" x-model="waktu_mulai" class="w-full border-gray-300 rounded-md" required>
      </div>

      <div>
        <label class="block text-gray-700 font-medium mb-1">Waktu Selesai</label>
        <input type="time" name="waktu_selesai" x-model="waktu_selesai" class="w-full border-gray-300 rounded-md" required>
      </div>

      <div class="flex justify-end space-x-3 pt-4 border-t">
        <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
        <x-primary-button type="submit">Simpan Perubahan</x-primary-button>
      </div>
    </form>
  </div>
</x-modal>
  </div>
  {{-- Modal Hapus Jadwal --}}
<x-modal name="hapus-jadwal" focusable>
  <div class="p-6 bg-white rounded-xl shadow-xl w-full sm:w-[28rem] mx-auto text-center"
       x-data="{ id: '', nama_eskul: '', deskripsi: '', nama_pembina: '', username_pembina: '' }"
       x-on:set-delete-id.window="id = $event.detail">
       
    <h2 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2 flex items-center justify-center gap-2">
      <i class="fa-solid fa-triangle-exclamation text-red-500 text-xl"></i>
      Konfirmasi Hapus Jadwal
    </h2>

    <p class="text-gray-600 mb-6">
      Apakah kamu yakin ingin menghapus jadwal ini? <br>
    </p>

    <form :action="`{{ route('admin.jadwal.destroy', '') }}/${id}`" method="POST" class="flex justify-center gap-3">
      @csrf
      @method('DELETE')
      <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
      <x-danger-button type="submit">Ya, Hapus</x-danger-button>
    </form>
  </div>
</x-modal>

</x-sidebar-layout>
