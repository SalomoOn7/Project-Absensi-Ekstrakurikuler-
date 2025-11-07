<x-sidebar-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-4">Manajemen Eskul</h2>

                    {{-- Tombol Tambah --}}
                    <div class="mb-4 flex justify-end">
                        <x-primary-button x-on:click="$dispatch('open-modal', 'tambah-eskul')">
                            <i class="fa-solid fa-plus mr-2"></i> Tambah Eskul
                        </x-primary-button>
                    </div>

                    {{-- Alert Success --}}
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

                    {{-- Tabel Data --}}
                    <div class="overflow-x-auto bg-white rounded-xl shadow-md border border-gray-200">
                        <table class="min-w-full text-sm text-gray-700">
                            <thead class="bg-gray-100 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-3 font-semibold">Nama Eskul</th>
                                    <th class="px-6 py-3 font-semibold">Deskripsi</th>
                                    <th class="px-6 py-3 font-semibold">Pembina</th>
                                    <th class="px-6 py-3 font-semibold">Username</th>
                                    <th class="px-6 py-3 text-center font-semibold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($eskuls as $eskul)
                                    <tr class="border-b hover:bg-gray-50 transition">
                                        <td class="px-4 py-2 border">{{ $eskul->nama_eskul }}</td>
                                        <td class="px-4 py-2 border">{{ $eskul->deskripsi }}</td>
                                        <td class="px-4 py-2 border">{{ $eskul->pembina->nama ?? '-' }}</td>
                                        <td class="px-4 py-2 border">{{ $eskul->pembina->username ?? '-' }}</td>
                                        <td class="px-4 py-2 border text-center">
                                            <x-secondary-button
                                                type="button"
                                                x-on:click=" 
                                                    $dispatch('open-modal', 'edit-eskul'); 
                                                    $dispatch('set-edit-data', {
                                                        id: '{{ $eskul->eskul_id }}',
                                                        nama_eskul: `{{ addslashes($eskul->nama_eskul) }}`,
                                                        deskripsi: `{{ addslashes($eskul->deskripsi ?? '') }}`,
                                                        nama_pembina: `{{ addslashes($eskul->pembina->nama ?? '') }}`,
                                                        username_pembina: `{{ addslashes($eskul->pembina->username ?? '') }}`
                                                    });
                                                ">
                                                Edit
                                            </x-secondary-button>
                                            <x-danger-button 
                                        type="button" 
                                        class="px-3 py-1.5 text-xs font-medium text-white bg-red-500 rounded-md hover:bg-red-600 transition"
                                        x-on:click="
                                        $dispatch('open-modal', 'hapus-eskul');
                                        $dispatch('set-delete-id', '{{ $eskul->eskul_id }}');
                                    ">
                                    Hapus
                                </x-danger-button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-gray-500">
                                            Belum ada data eskul.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Tambah -->
    <x-modal name="tambah-eskul" focusable>
        <div class="p-6 bg-white rounded-lg shadow-lg">
            <h2 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">
                Tambah Eskul
            </h2>

            <form action="{{ route('superadmin.eskul.store') }}" method="POST" class="space-y-5" autocomplete="off">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Eskul</label>
                    <input type="text" name="nama_eskul" autocomplete="off"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea name="deskripsi" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring"></textarea>
                </div>

                <h4 class="text-lg font-semibold mt-6">Akun Pembina</h4>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Pembina</label>
                    <input type="text" name="nama_pembina" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Username Pembina</label>
                    <input type="text" name="username_pembina" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Password Pembina</label>
                    <input type="password" name="password_pembina" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring" required>
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                    <x-primary-button type="submit">Simpan</x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>
    <!-- Modal Edit -->
    <x-modal name="edit-eskul" focusable>
        <div x-data="{
                id: '',
                nama_eskul: '',
                deskripsi: '',
                nama_pembina: '',
                username_pembina: ''
            }"
            x-on:set-edit-data.window="(() => {
            const d = $event.detail || {};
            id = d.id || '';
            nama_eskul = d.nama_eskul || '';
            deskripsi = d.deskripsi || '';
            nama_pembina = d.nama_pembina || '';
            username_pembina = d.username_pembina || '';
        })()
    ">
            <form x-bind:action="`/superadmin/eskul/${id}`" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')

                <h2 class="text-xl font-semibold text-gray-900">Edit Eskul</h2>

                <div>
                    <label class="block text-gray-700">Nama Eskul</label>
                    <input type="text" name="nama_eskul" x-model="nama_eskul"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring" required>
                </div>

                <div>
                    <label class="block text-gray-700">Deskripsi</label>
                    <textarea name="deskripsi" x-model="deskripsi"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring"></textarea>
                </div>

                <h4 class="text-lg font-semibold mt-6 mb-2">Akun Pembina</h4>

                <div>
                    <label class="block text-gray-700">Nama Pembina</label>
                    <input type="text" name="nama_pembina" x-model="nama_pembina"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring" required>
                </div>

                <div>
                    <label class="block text-gray-700">Username Pembina</label>
                    <input type="text" name="username_pembina" x-model="username_pembina"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring" required>
                </div>

                <div>
                    <label class="block text-gray-700">Password Baru (kosongkan jika tidak diubah)</label>
                    <input type="password" name="password_pembina"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring">
                </div>

                <div class="flex justify-end gap-2 mt-4">
                    <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                    <x-primary-button type="submit">Simpan Perubahan</x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>

     <!-- Modal Hapus Anggota -->
        <x-modal name="hapus-eskul" focusable>
            <div class="p-6 text-center" x-data="{ id: '' }" x-on:set-delete-id.window="id = $event.detail">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">
                    Apakah kamu yakin ingin menghapus Eskul dan Pembina ini?
                </h2>

                <form x-bind:action="'/superadmin/eskul/' + id" method="POST" class="inline-flex gap-2 justify-center">
                    @csrf
                    @method('DELETE')
                    <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                    <x-danger-button type="submit">Ya, Hapus</x-danger-button>
                </form>
            </div>
        </x-modal>
</x-sidebar-layout>
