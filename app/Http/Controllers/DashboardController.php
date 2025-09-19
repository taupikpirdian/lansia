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
use App\Models\Kecamatan;
use App\Models\StatusNikah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get user role
        $user = Auth::user();
        $role = $user->roles->first()->name ?? null; // Get first role name

        // Base query with role-based filtering
        $baseQuery = Biodata::when($role == 'operator-desa', function ($query) use ($user) {
            $query->where('desa_id', $user->desa_id);
        })->when($role == 'operator-kecamatan', function ($query) use ($user) {
            $query->where('kecamatan_id', $user->kecamatan_id);
        });

        // Total Penduduk Terdaftar
        $countUsers = (clone $baseQuery)->count();

        // Penduduk Eligible
        $countEligible = (clone $baseQuery)->where('status', 'disetujui')->count();

        // Total Desa 
        // count bedas by kecamatan_id
        if ($role == 'operator-kecamatan') {
            $kec = Kecamatan::where('id', $user->kecamatan_id)->first();
            $countDesa = Desa::where('kode_kec', $kec->kode_kec)->count();
        } else if ($role == "operator-desa") {
            $desa = Desa::where('id', $user->desa_id)->first();
            $kec = Kecamatan::where('kode_kec', $desa->kode_kec)->first();
            $countDesa = Desa::where('kode_kec', $kec->kode_kec)->count();
        } else {
            $countDesa = Desa::count();
        }

        // Total Kategori Khusus Lansia/Disabilitas
        $countKategoriKhusus = (clone $baseQuery)->whereHas('kategori', function ($query) {
            $query->where('name', 'Disabilitas Terlantar');
        })->count();

        // Jenis Kelamin
        $countLakiLaki = (clone $baseQuery)->where('jk', 'L')->count();
        $countPerempuan = (clone $baseQuery)->where('jk', 'P')->count();

        // semua status nikah
        $allStatus = StatusNikah::pluck('name', 'id'); // ['1' => 'Belum Menikah', ...]
        // hitung jumlah biodata per status nikah
        $counts = (clone $baseQuery)->selectRaw('status_nikah_id, COUNT(*) as total')
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
        $countsKategori = (clone $baseQuery)->selectRaw('kategori_id, COUNT(*) as total')
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
        $countsAgama = (clone $baseQuery)->selectRaw('agama_id, COUNT(*) as total')
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
        $countsKondisi = (clone $baseQuery)->selectRaw('kondisi_id, COUNT(*) as total')
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
        $countsPengampu = (clone $baseQuery)->selectRaw('pengampu_id, COUNT(*) as total')
            ->groupBy('pengampu_id')
            ->pluck('total', 'pengampu_id');

        $dataPengampu = $allPengampu->map(function ($label, $id) use ($countsPengampu) {
            return [
                'label' => $label,
                'total' => $countsPengampu[$id] ?? 0
            ];
        })->values();

        $dataKecamatan = (clone $baseQuery)->selectRaw('kecamatan_id, COUNT(*) as total')
            ->with('kecamatan') // eager load nama kecamatan
            ->groupBy('kecamatan_id')
            ->get()
            ->map(function ($item) {
                return [
                    'label' => $item->kecamatan->nama ?? 'Unknown',
                    'total' => $item->total
                ];
            });

        $dataDesa = (clone $baseQuery)->selectRaw('desa_id, COUNT(*) as total')
            ->with('desa') // eager load nama desa
            ->groupBy('desa_id')
            ->get()
            ->map(function ($item) {
                return [
                    'label' => $item->desa->nama ?? 'Unknown',
                    'total' => $item->total
                ];
            });

        $topDesa = (clone $baseQuery)->selectRaw('desa_id, COUNT(*) as total')
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
