<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\User;
use App\Models\Agama;
use App\Models\Report;
use App\Models\Biodata;
use App\Models\Kondisi;
use App\Models\Kategori;
use App\Models\Pengampu;
use App\Models\StatusNikah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Total Penduduk Terdaftar
        $countUsers = Biodata::count();

        // Penduduk Eligible
        $countEligible = Biodata::where('status', 'disetujui')->count();

        // Total Desa 
        $countDesa = Desa::count();

        // Total Kategori Khusus Lansia/Disabilitas
        $countKategoriKhusus = Biodata::whereHas('kategori', function ($query) {
            $query->where('name', 'Disabilitas Terlantar');
        })->count();

        // Jenis Kelamin
        $countLakiLaki = Biodata::where('jk', 'L')->count();
        $countPerempuan = Biodata::where('jk', 'P')->count();

        // semua status nikah
        $allStatus = StatusNikah::pluck('name', 'id'); // ['1' => 'Belum Menikah', ...]
        // hitung jumlah biodata per status nikah
        $counts = Biodata::selectRaw('status_nikah_id, COUNT(*) as total')
            ->groupBy('status_nikah_id')
            ->pluck('total', 'status_nikah_id'); // ['1' => 1800, ...]
        // gabungkan supaya semua status muncul walaupun count 0
        $dataStatusNikah = $allStatus->map(function ($label, $id) use ($counts) {
            return [
                'label' => $label,
                'total' => $counts[$id] ?? 0
            ];
        })->values();

        // --- Kategori ---
        $allKategori = Kategori::pluck('name', 'id'); // semua kategori
        $countsKategori = Biodata::selectRaw('kategori_id, COUNT(*) as total')
            ->groupBy('kategori_id')
            ->pluck('total', 'kategori_id');
        $dataKategori = $allKategori->map(function ($label, $id) use ($countsKategori) {
            return [
                'label' => $label,
                'total' => $countsKategori[$id] ?? 0
            ];
        })->values();

        // --- Agama ---
        $allAgama = Agama::pluck('name', 'id'); // semua agama
        $countsAgama = Biodata::selectRaw('agama_id, COUNT(*) as total')
            ->groupBy('agama_id')
            ->pluck('total', 'agama_id');

        $dataAgama = $allAgama->map(function ($label, $id) use ($countsAgama) {
            return [
                'label' => $label,
                'total' => $countsAgama[$id] ?? 0
            ];
        })->values();

        // --- Kondisi ---
        $allKondisi = Kondisi::pluck('name', 'id'); // semua kondisi
        $countsKondisi = Biodata::selectRaw('kondisi_id, COUNT(*) as total')
            ->groupBy('kondisi_id')
            ->pluck('total', 'kondisi_id');

        $dataKondisi = $allKondisi->map(function ($label, $id) use ($countsKondisi) {
            return [
                'label' => $label,
                'total' => $countsKondisi[$id] ?? 0
            ];
        })->values();

        // --- Pengampu ---
        $allPengampu = Pengampu::pluck('name', 'id'); // semua pengampu
        $countsPengampu = Biodata::selectRaw('pengampu_id, COUNT(*) as total')
            ->groupBy('pengampu_id')
            ->pluck('total', 'pengampu_id');

        $dataPengampu = $allPengampu->map(function ($label, $id) use ($countsPengampu) {
            return [
                'label' => $label,
                'total' => $countsPengampu[$id] ?? 0
            ];
        })->values();

        $dataKecamatan = Biodata::selectRaw('kecamatan_id, COUNT(*) as total')
            ->with('kecamatan') // eager load nama kecamatan
            ->groupBy('kecamatan_id')
            ->get()
            ->map(function ($item) {
                return [
                    'label' => $item->kecamatan->nama ?? 'Unknown',
                    'total' => $item->total
                ];
            });

        $dataDesa = Biodata::selectRaw('desa_id, COUNT(*) as total')
            ->with('desa') // eager load nama desa
            ->groupBy('desa_id')
            ->get()
            ->map(function ($item) {
                return [
                    'label' => $item->desa->nama ?? 'Unknown',
                    'total' => $item->total
                ];
            });

        $topDesa = Biodata::selectRaw('desa_id, COUNT(*) as total')
            ->with('desa')
            ->groupBy('desa_id')
            ->orderByDesc('total')
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'label' => $item->desa->nama ?? 'Unknown',
                    'total' => $item->total
                ];
            });

        return view('admin.index', compact('countUsers', 'countEligible', 'countDesa', 'countKategoriKhusus', 'countLakiLaki', 'countPerempuan', 'dataStatusNikah', 'dataKategori', 'dataAgama', 'dataKondisi', 'dataPengampu', 'dataKecamatan', 'dataDesa', 'topDesa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}