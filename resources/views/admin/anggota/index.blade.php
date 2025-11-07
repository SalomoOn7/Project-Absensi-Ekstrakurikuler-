<x-sidebar-layout>
    <x-slot name="title">Manajemen Anggota Eskul</x-slot>

    <div class="p-6" 
        x-data="{
            id: '',
            eskul_id: '',
            nama: '',
            kelas: '',
            nis: '',
            jenis_kelamin: '',
            no_hp: ''
        }"
        x-on:set-edit-data.window="
            if ($event.detail) {
                id = $event.detail.id;
                eskul_id = $event.detail.eskul_id;
                nama = $event.detail.nama;
                kelas = $event.detail.kelas;
                nis = $event.detail.nis;
                jenis_kelamin = $event.detail.jenis_kelamin;
                no_hp = $event.detail.no_hp;
            }
        "
    >
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Anggota Ekstrakurikuler</h1>
            <x-primary-button x-on:click="$dispatch('open-modal', 'tambah-anggota')">
                Tambah Anggota
            </x-primary-button>
        </div>

        <!-- Notifikasi -->
        @if (session('success'))
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

        <!-- Tabel Anggota -->
        <div class="overflow-x-auto bg-white rounded-xl shadow-md border border-gray-200">
            <table class="min-w-full text-sm text-gray-700">
                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr class="text-left">
                        <th class="px-6 py-3 font-semibold">#</th>
                        <th class="px-6 py-3 font-semibold">Nama</th>
                        <th class="px-6 py-3 font-semibold">Kelas</th>
                        <th class="px-6 py-3 font-semibold">NIS</th>
                        <th class="px-6 py-3 font-semibold">Jenis Kelamin</th>
                        <th class="px-6 py-3 font-semibold">No HP</th>
                        <th class="px-6 py-3 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($anggotas as $index => $a)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-6 py-3">{{ $index + 1 }}</td>
                            <td class="px-6 py-3">{{ $a->nama }}</td>
                            <td class="px-6 py-3">{{ $a->kelas }}</td>
                            <td class="px-6 py-3">{{ $a->nis }}</td>
                            <td class="px-6 py-3">
                                {{ $a->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </td>
                            <td class="px-6 py-3">{{ $a->no_hp ?? '-' }}</td>
                            <td class="px-6 py-3 text-center flex justify-center gap-2">
                                <x-secondary-button
                                    type="button"
                                    x-on:click="
                                        $dispatch('open-modal', 'edit-anggota');
                                        $dispatch('set-edit-data', {
                                            id: '{{ $a->anggota_id }}',
                                            eskul_id: '{{ $a->eskul_id }}',
                                            nama: '{{ $a->nama }}',
                                            kelas: '{{ $a->kelas }}',
                                            nis: '{{ $a->nis }}',
                                            jenis_kelamin: '{{ $a->jenis_kelamin }}',
                                            no_hp: '{{ $a->no_hp }}'
                                        });
                                    ">
                                    Edit
                                </x-secondary-button>

                                <x-danger-button 
                                    type="button" 
                                    class="px-3 py-1.5 text-xs font-medium text-white bg-red-500 rounded-md hover:bg-red-600 transition"
                                    x-on:click="
                                        $dispatch('open-modal', 'hapus-anggota');
                                        $dispatch('set-delete-id', '{{ $a->anggota_id }}');
                                    ">
                                    Hapus
                                </x-danger-button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500 italic">
                                Belum ada anggota.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Modal Tambah Anggota -->
        <x-modal name="tambah-anggota" focusable>
            <form action="{{ route('admin.anggota.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <h2 class="text-xl font-semibold text-gray-900">Tambah Anggota</h2>

                <input type="hidden" name="eskul_id" value="{{ Auth::user()->eskul_id }}">

                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" name="nama" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Kelas</label>
                    <input type="text" name="kelas" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">NIS</label>
                    <input type="text" name="nis" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">No HP</label>
                    <input type="text" name="no_hp" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div class="flex justify-end gap-2 mt-4">
                    <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                    <x-primary-button type="submit">Simpan</x-primary-button>
                </div>
            </form>
        </x-modal>

        <!-- Modal Edit Anggota -->
        <x-modal name="edit-anggota" focusable>
            <form x-bind:action="'/admin/anggota/' + id" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                <h2 class="text-xl font-semibold text-gray-900">Edit Anggota</h2>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" name="nama" x-model="nama" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Kelas</label>
                    <input type="text" name="kelas" x-model="kelas" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">NIS</label>
                    <input type="text" name="nis" x-model="nis" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                    <select name="jenis_kelamin" x-model="jenis_kelamin" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">No HP</label>
                    <input type="text" name="no_hp" x-model="no_hp" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div class="flex justify-end gap-2 mt-4">
                    <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                    <x-primary-button type="submit">Simpan Perubahan</x-primary-button>
                </div>
            </form>
        </x-modal>

        <!-- Modal Hapus Anggota -->
        <x-modal name="hapus-anggota" focusable>
            <div class="p-6 text-center" x-data="{ id: '' }" x-on:set-delete-id.window="id = $event.detail">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">
                    Apakah kamu yakin ingin menghapus anggota ini?
                </h2>

                <form x-bind:action="'/admin/anggota/' + id" method="POST" class="inline-flex gap-2 justify-center">
                    @csrf
                    @method('DELETE')
                    <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                    <x-danger-button type="submit">Ya, Hapus</x-danger-button>
                </form>
            </div>
        </x-modal>
    </div>
</x-sidebar-layout>
