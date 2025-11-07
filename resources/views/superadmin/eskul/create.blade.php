<x-sidebar-layout>
    @section('title', 'Tambah Eskul')

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-6">Tambah Eskul</h2>

                    <form action="{{ route('superadmin.eskul.store') }}" method="POST" class="space-y-5">
                        @csrf

                        {{-- Nama Eskul --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Eskul</label>
                            <input type="text" name="nama_eskul" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                          focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                   required>
                        </div>

                        {{-- Deskripsi --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <textarea name="deskripsi" rows="3"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                             focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                        </div>

                        <h4 class="text-lg font-semibold mt-6">Akun Pembina</h4>

                        {{-- Nama Pembina --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Pembina</label>
                            <input type="text" name="nama_pembina" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                          focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                   required>
                        </div>

                        {{-- Username Pembina --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Username Pembina</label>
                            <input type="text" name="username_pembina" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                          focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                   required>
                        </div>

                        {{-- Password Pembina --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Password Pembina</label>
                            <input type="password" name="password_pembina" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                          focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                   required>
                        </div>

                        {{-- Tombol --}}
                        <div class="flex justify-end">
                            <a href="{{ route('superadmin.eskul.index') }}" 
                               class="mr-2 px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded shadow">
                                Batal
                            </a>
                            <button type="submit" 
                                    class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded shadow">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-sidebar-layout>
