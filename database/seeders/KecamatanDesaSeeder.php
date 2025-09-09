<?php

namespace Database\Seeders;

use App\Models\Desa;
use App\Models\Kecamatan;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class KecamatanDesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('seeders/data/wilayah.xlsx');

        $rows = Excel::toArray([], $path)[0]; // ambil sheet pertama

        // Buang header (baris pertama)
        array_shift($rows);

        $kecamatanData = [];
        $desaData = [];

        foreach ($rows as $row) {
            [$nama_kecamatan, $nama_desa, $kode_wilayah, $kode_prov, $kode_kab, $kode_kec, $kode_desa] = $row;
            // Insert kecamatan (hindari duplikat)
            if (!isset($kecamatanData[getKodeWilayah($kode_wilayah)['kode_kec']])) {
                $kecamatanData[getKodeWilayah($kode_wilayah)['kode_kec']] = [
                    'kode_prov'  => (string) getKodeWilayah($kode_wilayah)['kode_prov'],
                    'kode_kab'   => (string) getKodeWilayah($kode_wilayah)['kode_kab'],
                    'kode_kec'   => (string) getKodeWilayah($kode_wilayah)['kode_kec'],
                    'nama'       => $nama_kecamatan,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Insert desa
            $desaData[] = [
                'kode_kec'     => (string) getKodeWilayah($kode_wilayah)['kode_kec'],
                'kode_desa'    => (string) getKodeWilayah($kode_wilayah)['kode_desa'],
                'kode_wilayah' => (string) $kode_wilayah,
                'nama'         => $nama_desa,
                'created_at'   => now(),
                'updated_at'   => now(),
            ];
        }
        Kecamatan::insert($kecamatanData);
        Desa::insert($desaData);
    }
}
