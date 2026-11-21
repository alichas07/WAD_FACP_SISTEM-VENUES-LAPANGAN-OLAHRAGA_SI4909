@extends('layouts.app')

@section('content')
<div class="space-y-4">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-base font-bold text-slate-900">Lapangan</h1>
            <p class="text-xs text-slate-500">Master data lapangan, jenis rumput/lantai, ukuran, dan status fisik</p>
        </div>
    </div>

    {{-- FORM INPUT / EDIT DI ATAS TABEL (KHUSUS ADMIN, TANPA MODAL) --}}
    @if(auth()->user()->role === 'admin')
    <div class="bg-white border border-slate-200 rounded-lg p-4">
        <div class="flex items-center justify-between mb-3">
            <h2 id="form-title" class="text-xs font-bold text-slate-800">Tambah Lapangan Baru</h2>
            <button type="button" id="btn-batal" onclick="resetForm()" class="hidden text-xs text-slate-500 hover:text-slate-800 underline cursor-pointer">
                Batal Edit
            </button>
        </div>

        <form id="venue-form" action="{{ route('venues.store') }}" method="POST" class="grid grid-cols-2 md:grid-cols-4 gap-2.5 text-xs">
            @csrf
            <input type="hidden" name="_method" id="form-method" value="POST">

            <div>
                <label class="block font-medium text-slate-700 mb-1">Kode Lapangan</label>
                <input type="text" name="kode_lapangan" id="kode_lapangan" value="{{ old('kode_lapangan') }}" placeholder="LAP-001" required
                       class="w-full px-2.5 py-1.5 border border-slate-300 rounded-lg text-slate-900">
            </div>

            <div>
                <label class="block font-medium text-slate-700 mb-1">Nama Lapangan</label>
                <input type="text" name="nama_lapangan" id="nama_lapangan" value="{{ old('nama_lapangan') }}" placeholder="Futsal Court A" required
                       class="w-full px-2.5 py-1.5 border border-slate-300 rounded-lg text-slate-900">
            </div>

            <div>
                <label class="block font-medium text-slate-700 mb-1">Cabang Olahraga</label>
                <input type="text" name="tipe_olahraga" id="tipe_olahraga" value="{{ old('tipe_olahraga') }}" placeholder="Futsal / Badminton" required
                       class="w-full px-2.5 py-1.5 border border-slate-300 rounded-lg text-slate-900">
            </div>

            <div>
                <label class="block font-medium text-slate-700 mb-1">Lantai / Rumput</label>
                <input type="text" name="jenis_lantai" id="jenis_lantai" value="{{ old('jenis_lantai') }}" placeholder="Rumput Sintetis / Vinyl" required
                       class="w-full px-2.5 py-1.5 border border-slate-300 rounded-lg text-slate-900">
            </div>

            <div>
                <label class="block font-medium text-slate-700 mb-1">Ukuran / Dimensi</label>
                <input type="text" name="ukuran_lapangan" id="ukuran_lapangan" value="{{ old('ukuran_lapangan') }}" placeholder="25m x 15m" required
                       class="w-full px-2.5 py-1.5 border border-slate-300 rounded-lg text-slate-900">
            </div>

            <div>
                <label class="block font-medium text-slate-700 mb-1">Tarif / Jam (Rp)</label>
                <input type="number" name="tarif_perjam" id="tarif_perjam" value="{{ old('tarif_perjam') }}" placeholder="150000" required
                       class="w-full px-2.5 py-1.5 border border-slate-300 rounded-lg text-slate-900">
            </div>

            <div>
                <label class="block font-medium text-slate-700 mb-1">Status Lapangan</label>
                <select name="status_lapangan" id="status_lapangan" class="w-full px-2.5 py-1.5 border border-slate-300 rounded-lg bg-white text-slate-900">
                    <option value="Tersedia">Tersedia</option>
                    <option value="Maintenance">Maintenance</option>
                    <option value="Renovasi">Renovasi</option>
                    <option value="Dipesan">Dipesan</option>
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" id="btn-submit" class="w-full px-3 py-1.5 bg-slate-900 hover:bg-slate-800 text-white font-semibold rounded-lg cursor-pointer">
                    Simpan Lapangan
                </button>
            </div>
        </form>
    </div>
    @endif

    {{-- FORM CARI & FILTER --}}
    <form method="GET" action="{{ route('venues.index') }}" class="bg-white p-2.5 border border-slate-200 rounded-lg flex flex-wrap gap-2 text-xs">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama lapangan, kode, lantai..."
               class="flex-1 min-w-[180px] px-2.5 py-1.5 border border-slate-300 rounded-lg">

        <select name="status_lapangan" class="px-2.5 py-1.5 border border-slate-300 rounded-lg bg-white text-slate-700">
            <option value="">Semua Status</option>
            <option value="Tersedia" {{ request('status_lapangan') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
            <option value="Maintenance" {{ request('status_lapangan') == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
            <option value="Renovasi" {{ request('status_lapangan') == 'Renovasi' ? 'selected' : '' }}>Renovasi</option>
            <option value="Dipesan" {{ request('status_lapangan') == 'Dipesan' ? 'selected' : '' }}>Dipesan</option>
        </select>

        <button type="submit" class="px-3 py-1.5 bg-slate-900 hover:bg-slate-800 text-white rounded-lg font-semibold cursor-pointer">
            Cari & Filter
        </button>

        @if(request()->hasAny(['search', 'tipe_olahraga', 'status_lapangan']))
            <a href="{{ route('venues.index') }}" class="px-3 py-1.5 bg-slate-100 text-slate-600 rounded-lg hover:bg-slate-200">
                Reset
            </a>
        @endif
    </form>

    {{-- TABEL DATA LAPANGAN --}}
    <div class="bg-white border border-slate-200 rounded-lg overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead class="bg-slate-50 text-slate-600 border-b border-slate-200 font-semibold">
                <tr>
                    <th class="py-2.5 px-3">Kode</th>
                    <th class="py-2.5 px-3">Nama Lapangan</th>
                    <th class="py-2.5 px-3">Cabang Olahraga</th>
                    <th class="py-2.5 px-3">Lantai / Rumput</th>
                    <th class="py-2.5 px-3">Ukuran</th>
                    <th class="py-2.5 px-3 text-right">Tarif/Jam</th>
                    <th class="py-2.5 px-3">Status</th>
                    @if(auth()->user()->role === 'admin')
                        <th class="py-2.5 px-3 text-center">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
                @forelse($venues as $v)
                <tr class="">
                    <td class="py-2.5 px-3 font-mono font-medium text-slate-900">{{ $v->kode_lapangan }}</td>
                    <td class="py-2.5 px-3 font-medium text-slate-900">{{ $v->nama_lapangan }}</td>
                    <td class="py-2.5 px-3">{{ $v->tipe_olahraga }}</td>
                    <td class="py-2.5 px-3">{{ $v->jenis_lantai }}</td>
                    <td class="py-2.5 px-3 font-mono">{{ $v->ukuran_lapangan }}</td>
                    <td class="py-2.5 px-3 text-right font-mono font-medium text-slate-900">
                        Rp {{ number_format($v->tarif_perjam, 0, ',', '.') }}
                    </td>
                    <td class="py-2.5 px-3">
                        @if($v->status_lapangan == 'Tersedia')
                            <span class="text-emerald-700 font-medium">Tersedia</span>
                        @elseif($v->status_lapangan == 'Maintenance')
                            <span class="text-amber-700 font-medium">Maintenance</span>
                        @elseif($v->status_lapangan == 'Renovasi')
                            <span class="text-red-700 font-medium">Renovasi</span>
                        @elseif($v->status_lapangan == 'Dipesan')
                            <span class="text-indigo-700 font-medium">Dipesan</span>
                        @else
                            <span class="text-slate-700 font-medium">{{ $v->status_lapangan }}</span>
                        @endif
                    </td>
                    @if(auth()->user()->role === 'admin')
                    <td class="py-2.5 px-3 text-center space-x-2">
                        <button type="button" onclick='editVenue(@json($v))' class="text-blue-600 hover:text-blue-800 font-medium cursor-pointer">
                            Edit
                        </button>
                        <form action="{{ route('venues.destroy', $v) }}" method="POST" onsubmit="return confirm('Hapus lapangan ini?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-slate-400 hover:text-rose-600 cursor-pointer">Hapus</button>
                        </form>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="{{ auth()->user()->role === 'admin' ? 8 : 7 }}" class="py-8 text-center text-slate-400 italic">
                        Belum ada data lapangan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if(auth()->user()->role === 'admin')
<script>
    function editVenue(v) {
        document.getElementById('form-title').innerText = 'Edit Lapangan (' + v.kode_lapangan + ')';
        document.getElementById('venue-form').action = '/venues/' + v.id;
        document.getElementById('form-method').value = 'PUT';
        document.getElementById('kode_lapangan').value = v.kode_lapangan;
        document.getElementById('kode_lapangan').disabled = true;
        document.getElementById('kode_lapangan').classList.add('bg-slate-100', 'text-slate-500');
        document.getElementById('nama_lapangan').value = v.nama_lapangan;
        document.getElementById('tipe_olahraga').value = v.tipe_olahraga;
        document.getElementById('jenis_lantai').value = v.jenis_lantai;
        document.getElementById('ukuran_lapangan').value = v.ukuran_lapangan;
        document.getElementById('tarif_perjam').value = parseInt(v.tarif_perjam);
        document.getElementById('status_lapangan').value = v.status_lapangan;
        document.getElementById('btn-submit').innerText = 'Perbarui Data';
        document.getElementById('btn-batal').classList.remove('hidden');
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function resetForm() {
        document.getElementById('form-title').innerText = 'Tambah Lapangan Baru';
        document.getElementById('venue-form').action = "{{ route('venues.store') }}";
        document.getElementById('form-method').value = 'POST';
        document.getElementById('venue-form').reset();
        document.getElementById('kode_lapangan').disabled = false;
        document.getElementById('kode_lapangan').classList.remove('bg-slate-100', 'text-slate-500');
        document.getElementById('btn-submit').innerText = 'Simpan Lapangan';
        document.getElementById('btn-batal').classList.add('hidden');
    }
</script>
@endif
@endsection