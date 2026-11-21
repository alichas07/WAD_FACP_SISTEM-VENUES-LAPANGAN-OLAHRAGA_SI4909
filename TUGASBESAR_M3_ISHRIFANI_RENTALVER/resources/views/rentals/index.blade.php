@extends('layouts.app')

@section('content')
<div class="space-y-4">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-base font-bold text-slate-900">Rental Alat Olahraga</h1>
            <p class="text-xs text-slate-500">Master data sewa alat (raket, bola, rompi), kondisi fisik, dan tarif sewa</p>
        </div>
    </div>

    {{-- FORM INPUT / EDIT DI ATAS TABEL (KHUSUS ADMIN, TANPA MODAL) --}}
    @if(auth()->user()->role === 'admin')
    <div class="bg-white border border-slate-200 rounded-lg p-4">
        <div class="flex items-center justify-between mb-3">
            <h2 id="form-title" class="text-xs font-bold text-slate-800">Tambah Perlengkapan Sewa</h2>
            <button type="button" id="btn-batal" onclick="resetForm()" class="hidden text-xs text-slate-500 hover:text-slate-800 underline cursor-pointer">
                Batal Edit
            </button>
        </div>

        <form id="rental-form" action="{{ route('rentals.store') }}" method="POST" class="grid grid-cols-2 md:grid-cols-4 gap-2.5 text-xs">
            @csrf
            <input type="hidden" name="_method" id="form-method" value="POST">

            <div>
                <label class="block font-medium text-slate-700 mb-1">Kode Barang</label>
                <input type="text" name="kode_barang" id="kode_barang" value="{{ old('kode_barang') }}" placeholder="EQ-001" required
                       class="w-full px-2.5 py-1.5 border border-slate-300 rounded-lg text-slate-900">
            </div>

            <div>
                <label class="block font-medium text-slate-700 mb-1">Nama Barang</label>
                <input type="text" name="nama_barang" id="nama_barang" value="{{ old('nama_barang') }}" placeholder="Raket Yonex Astrox" required
                       class="w-full px-2.5 py-1.5 border border-slate-300 rounded-lg text-slate-900">
            </div>

            <div>
                <label class="block font-medium text-slate-700 mb-1">Kategori Barang</label>
                <select name="kategori_barang" id="kategori_barang" required class="w-full px-2.5 py-1.5 border border-slate-300 rounded-lg bg-white text-slate-900">
                    <option value="Raket">Raket</option>
                    <option value="Bola">Bola</option>
                    <option value="Rompi">Rompi</option>
                    <option value="Pelindung">Pelindung</option>
                    <option value="Sepatu">Sepatu</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>

            <div>
                <label class="block font-medium text-slate-700 mb-1">Kondisi</label>
                <select name="kondisi" id="kondisi" required class="w-full px-2.5 py-1.5 border border-slate-300 rounded-lg bg-white text-slate-900">
                    <option value="Sangat Baik">Sangat Baik</option>
                    <option value="Baik">Baik</option>
                    <option value="Perlu Servis">Perlu Servis</option>
                    <option value="Rusak">Rusak</option>
                </select>
            </div>

            <div>
                <label class="block font-medium text-slate-700 mb-1">Total Stok</label>
                <input type="number" name="total_stok" id="total_stok" value="{{ old('total_stok') }}" placeholder="10" min="0" required
                       class="w-full px-2.5 py-1.5 border border-slate-300 rounded-lg text-slate-900">
            </div>

            <div>
                <label class="block font-medium text-slate-700 mb-1">Stok Tersedia</label>
                <input type="number" name="stok_tersedia" id="stok_tersedia" value="{{ old('stok_tersedia') }}" placeholder="10" min="0" required
                       class="w-full px-2.5 py-1.5 border border-slate-300 rounded-lg text-slate-900">
            </div>

            <div>
                <label class="block font-medium text-slate-700 mb-1">Tarif Sewa (Rp)</label>
                <input type="number" name="tarif_sewa" id="tarif_sewa" value="{{ old('tarif_sewa') }}" placeholder="25000" min="0" required
                       class="w-full px-2.5 py-1.5 border border-slate-300 rounded-lg text-slate-900">
            </div>

            <div class="flex gap-2">
                <div class="flex-1">
                    <label class="block font-medium text-slate-700 mb-1">Denda Rusak (Rp)</label>
                    <input type="number" name="denda_rusak" id="denda_rusak" value="{{ old('denda_rusak') }}" placeholder="150000" min="0"
                           class="w-full px-2.5 py-1.5 border border-slate-300 rounded-lg text-slate-900">
                </div>
                <div class="flex items-end">
                    <button type="submit" id="btn-submit" class="px-3 py-1.5 bg-slate-900 hover:bg-slate-800 text-white font-semibold rounded-lg cursor-pointer whitespace-nowrap">
                        Simpan Alat
                    </button>
                </div>
            </div>
        </form>
    </div>
    @endif

    {{-- FORM CARI & FILTER --}}
    <form method="GET" action="{{ route('rentals.index') }}" class="bg-white p-2.5 border border-slate-200 rounded-lg flex flex-wrap gap-2 text-xs">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama barang atau kode alat..."
               class="flex-1 min-w-[180px] px-2.5 py-1.5 border border-slate-300 rounded-lg">

        <select name="kondisi" class="px-2.5 py-1.5 border border-slate-300 rounded-lg bg-white text-slate-700">
            <option value="">Semua Kondisi</option>
            <option value="Sangat Baik" {{ request('kondisi') == 'Sangat Baik' ? 'selected' : '' }}>Sangat Baik</option>
            <option value="Baik" {{ request('kondisi') == 'Baik' ? 'selected' : '' }}>Baik</option>
            <option value="Perlu Servis" {{ request('kondisi') == 'Perlu Servis' ? 'selected' : '' }}>Perlu Servis</option>
            <option value="Rusak" {{ request('kondisi') == 'Rusak' ? 'selected' : '' }}>Rusak</option>
        </select>

        <button type="submit" class="px-3 py-1.5 bg-slate-900 hover:bg-slate-800 text-white rounded-lg font-semibold cursor-pointer">
            Cari & Filter
        </button>

        @if(request()->hasAny(['search', 'kategori_barang', 'kondisi']))
            <a href="{{ route('rentals.index') }}" class="px-3 py-1.5 bg-slate-100 text-slate-600 rounded-lg hover:bg-slate-200">
                Reset
            </a>
        @endif
    </form>

    {{-- TABEL DATA RENTAL ALAT --}}
    <div class="bg-white border border-slate-200 rounded-lg overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead class="bg-slate-50 text-slate-600 border-b border-slate-200 font-semibold">
                <tr>
                    <th class="py-2.5 px-3">Kode Barang</th>
                    <th class="py-2.5 px-3">Nama Barang</th>
                    <th class="py-2.5 px-3">Kategori</th>
                    <th class="py-2.5 px-3 text-center">Stok (Tersedia / Total)</th>
                    <th class="py-2.5 px-3">Kondisi</th>
                    <th class="py-2.5 px-3 text-right">Tarif Sewa</th>
                    <th class="py-2.5 px-3 text-right">Denda Rusak</th>
                    @if(auth()->user()->role === 'admin')
                        <th class="py-2.5 px-3 text-center">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
                @forelse($rentals as $r)
                <tr class="hover:bg-slate-50">
                    <td class="py-2.5 px-3 font-mono font-medium text-slate-900">{{ $r->kode_barang }}</td>
                    <td class="py-2.5 px-3 font-medium text-slate-900">{{ $r->nama_barang }}</td>
                    <td class="py-2.5 px-3">{{ $r->kategori_barang }}</td>
                    <td class="py-2.5 px-3 text-center font-mono">
                        <span class="text-emerald-700 font-semibold">{{ $r->stok_tersedia }}</span> / {{ $r->total_stok }}
                    </td>
                    <td class="py-2.5 px-3">
                        <span class="font-medium {{
                            $r->kondisi == 'Sangat Baik' ? 'text-emerald-700' :
                            ($r->kondisi == 'Baik' ? 'text-blue-700' :
                            ($r->kondisi == 'Perlu Servis' ? 'text-amber-600' :
                            ($r->kondisi == 'Rusak' ? 'text-rose-600' : 'text-slate-700')))
                        }}">
                            {{ $r->kondisi }}
                        </span>
                    </td>
                    <td class="py-2.5 px-3 text-right font-mono font-medium text-slate-900">
                        Rp {{ number_format($r->tarif_sewa, 0, ',', '.') }}
                    </td>
                    <td class="py-2.5 px-3 text-right font-mono text-slate-500">
                        Rp {{ number_format($r->denda_rusak, 0, ',', '.') }}
                    </td>
                    @if(auth()->user()->role === 'admin')
                    <td class="py-2.5 px-3 text-center space-x-2">
                        <button type="button" onclick='editRental(@json($r))' class="text-blue-600 hover:text-blue-800 font-medium cursor-pointer">
                            Edit
                        </button>
                        <form action="{{ route('rentals.destroy', $r) }}" method="POST" onsubmit="return confirm('Hapus perlengkapan ini?')" class="inline">
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
                        Belum ada data rental alat.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if(auth()->user()->role === 'admin')
