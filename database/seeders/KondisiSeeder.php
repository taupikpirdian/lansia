<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KondisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tidak Terawat, Tidak Terpeliharan, Tidak Terurus
        \App\Models\Kondisi::create([
            'name' => 'Tidak Terawat',
        ]);
        \App\Models\Kondisi::create([
            'name' => 'Tidak Terpeliharan',
        ]);
        \App\Models\Kondisi::create([
            'name' => 'Tidak Terurus',
        ]);
    }
}
