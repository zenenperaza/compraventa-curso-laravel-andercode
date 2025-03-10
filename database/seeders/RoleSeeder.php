<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'Administrador', 'description' => 'Administrator'],
            ['name' => 'Vendedor', 'description' => 'Editor'],
            ['name' => 'Comprador', 'description' => 'Viewer'],
            ['name' => 'Mantenedor', 'description' => 'Viewer'],
            ['name' => 'Analista', 'description' => 'Viewer'],
            ['name' => 'Almacen', 'description' => 'Viewer'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
