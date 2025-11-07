<x-sidebar-layout>
    @section('title', 'Dashboard Super Admin')

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <h1 class="text-2xl font-bold mb-4">Dashboard Super Admin</h1>
                    <p class="text-gray-700 mb-6">Selamat datang, <span class="font-semibold">{{ Auth::user()->name }}</span></p>

                    <div class="space-x-4">
                        <a href="{{ route('superadmin.eskul.index') }}"
                           class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
                            Manajemen Eskul
                        </a>

                        {{-- nanti bisa tambah menu lain di sini --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-sidebar-layout>
