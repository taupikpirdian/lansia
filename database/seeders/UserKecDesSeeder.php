<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserKecDesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * create user from kecamatan
         */
        $kecamatans = \App\Models\Kecamatan::all();
        foreach ($kecamatans as $kecamatan) {
            $username = $kecamatan->kode_kec . '_' . strtolower($kecamatan->nama);
            $user = User::create([
                'name' => $kecamatan->nama,
                'username' => $username,
                'email' => $username . '@mail.com',
                'password' => bcrypt('password'),
                'kecamatan_id' => $kecamatan->id,
                'desa_id' => null,
            ]);
            // assign role operator-kecamatan
            $user->assignRole('operator-kecamatan');
        }

        /**
         * create user from desa
         */
        $desas = \App\Models\Desa::all();
        foreach ($desas as $desa) {
            $username = $desa->kode_kec . '_' . $desa->kode_desa . '_' . strtolower($desa->nama);
            $user = User::create([
                'name' => $desa->nama,
                'username' => $username,
                'email' => $username . '@mail.com',
                'password' => bcrypt('password'),
                'kecamatan_id' => null,
                'desa_id' => $desa->id,
            ]);
            // assign role operator-desa
            $user->assignRole('operator-desa');
        }
    }
}
