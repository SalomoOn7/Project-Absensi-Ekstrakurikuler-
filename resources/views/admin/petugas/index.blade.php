<x-sidebar-layout>
  <x-slot name="title">Daftar Petugas</x-slot>

  <div class="container mx-auto p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-bold text-gray-800">Daftar Petugas</h1>
      <x-primary-button x-on:click="$dispatch('open-modal', 'tambah-petugas')">
        Tambah Petugas
      </x-primary-button>
    </div>

    <!-- Notifikasi -->
    @if(session('success'))
      <script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 10000,
            timerProgressBar: true,
        });
    });
</script>
    @endif

    <!-- Tabel Petugas -->
    <div class="overflow-x-auto bg-white shadow-md rounded-xl border border-gray-200">
      <table class="min-w-full border-collapse text-sm">
        <thead class="bg-gray-100 border-b border-gray-200">
          <tr class="text-left text-gray-700 font-semibold">
            <th class="px-6 py-3">Nama</th>
            <th class="px-6 py-3">Username</th>
            <th class="px-6 py-3 text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($petugas as $p)
            <tr class="border-b hover:bg-gray-50 transition">
              <td class="px-6 py-3">{{ $p->nama }}</td>
              <td class="px-6 py-3">{{ $p->username }}</td>
              <td class="px-6 py-3 text-center flex justify-center gap-2">
                <x-secondary-button
                  type="button"
                  x-on:click="
                    $dispatch('open-modal', 'edit-petugas');
                    $dispatch('set-edit-data', {
                      id: '{{ $p->user_id }}',
                      anggota_id: '{{ $p->anggota_id }}',
                      nama: '{{ $p->nama }}',
                      username: '{{ $p->username }}'
                    });
                  "
                >
                  Edit
                </x-secondary-button>

                <x-danger-button
                  type="button"
                  x-on:click="
                    $dispatch('open-modal', 'hapus-petugas');
                    $dispatch('set-delete-id', '{{ $p->user_id }}');
                  "
                >
                  Hapus
                </x-danger-button>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="3" class="text-center text-gray-500 py-4">Belum ada petugas.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- Modal Tambah Petugas -->
  <x-modal name="tambah-petugas" focusable>
    <form action="{{ route('admin.petugas.store') }}" method="POST" class="p-6 space-y-4">
      @csrf
      <h2 class="text-xl font-semibold text-gray-900">Tambah Petugas dari Anggota</h2>

      <div>
        <label for="anggota_id" class="block text-sm font-medium text-gray-700">Pilih Anggota</label>
        <select name="anggota_id" id="anggota_id"
          class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
          required>
          <option value="">-- Pilih Anggota --</option>
          @foreach($anggota as $a)
            <option value="{{ $a->anggota_id }}">{{ $a->nama }}</option>
          @endforeach
        </select>
      </div>

      <div>
        <label for="username" class="block text-sm font-medium text-gray-700">Username Petugas</label>
        <input type="text" name="username" id="username"
          class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
          required>
      </div>

      <div>
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <input type="password" name="password" id="password"
          class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
          required>
      </div>

      <div class="flex justify-end gap-2 mt-4">
        <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
        <x-primary-button type="submit">Simpan</x-primary-button>
      </div>
    </form>
  </x-modal>
<!-- Modal Edit Petugas -->
<x-modal name="edit-petugas" focusable>
  <form
    x-data="{ id: '', anggota_id: '', nama: '', username: '' }"
    x-on:set-edit-data.window="
      if ($event.detail) {
        id = $event.detail.id;
        anggota_id = $event.detail.anggota_id;
        nama = $event.detail.nama;
        username = $event.detail.username;
      }
    "
    x-bind:action="'/admin/petugas/' + id"
    method="POST"
    class="p-6 space-y-4"
  >
    @csrf
    @method('PUT')

    <h2 class="text-xl font-semibold text-gray-900">Edit Petugas</h2>

    <div>
      <label for="anggota_edit" class="block text-sm font-medium text-gray-700">Pilih Anggota Baru</label>
      <select name="anggota_id" id="anggota_edit"
        x-model="anggota_id"
        class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
        <option value="">-- Pilih Anggota --</option>
        @foreach($anggota as $a)
          <option value="{{ $a->anggota_id }}">{{ $a->nama }}</option>
        @endforeach
      </select>
    </div>

    <div>
      <label for="username_edit" class="block text-sm font-medium text-gray-700">Username</label>
      <input type="text" id="username_edit" name="username" x-model="username"
        class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        required>
    </div>

    <div>
      <label for="password_edit" class="block text-sm font-medium text-gray-700">Password (kosongkan jika tidak diubah)</label>
      <input type="password" id="password_edit" name="password"
        class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
    </div>

    <div class="flex justify-end gap-2 mt-4">
      <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
      <x-primary-button type="submit">Simpan Perubahan</x-primary-button>
    </div>
  </form>
</x-modal>

  <!-- Modal Hapus Petugas -->
  <x-modal name="hapus-petugas" focusable>
    <div class="p-6 text-center" x-data="{ id: '' }" x-on:set-delete-id.window="id = $event.detail">
      <h2 class="text-lg font-semibold text-gray-900 mb-4">
        Apakah kamu yakin ingin menghapus petugas ini?
      </h2>

      <form x-bind:action="'/admin/petugas/' + id" method="POST" class="inline-flex gap-2 justify-center">
        @csrf
        @method('DELETE')
        <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
        <x-danger-button type="submit">Ya, Hapus</x-danger-button>
      </form>
    </div>
  </x-modal>

</x-sidebar-layout>
