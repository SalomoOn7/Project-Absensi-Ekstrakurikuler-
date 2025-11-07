<x-sidebar-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Petugas
        </h2>
    </x-slot>

    <div class="space-y-6">
        {{-- Welcome Card --}}
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 rounded-xl shadow-lg text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold">Selamat datang, {{ Auth::user()->nama }}! </h3>
                    <p class="mt-2 text-blue-100">Ini tampilan dashboard petugas {{ Auth::user()->eskul->nama_eskul }}, disini anda dapat mengisi absen anggota eskul.</p>
                </div>
            </div>
        </div>
    </div>
</x-sidebar-layout>