<x-sidebar-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Eskul') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <form action="{{ route('superadmin.eskul.update', $eskul->eskul_id) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="mb-4">
                        <label class="block text-gray-700">Nama Eskul</label>
                        <input type="text" name="nama_eskul" value="{{ $eskul->nama_eskul }}" 
                               class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Deskripsi</label>
                        <textarea name="deskripsi" 
                                  class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">{{ $eskul->deskripsi }}</textarea>
                    </div>

                    <h4 class="text-lg font-semibold mt-6 mb-2">Akun Pembina</h4>

                    <div class="mb-4">
                        <label class="block text-gray-700">Nama Pembina</label>
                        <input type="text" nama="nama_pembina" 
                               value="{{ $eskul->pembina->nama ?? '' }}" 
                               class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Username Pembina</label>
                        <input type="text" name="username_pembina" 
                               value="{{ $eskul->pembina->username ?? '' }}" 
                               class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Password Baru (kosongkan jika tidak diubah)</label>
                        <input type="password" name="password_pembina" 
                               class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
                    </div>

                    <div class="mt-6">
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Update
                        </button>
                        <a href="{{ route('superadmin.eskul.index') }}" 
                           class="ml-2 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-sidebar-layout>