<script>
    function editRental(r) {
        document.getElementById('form-title').innerText = 'Edit Perlengkapan (' + r.kode_barang + ')';
        document.getElementById('rental-form').action = '/rentals/' + r.id;
        document.getElementById('form-method').value = 'PUT';
        document.getElementById('kode_barang').value = r.kode_barang;
        document.getElementById('kode_barang').disabled = true;
        document.getElementById('kode_barang').classList.add('bg-slate-100', 'text-slate-500');
        document.getElementById('nama_barang').value = r.nama_barang;
        document.getElementById('kategori_barang').value = r.kategori_barang;
        document.getElementById('kondisi').value = r.kondisi;
        document.getElementById('total_stok').value = r.total_stok;
        document.getElementById('stok_tersedia').value = r.stok_tersedia;
        document.getElementById('tarif_sewa').value = parseInt(r.tarif_sewa);
        document.getElementById('denda_rusak').value = parseInt(r.denda_rusak || 0);
        document.getElementById('btn-submit').innerText = 'Perbarui Data';
        document.getElementById('btn-batal').classList.remove('hidden');
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function resetForm() {
        document.getElementById('form-title').innerText = 'Tambah Perlengkapan Sewa';
        document.getElementById('rental-form').action = "{{ route('rentals.store') }}";
        document.getElementById('form-method').value = 'POST';
        document.getElementById('rental-form').reset();
        document.getElementById('kode_barang').disabled = false;
        document.getElementById('kode_barang').classList.remove('bg-slate-100', 'text-slate-500');
        document.getElementById('btn-submit').innerText = 'Simpan Alat';
        document.getElementById('btn-batal').classList.add('hidden');
    }
</script>
@endif
@endsection