<x-sidebar-layout>
  <x-slot name="title">Rekap Bulanan</x-slot>

  <div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Rekap Absensi Bulanan</h1>

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

        @if(session('warning'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        icon: 'warning',
        title: 'Sudah Diisi!',
        text: '{{ session('warning') }}',
        confirmButtonText: 'OK',
        confirmButtonColor: '#1f2937'
    });
});
</script>
@endif


    <form method="GET" class="mb-6 flex gap-4">
      <select name="bulan" class="border rounded-md p-2">
        @foreach(range(1, 12) as $b)
          <option value="{{ $b }}" {{ $bulan == $b ? 'selected' : '' }}>
            {{ DateTime::createFromFormat('!m', $b)->format('F') }}
          </option>
        @endforeach
      </select>

      <select name="tahun" class="border rounded-md p-2">
        @for($t = date('Y') - 2; $t <= date('Y'); $t++)
          <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
        @endfor
      </select>

      <x-primary-button type="submit">Tampilkan</x-primary-button>
    </form>

    <div class="bg-white shadow rounded-lg overflow-hidden">
      <table class="min-w-full text-sm border">
        <thead class="bg-gray-100">
          <tr>
            <th class="border p-2 text-left">Nama Anggota</th>
            <th class="border p-2">Hadir</th>
            <th class="border p-2">Izin</th>
            <th class="border p-2">Sakit</th>
            <th class="border p-2">Alpha</th>
          </tr>
        </thead>
        <tbody>
          @foreach($anggotaList as $a)
            @php $r = $rekap[$a->anggota_id] ?? null; @endphp
            <tr>
              <td class="border p-2">{{ $a->nama }}</td>
              <td class="border p-2 text-center">{{ $r->total_hadir ?? 0 }}</td>
              <td class="border p-2 text-center">{{ $r->total_izin ?? 0 }}</td>
              <td class="border p-2 text-center">{{ $r->total_sakit ?? 0 }}</td>
              <td class="border p-2 text-center">{{ $r->total_alpha ?? 0 }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <form action="{{ route('admin.rekap.store') }}" method="POST" class="mt-6 text-right">
      @csrf
      <input type="hidden" name="bulan" value="{{ $bulan }}">
      <input type="hidden" name="tahun" value="{{ $tahun }}">
      <x-primary-button type="submit">Simpan Rekap Bulanan</x-primary-button>
    </form>
  </div>
</x-sidebar-layout>
