<x-sidebar-layout>
    <x-slot name="title">Edit Petugas</x-slot>

    <form action="{{ route('admin.petugas.update', $petugas) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" name="nama" id="nama" class="form-control" value="{{ $petugas->nama }}" required>
        </div>

        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" id="username" class="form-control" value="{{ $petugas->username }}" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password (kosongkan jika tidak ingin ganti)</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.petugas.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</x-sidebar-layout>
