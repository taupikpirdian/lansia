<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()["cache"]->forget("spatie.permission.cache");
        // Role Default
        $admin = Role::where("name", "admin")
            ->where("guard_name", "web")
            ->first();

        if (!$admin) {
            Role::create([
                "name" => "admin",
                "guard_name" => "web",
            ]);
        }

        // add role, operator-desa, operator-kecamatan, operator-dinas
        Role::create([
            "name" => "operator-desa",
            "guard_name" => "web",
        ]);
        Role::create([
            "name" => "operator-kecamatan",
            "guard_name" => "web",
        ]);
        Role::create([
            "name" => "operator-dinas",
            "guard_name" => "web",
        ]);
    }
}
