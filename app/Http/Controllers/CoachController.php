<?php

namespace App\Http\Controllers;

use App\Models\Coach;
use Illuminate\Http\Request;

class CoachController extends Controller
{
    public function index(Request $request)
    {
        $query = Coach::query();

        // 1. Fitur Pencarian (Nama Pelatih, Kode Coach, Nomor Lisensi, No Telepon)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_coach', 'like', "%{$search}%")
                ->orWhere('kode_coach', 'like', "%{$search}%")
                ->orWhere('nomor_lisensi', 'like', "%{$search}%")
                ->orWhere('nomor_telephone_coach', 'like', "%{$search}%");
            });
        }

        // 3. Filter Status Pelatih
        if ($request->filled('status_coach')) {
            $query->where('status_coach', $request->status_coach);
        }

        $coaches = $query->latest()->get();

        if ($request->wantsJson()) {
            return response()->json(['status' => 'success', 'data' => $coaches]);
        }

        return view('coaches.index', compact('coaches'));
    }

    /**
     * Menyimpan data pelatih baru
     */
    public function store(Request $request)
    {
        // Validasi sesuai nama kolom migrasi baru Anda
        $validated = $request->validate([
            'kode_coach' => 'required|unique:coaches,kode_coach',
            'nama_coach' => 'required',
            'nomor_telephone_coach' => 'required',
            'cabang_olahraga' => 'required',
            'nomor_lisensi' => 'required',
            'tarif_perjam' => 'required|numeric',
            'status_coach' => 'required',
        ]);

        Coach::create($validated);

        return redirect()->route('coaches.index')->with('success', 'Pelatih berhasil ditambahkan!');
    }

    /**
     * Update data pelatih
     */
    public function update(Request $request, Coach $coach)
    {
        $validated = $request->validate([
            'nama_coach' => 'required',
            'nomor_telephone_coach' => 'required',
            'cabang_olahraga' => 'required',
            'nomor_lisensi' => 'required',
            'tarif_perjam' => 'required|numeric',
            'status_coach' => 'required',
        ]);

        $coach->update($validated);

        if ($request->wantsJson()) {
            return response()->json(['status' => 'success', 'data' => $coach]);
        }

        return redirect()->route('coaches.index')->with('success', 'Data pelatih berhasil diupdate');
    }

    /**
     * Hapus pelatih
     */
    public function destroy(Request $request, Coach $coach)
    {
        $coach->delete();

        if ($request->wantsJson()) {
            return response()->json(['status' => 'success', 'message' => 'Data pelatih berhasil dihapus']);
        }

        return redirect()->route('coaches.index')->with('success', 'Pelatih berhasil dihapus');
    }
}