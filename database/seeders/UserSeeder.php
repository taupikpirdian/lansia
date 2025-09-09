<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::updateOrCreate(
            [
                'email' =>  'admin@mail.com',
            ],
            [
                'name'  => 'Admin',
                'password'  => bcrypt('p@ssword')
            ]
        );
        $user->assignRole('admin');

        $user = User::create([
            'name' => 'Operator Desa',
            'email' => 'operator-desa@mail.com',
            'password' => bcrypt('p@ssword'),
        ]);
        $user->assignRole('operator-desa');

        $user = User::create([
            'name' => 'Operator Kecamatan',
            'email' => 'operator-kecamatan@mail.com',
            'password' => bcrypt('p@ssword'),
        ]);
        $user->assignRole('operator-kecamatan');

        $user = User::create([
            'name' => 'Operator Dinas',
            'email' => 'operator-dinas@mail.com',
            'password' => bcrypt('p@ssword'),
        ]);
        $user->assignRole('operator-dinas');
    }
}
