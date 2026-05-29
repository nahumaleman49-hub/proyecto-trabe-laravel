<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Cambiar tipo de columna de unsigned a integer (compatible con int(11))
        Schema::table('detallecotizacion', function (Blueprint $table) {
            $table->integer('fk_id_material')->nullable()->change();
            $table->integer('fk_id_proveedor')->nullable()->change();
            $table->integer('fk_id_mano_obra')->nullable()->change();
        });

        // 2. Limpiar datos huérfanos (para evitar errores de integridad)
        DB::statement("UPDATE detallecotizacion SET fk_id_material = NULL WHERE fk_id_material IS NOT NULL AND fk_id_material NOT IN (SELECT ID_Material FROM materiales)");
        DB::statement("UPDATE detallecotizacion SET fk_id_proveedor = NULL WHERE fk_id_proveedor IS NOT NULL AND fk_id_proveedor NOT IN (SELECT ID_proveedor FROM proveedores)");
        DB::statement("UPDATE detallecotizacion SET fk_id_mano_obra = NULL WHERE fk_id_mano_obra IS NOT NULL AND fk_id_mano_obra NOT IN (SELECT ID_mano_obra FROM manoobra)");

        // 3. Agregar llaves foráneas
        Schema::table('detallecotizacion', function (Blueprint $table) {
            $table->foreign('fk_id_material', 'fk_detalle_material')
                  ->references('ID_Material')->on('materiales')
                  ->onDelete('set null');
            
            $table->foreign('fk_id_proveedor', 'fk_detalle_proveedor')
                  ->references('ID_proveedor')->on('proveedores')
                  ->onDelete('set null');
            
            $table->foreign('fk_id_mano_obra', 'fk_detalle_mano_obra')
                  ->references('ID_mano_obra')->on('manoobra')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('detallecotizacion', function (Blueprint $table) {
            $table->dropForeign('fk_detalle_material');
            $table->dropForeign('fk_detalle_proveedor');
            $table->dropForeign('fk_detalle_mano_obra');
        });
    }
};
