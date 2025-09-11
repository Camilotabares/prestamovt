<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; 

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Validación previa: solo elimina si el índice existe
        $indexExists = DB::select("SHOW INDEX FROM clientes WHERE Key_name = 'clientes_cedula_unique'");
        if ($indexExists) {
            Schema::table('clientes', function (Blueprint $table) {
                $table->dropUnique(['clientes_cedula_unique']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->unique('cedula');
        });
    }
};
