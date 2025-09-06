<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusNikahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\StatusNikah::create([
            'name' => 'Nikah',
        ]);
        \App\Models\StatusNikah::create([
            'name' => 'Belum Nikah',
        ]);
    }
}
