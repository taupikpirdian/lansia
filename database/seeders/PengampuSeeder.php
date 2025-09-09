<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PengampuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Pengampu::create([
            'name' => 'Anak',
        ]);
        \App\Models\Pengampu::create([
            'name' => 'Keluarga',
        ]);
        \App\Models\Pengampu::create([
            'name' => 'Keluarga Lain',
        ]);
    }
}
