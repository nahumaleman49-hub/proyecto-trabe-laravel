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
    // Verificar que las columnas existan y no haya datos huérfanos antes de ejecutar
    // Limpiar huérfanos (repites el paso 2 aquí también, usando DB::statement)
    DB::statement("UPDATE detallecotizacion SET fk_id_material = NULL WHERE fk_id_material IS NOT NULL AND fk_id_material NOT IN (SELECT ID_Material FROM materiales)");
    DB::statement("UPDATE detallecotizacion SET fk_id_proveedor = NULL WHERE fk_id_proveedor IS NOT NULL AND fk_id_proveedor NOT IN (SELECT ID_proveedor FROM proveedores)");
    DB::statement("UPDATE detallecotizacion SET fk_id_mano_obra = NULL WHERE fk_id_mano_obra IS NOT NULL AND fk_id_mano_obra NOT IN (SELECT ID_mano_obra FROM manoobra)");

    // Schema::table('detallecotizacion', function (Blueprint $table) {
    //     $table->foreign('fk_id_material')->references('ID_Material')->on('materiales');
    //     $table->foreign('fk_id_proveedor')->references('ID_proveedor')->on('proveedores');
    //     $table->foreign('fk_id_mano_obra')->references('ID_mano_obra')->on('manoobra');
    // });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detallecotizacion', function (Blueprint $table) {
            //
        });
    }
};
