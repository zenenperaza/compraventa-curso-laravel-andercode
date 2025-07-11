<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Customer;
use App\Models\TipoDocumento;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // RoleSeeder::class,
            // UserSeeder::class,
            // CategorySeeder::class,
            // ProductSeeder::class,
            // CustomerSeeder::class,
            // SupplierSeeder::class,
            TipoDocumentoSeeder::class,
        ]);
    }
}
