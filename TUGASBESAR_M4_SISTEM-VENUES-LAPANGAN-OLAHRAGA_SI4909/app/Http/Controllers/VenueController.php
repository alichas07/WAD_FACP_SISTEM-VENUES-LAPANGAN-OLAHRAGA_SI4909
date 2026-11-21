<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use Illuminate\Http\Request;

class VenueController extends Controller
{
    public function index(Request $request)
    {
        $query = Venue::query();

        // 1. Fitur Pencarian (Nama, Kode Lapangan, Jenis Lantai)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lapangan', 'like', "%{$search}%")
                ->orWhere('kode_lapangan', 'like', "%{$search}%")
                ->orWhere('jenis_lantai', 'like', "%{$search}%");
            });
        }

        // 3. Filter Status Lapangan
        if ($request->filled('status_lapangan')) {
            $query->where('status_lapangan', $request->status_lapangan);
        }

        $venues = $query->latest()->get();

        if ($request->wantsJson()) {
            return response()->json(['status' => 'success', 'data' => $venues]);
        }

        return view('venues.index', compact('venues'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_lapangan'   => 'required|unique:venues,kode_lapangan',
            'nama_lapangan'   => 'required',
            'tipe_olahraga'   => 'required',
            'jenis_lantai'    => 'required',
            'ukuran_lapangan' => 'required',
            'tarif_perjam'    => 'required|numeric|min:0',
            'status_lapangan' => 'required|in:Tersedia,Maintenance,Renovasi,Dipesan',
        ]);

        $venue = Venue::create($validated);

        if ($request->wantsJson()) {
            return response()->json(['status' => 'success', 'data' => $venue], 201);
        }

        return redirect()->route('venues.index')->with('success', 'Lapangan berhasil ditambahkan!');
    }

    public function update(Request $request, Venue $venue)
    {
        $validated = $request->validate([
            'nama_lapangan'   => 'required',
            'tipe_olahraga'   => 'required',
            'jenis_lantai'    => 'required',
            'ukuran_lapangan' => 'required',
            'tarif_perjam'    => 'required|numeric|min:0',
            'status_lapangan' => 'required|in:Tersedia,Maintenance,Renovasi,Dipesan',
        ]);

        $venue->update($validated);

        if ($request->wantsJson()) {
            return response()->json(['status' => 'success', 'data' => $venue]);
        }

        return redirect()->route('venues.index')->with('success', 'Lapangan berhasil diperbarui!');
    }

    public function destroy(Request $request, Venue $venue)
    {
        $venue->delete();

        if ($request->wantsJson()) {
            return response()->json(['status' => 'success', 'message' => 'Lapangan berhasil dihapus']);
        }

        return redirect()->route('venues.index')->with('success', 'Lapangan berhasil dihapus!');
    }
}