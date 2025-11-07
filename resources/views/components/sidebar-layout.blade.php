<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body x-data class="font-sans antialiased bg-gray-100">

<div class="flex min-h-screen">
    {{-- Sidebar yang Dirapihkan --}}
    <div class="w-64 bg-white shadow-md flex flex-col">
        {{-- Header dengan Logo Sekolah --}}
        <div class="p-4 border-b border-gray-200 flex items-center justify-center">
            <div class="flex items-center space-x-3">
                {{-- Logo Sekolah --}}
                <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                    </svg>
                </div>
                {{-- Nama Sekolah --}}
                <div class="text-center">
                    <div class="font-bold text-gray-800 text-sm leading-tight">SMK TIP Cimahi</div>
                </div>
            </div>
        </div>

        {{-- Menu Navigasi --}}
        <nav class="flex-1 py-4">
            <ul class="space-y-1 px-3">
                @if(Auth::user()->role === 'super_admin')
                    <li>
                        <a href="{{ route('superadmin.dashboard') }}" 
                           class="flex items-center px-3 py-2.5 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-200 {{ request()->is('superadmin.dashboard') ? 'bg-gray-200 font-medium' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('superadmin.eskul.index') }}"
                           class="flex items-center px-3 py-2.5 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-200 {{ request()->is('superadmin/eskul*') ? 'bg-gray-200 font-medium' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Manajemen Eskul
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('superadmin.rekap.index') }}"
                           class="flex items-center px-3 py-2.5 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-200 {{ request()->is('superadmin/rekap*') ? 'bg-gray-200 font-medium' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Cetak Rekap
                        </a>
                    </li>
                @endif
                
                @if(Auth::user()->role === 'admin')
                    <li>
                        <a href="{{ route('admin.dashboard') }}" 
                           class="flex items-center px-3 py-2.5 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-200 {{ request()->is('admin/dashboard') ? 'bg-gray-200 font-medium' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.petugas.index') }}" 
                           class="flex items-center px-3 py-2.5 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-200 {{ request()->is('admin/petugas*') ? 'bg-gray-200 font-medium' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                            </svg>
                            Manajemen Petugas
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.anggota.index') }}"
                           class="flex items-center px-3 py-2.5 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-200 {{ request()->is('admin/anggota*') ? 'bg-gray-200 font-medium' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Manajemen Anggota
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.jadwal.index') }}"
                           class="flex items-center px-3 py-2.5 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-200 {{ request()->is('admin/jadwal*') ? 'bg-gray-200 font-medium' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Manajemen Jadwal
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.rekap.index') }}"
                           class="flex items-center px-3 py-2.5 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-200 {{ request()->is('admin/rekap*') ? 'bg-gray-200 font-medium' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Rekap Absen
                        </a>
                    </li>
                @endif

                @if (Auth::user()->role === 'petugas')
                    <li>
                        <a href="{{ route('petugas.dashboard') }}" 
                           class="flex items-center px-3 py-2.5 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-200 {{ request()->is('petugas/dashboard') ? 'bg-gray-200 font-medium' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('petugas.absensi.index') }}"
                           class="flex items-center px-3 py-2.5 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-200 {{ request()->is('petugas/absen*') ? 'bg-gray-200 font-medium' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Manajemen Absen
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>

    {{-- Konten Utama --}}
    <div class="flex-1 flex flex-col">
        {{-- Header --}}
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-4 px-6 flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    @yield('title', 'Dashboard')
                </h2>
                <div>
                    @include('layouts.navigation') {{-- dropdown user --}}
                </div>
            </div>
        </header>

        {{-- Isi Halaman --}}
        <main class="p-6">
            {{ $slot }}
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>