<?php

namespace App\Http\Controllers;

use App\Models\RentalItem;
use Illuminate\Http\Request;

class RentalItemController extends Controller
{
    public function index(Request $request)
    {
        $query = RentalItem::query();

        // 1. Fitur Pencarian (Nama Barang & Kode Barang)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                ->orWhere('kode_barang', 'like', "%{$search}%");
            });
        }

        // 3. Filter Kondisi Barang
        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        $rentals = $query->latest()->get();

        if ($request->wantsJson()) {
            return response()->json(['status' => 'success', 'data' => $rentals]);
        }

        return view('rentals.index', compact('rentals'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_barang' => 'required|unique:rental_items,kode_barang',
            'nama_barang' => 'required',
            'kategori_barang' => 'required',
            'total_stok' => 'required|numeric',
            'stok_tersedia' => 'required|numeric',
            'kondisi' => 'required',
            'tarif_sewa' => 'required|numeric',
            'denda_rusak' => 'nullable|numeric',
        ]);

        $item = RentalItem::create($validated);

        if ($request->wantsJson()) {
            return response()->json(['status' => 'success', 'data' => $item], 201);
        }

        return redirect()->route('rentals.index')->with('success', 'Alat berhasil ditambahkan');
    }

    public function update(Request $request, RentalItem $rental)
    {
        $validated = $request->validate([
            'nama_barang' => 'required',
            'kategori_barang' => 'required',
            'total_stok' => 'required|numeric',
            'stok_tersedia' => 'required|numeric',
            'kondisi' => 'required',
            'tarif_sewa' => 'required|numeric',
            'denda_rusak' => 'nullable|numeric',
        ]);

        $rental->update($validated);

        if ($request->wantsJson()) {
            return response()->json(['status' => 'success', 'data' => $rental]);
        }

        return redirect()->route('rentals.index')->with('success', 'Alat berhasil diupdate');
    }

    public function destroy(Request $request, RentalItem $rental)
    {
        $rental->delete();

        if ($request->wantsJson()) {
            return response()->json(['status' => 'success', 'message' => 'Alat berhasil dihapus']);
        }

        return redirect()->route('rentals.index')->with('success', 'Alat berhasil dihapus');
    }
}