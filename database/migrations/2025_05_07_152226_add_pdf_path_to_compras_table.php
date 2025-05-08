<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('compras', function (Blueprint $table) {
            $table->string('pdf_path')->nullable()->after('status');
            // Agregar la columna 'pdf_path' después de la columna 'status'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('compras', function (Blueprint $table) {
            $table->dropColumn('pdf_path');
            // Eliminar la columna 'pdf_path' si es necesario
        });
    }
};
