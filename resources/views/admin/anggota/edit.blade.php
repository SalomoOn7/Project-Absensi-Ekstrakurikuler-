<x-sidebar-layout>
  <x-slot name="title"> Edit Anggota </x-slot>

<div class="container mx-auto p-6 max-w-lg">
    <h1 class="text-2xl font-bold mb-4">Edit Data Anggota</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.anggota.update', $anggota->anggota_id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-semibold">Nama</label>
            <input type="text" name="nama" value="{{ old('nama', $anggota->nama) }}" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label class="block font-semibold">Kelas</label>
            <input type="text" name="kelas" value="{{ old('kelas', $anggota->kelas) }}" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label class="block font-semibold">NIS</label>
            <input type="text" name="nis" value="{{ old('nis', $anggota->nis) }}" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label class="block font-semibold">Jenis Kelamin</label>
            <select name="jenis_kelamin" class="w-full border p-2 rounded" required>
                <option value="L" {{ $anggota->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ $anggota->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        <div>
            <label class="block font-semibold">No HP (opsional)</label>
            <input type="text" name="no_hp" value="{{ old('no_hp', $anggota->no_hp) }}" class="w-full border p-2 rounded">
        </div>

        <div class="flex justify-between">
            <a href="{{ route('admin.anggota.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Kembali</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Perbarui</button>
        </div>
    </form>
</div>
</x-sidebar-layout>