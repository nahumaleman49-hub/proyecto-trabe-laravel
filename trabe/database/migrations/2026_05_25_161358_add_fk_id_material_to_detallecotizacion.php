<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Obtener el nombre real de la llave foránea de fk_id_mano_obra
        // $foreignKeyName = 'detallecotizacion_ibfk_1';
        // $result = DB::select("
        //     SELECT CONSTRAINT_NAME 
        //     FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
        //     WHERE TABLE_SCHEMA = DATABASE() 
        //     AND TABLE_NAME = 'detallecotizacion' 
        //     AND COLUMN_NAME = 'fk_id_mano_obra'
        // ");
        // if (!empty($result)) {
        //     $foreignKeyName = $result[0]->CONSTRAINT_NAME;
        // }

        // // 2. Eliminar la llave foránea si existe
        // if ($foreignKeyName) {
        //     Schema::table('detallecotizacion', function (Blueprint $table) use ($foreignKeyName) {
        //         $table->dropForeign($foreignKeyName);
        //     });
        // }

        // 3. Cambiar fk_id_mano_obra a nullable (tipo integer)
        // Schema::table('detallecotizacion', function (Blueprint $table) {
        //     $table->integer('fk_id_mano_obra')->nullable()->change();
        // });

        // 4. Agregar columnas faltantes (con tipo integer)
        Schema::table('detallecotizacion', function (Blueprint $table) {
        if (!Schema::hasColumn('detallecotizacion', 'fk_id_material')) {
            $table->integer('fk_id_material')->nullable()->after('fk_id_cotizacion');
        }
        if (!Schema::hasColumn('detallecotizacion', 'fk_id_proveedor')) {
            $table->integer('fk_id_proveedor')->nullable()->after('fk_id_material');
        }
        if (!Schema::hasColumn('detallecotizacion', 'precio_unit')) {
            $table->decimal('precio_unit', 10, 2)->nullable()->after('cantidad');
        }
        if (!Schema::hasColumn('detallecotizacion', 'tiempo_entrega_dias')) {
            $table->integer('tiempo_entrega_dias')->nullable()->after('precio_unit');
        }
        // NO agregar foreign keys aquí
    });

        // 5. Agregar nuevas llaves foráneas
        // Schema::table('detallecotizacion', function (Blueprint $table) {
        //     $table->foreign('fk_id_material')->references('ID_Material')->on('materiales');
        //     $table->foreign('fk_id_proveedor')->references('ID_proveedor')->on('proveedores');
        //     $table->foreign('fk_id_mano_obra')->references('ID_mano_obra')->on('manoobra');
        // });
    }

    public function down(): void
    {
        Schema::table('detallecotizacion', function (Blueprint $table) {
            $table->dropForeign(['fk_id_material']);
            $table->dropForeign(['fk_id_proveedor']);
            $table->dropForeign(['fk_id_mano_obra']);
        });

        Schema::table('detallecotizacion', function (Blueprint $table) {
            $table->dropColumn(['fk_id_material', 'fk_id_proveedor', 'precio_unit', 'tiempo_entrega_dias']);
        });

        // Revertir fk_id_mano_obra a NOT NULL (solo si no hay datos nulos)
        Schema::table('detallecotizacion', function (Blueprint $table) {
            $table->integer('fk_id_mano_obra')->nullable(false)->change();
        });
    }
};