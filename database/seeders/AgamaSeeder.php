<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AgamaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Agama::create([
            'name' => 'Islam',
        ]);
        \App\Models\Agama::create([
            'name' => 'Katolik',
        ]);
        \App\Models\Agama::create([
            'name' => 'Protestan',
        ]);
        \App\Models\Agama::create([
            'name' => 'Hindu',
        ]);
        \App\Models\Agama::create([
            'name' => 'Budha',
        ]);
        \App\Models\Agama::create([
            'name' => 'Konghucu',
        ]);
    }
}
