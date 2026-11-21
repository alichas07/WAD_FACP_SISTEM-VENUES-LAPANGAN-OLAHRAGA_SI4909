@extends('layouts.app')

@section('content')
<div class="space-y-4">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-base font-bold text-slate-900">Instruktur</h1>
            <p class="text-xs text-slate-500">Master data instruktur, nomor lisensi, dan keahlian cabang olahraga</p>
        </div>
    </div>

    {{-- FORM INPUT / EDIT DI ATAS TABEL (KHUSUS ADMIN, TANPA MODAL) --}}
    @if(auth()->user()->role === 'admin')
    <div class="bg-white border border-slate-200 rounded-lg p-4">
        <div class="flex items-center justify-between mb-3">
            <h2 id="form-title" class="text-xs font-bold text-slate-800">Tambah Pelatih Baru</h2>
            <button type="button" id="btn-batal" onclick="resetForm()" class="hidden text-xs text-slate-500 hover:text-slate-800 underline cursor-pointer">
                Batal Edit
            </button>
        </div>

        <form id="coach-form" action="{{ route('coaches.store') }}" method="POST" class="grid grid-cols-2 md:grid-cols-4 gap-2.5 text-xs">
            @csrf
            <input type="hidden" name="_method" id="form-method" value="POST">

            <div>
                <label class="block font-medium text-slate-700 mb-1">Kode Coach</label>
                <input type="text" name="kode_coach" id="kode_coach" value="{{ old('kode_coach') }}" placeholder="CCH-002" required
                       class="w-full px-2.5 py-1.5 border border-slate-300 rounded-lg text-slate-900">
            </div>

            <div>
                <label class="block font-medium text-slate-700 mb-1">Nama Lengkap</label>
                <input type="text" name="nama_coach" id="nama_coach" value="{{ old('nama_coach') }}" placeholder="Bambang Suryo" required
                       class="w-full px-2.5 py-1.5 border border-slate-300 rounded-lg text-slate-900">
            </div>

            <div>
                <label class="block font-medium text-slate-700 mb-1">No. Telephone Coach</label>
                <input type="text" name="nomor_telephone_coach" id="nomor_telephone_coach" value="{{ old('nomor_telephone_coach') }}" placeholder="08119876543" required
                       class="w-full px-2.5 py-1.5 border border-slate-300 rounded-lg text-slate-900">
            </div>

            <div>
                <label class="block font-medium text-slate-700 mb-1">Cabang Olahraga</label>
                <input type="text" name="cabang_olahraga" id="cabang_olahraga" value="{{ old('cabang_olahraga') }}" placeholder="Futsal / Badminton" required
                       class="w-full px-2.5 py-1.5 border border-slate-300 rounded-lg text-slate-900">
            </div>

            <div>
                <label class="block font-medium text-slate-700 mb-1">Nomor Lisensi</label>
                <input type="text" name="nomor_lisensi" id="nomor_lisensi" value="{{ old('nomor_lisensi') }}" placeholder="AFC-B-2023-88" required
                       class="w-full px-2.5 py-1.5 border border-slate-300 rounded-lg text-slate-900">
            </div>

            <div>
                <label class="block font-medium text-slate-700 mb-1">Tarif Per Jam (Rp)</label>
                <input type="number" name="tarif_perjam" id="tarif_perjam" value="{{ old('tarif_perjam') }}" placeholder="175000" required
                       class="w-full px-2.5 py-1.5 border border-slate-300 rounded-lg text-slate-900">
            </div>

            <div>
                <label class="block font-medium text-slate-700 mb-1">Status Coach</label>
                <select name="status_coach" id="status_coach" class="w-full px-2.5 py-1.5 border border-slate-300 rounded-lg bg-white text-slate-900">
                    <option value="Tersedia">Tersedia</option>
                    <option value="Dalam Sesi">Dalam Sesi</option>
                    <option value="Sedang Cuti">Sedang Cuti</option>
                    <option value="Nonaktif">Nonaktif</option>
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" id="btn-submit" class="w-full px-3 py-1.5 bg-slate-900 hover:bg-slate-800 text-white font-semibold rounded-lg cursor-pointer">
                    Simpan Pelatih
                </button>
            </div>
        </form>
    </div>
    @endif

    {{-- FORM CARI & FILTER --}}
    <form method="GET" action="{{ route('coaches.index') }}" class="bg-white p-2.5 border border-slate-200 rounded-lg flex flex-wrap gap-2 text-xs">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, kode coach, lisensi, telepon..."
               class="flex-1 min-w-[180px] px-2.5 py-1.5 border border-slate-300 rounded-lg">

        <select name="status_coach" class="px-2.5 py-1.5 border border-slate-300 rounded-lg bg-white text-slate-700">
            <option value="">Semua Status</option>
            <option value="Tersedia" {{ request('status_coach') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
            <option value="Dalam Sesi" {{ request('status_coach') == 'Dalam Sesi' ? 'selected' : '' }}>Dalam Sesi</option>
            <option value="Sedang Cuti" {{ request('status_coach') == 'Sedang Cuti' ? 'selected' : '' }}>Sedang Cuti</option>
            <option value="Nonaktif" {{ request('status_coach') == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
        </select>

        <button type="submit" class="px-3 py-1.5 bg-slate-900 hover:bg-slate-800 text-white rounded-lg font-semibold cursor-pointer">
            Cari & Filter
        </button>

        @if(request()->hasAny(['search', 'cabang_olahraga', 'status_coach']))
            <a href="{{ route('coaches.index') }}" class="px-3 py-1.5 bg-slate-100 text-slate-600 rounded-lg hover:bg-slate-200">
                Reset
            </a>
        @endif
    </form>

    {{-- TABEL DATA PELATIH --}}
    <div class="bg-white border border-slate-200 rounded-lg overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead class="bg-slate-50 text-slate-600 border-b border-slate-200 font-semibold">
                <tr>
                    <th class="py-2.5 px-3">Kode Coach</th>
                    <th class="py-2.5 px-3">Nama Pelatih</th>
                    <th class="py-2.5 px-3">No. Telepon</th>
                    <th class="py-2.5 px-3">Cabang Olahraga</th>
                    <th class="py-2.5 px-3">Nomor Lisensi</th>
                    <th class="py-2.5 px-3 text-right">Tarif / Jam</th>
                    <th class="py-2.5 px-3">Status</th>
                    @if(auth()->user()->role === 'admin')
                        <th class="py-2.5 px-3 text-center">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
                @forelse($coaches as $c)
                <tr class="hover:bg-slate-50">
                    <td class="py-2.5 px-3 font-mono font-medium text-slate-900">{{ $c->kode_coach }}</td>
                    <td class="py-2.5 px-3 font-medium text-slate-900">{{ $c->nama_coach }}</td>
                    <td class="py-2.5 px-3 font-mono">{{ $c->nomor_telephone_coach }}</td>
                    <td class="py-2.5 px-3 font-medium text-slate-800">{{ $c->cabang_olahraga }}</td>
                    <td class="py-2.5 px-3 font-mono text-slate-700">{{ $c->nomor_lisensi }}</td>
                    <td class="py-2.5 px-3 text-right font-mono font-medium text-slate-900">
                        Rp {{ number_format($c->tarif_perjam, 0, ',', '.') }}
                    </td>
                    <td class="py-2.5 px-3">
                        @if($c->status_coach == 'Tersedia')
                            <span class="font-semibold text-emerald-700">Tersedia</span>
                        @elseif($c->status_coach == 'Dalam Sesi' || $c->status_coach == 'Dalam_Sesi')
                            <span class="font-semibold text-amber-700">Dalam Sesi</span>
                        @elseif($c->status_coach == 'Sedang Cuti' || $c->status_coach == 'Sedang_Cuti')
                            <span class="text-xs font-semibold text-rose-700">Sedang Cuti</span>
                        @elseif($c->status_coach == 'Nonaktif')
                            <span class="font-semibold text-slate-600">Nonaktif</span>
                        @else
                            <span class="font-medium text-slate-700">{{ str_replace('_', ' ', $c->status_coach) }}</span>
                        @endif
                    </td>
                    @if(auth()->user()->role === 'admin')
                    <td class="py-2.5 px-3 text-center space-x-2">
                        <button type="button" onclick='editCoach(@json($c))' class="text-blue-600 hover:text-blue-800 font-medium cursor-pointer">
                            Edit
                        </button>
                        <form action="{{ route('coaches.destroy', $c) }}" method="POST" onsubmit="return confirm('Hapus pelatih ini?')" class="inline">
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
                        Belum ada data instruktur/pelatih.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if(auth()->user()->role === 'admin')
<script>
    function editCoach(c) {
        document.getElementById('form-title').innerText = 'Edit Data Pelatih (' + c.kode_coach + ')';
        document.getElementById('coach-form').action = '/coaches/' + c.id;
        document.getElementById('form-method').value = 'PUT';
        document.getElementById('kode_coach').value = c.kode_coach;
        document.getElementById('kode_coach').disabled = true;
        document.getElementById('kode_coach').classList.add('bg-slate-100', 'text-slate-500');
        document.getElementById('nama_coach').value = c.nama_coach;
        document.getElementById('nomor_telephone_coach').value = c.nomor_telephone_coach;
        document.getElementById('cabang_olahraga').value = c.cabang_olahraga;
        document.getElementById('nomor_lisensi').value = c.nomor_lisensi;
        document.getElementById('tarif_perjam').value = parseInt(c.tarif_perjam);
        document.getElementById('status_coach').value = (c.status_coach || 'Tersedia').replace('_', ' ');
        document.getElementById('btn-submit').innerText = 'Perbarui Data';
        document.getElementById('btn-batal').classList.remove('hidden');
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function resetForm() {
        document.getElementById('form-title').innerText = 'Tambah Pelatih Baru';
        document.getElementById('coach-form').action = "{{ route('coaches.store') }}";
        document.getElementById('form-method').value = 'POST';
        document.getElementById('coach-form').reset();
        document.getElementById('kode_coach').disabled = false;
        document.getElementById('kode_coach').classList.remove('bg-slate-100', 'text-slate-500');
        document.getElementById('btn-submit').innerText = 'Simpan Pelatih';
        document.getElementById('btn-batal').classList.add('hidden');
    }
</script>
@endif
@endsection