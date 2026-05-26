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
        Schema::table('cotizacion', function (Blueprint $table) {
            $table->decimal('costo_equipo', 10, 2)->default(0)->after('total');
            $table->decimal('gastos_generales', 5, 2)->default(10)->after('costo_equipo');
            $table->decimal('margen_ganancia', 5, 2)->default(15)->after('gastos_generales');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cotizacion', function (Blueprint $table) {
            //
        });
    }
};
