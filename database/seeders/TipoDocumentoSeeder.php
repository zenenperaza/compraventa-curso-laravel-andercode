<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoDocumento;

class TipoDocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipoDocumento = [
            ['name' => 'Factura', 'description' => 'Documento usado para las ventas', 'type' => 'venta'],
            ['name' => 'Boleta', 'description' => 'Documento usado para las ventas', 'type' => 'venta'],
            ['name' => 'Guia de Remision', 'description' => 'Documento usado para las compras', 'type' => 'compra'],
        ];

        foreach ($tipoDocumento as $tipo) {
            TipoDocumento::create($tipo);
        }
    }
}
