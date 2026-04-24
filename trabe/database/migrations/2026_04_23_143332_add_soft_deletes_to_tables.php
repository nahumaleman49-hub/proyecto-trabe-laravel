<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Agregar soft deletes solo si no existen
        if (!Schema::hasColumn('clientes', 'deleted_at')) {
            Schema::table('clientes', function (Blueprint $table) {
                $table->softDeletes();
            });
        }

        if (!Schema::hasColumn('proyecto', 'deleted_at')) {
            Schema::table('proyecto', function (Blueprint $table) {
                $table->softDeletes();
            });
        }

        if (!Schema::hasColumn('materiales', 'deleted_at')) {
            Schema::table('materiales', function (Blueprint $table) {
                $table->softDeletes();
            });
        }

        if (!Schema::hasColumn('proveedores', 'deleted_at')) {
            Schema::table('proveedores', function (Blueprint $table) {
                $table->softDeletes();
            });
        }

        if (!Schema::hasColumn('servicio', 'deleted_at')) {
            Schema::table('servicio', function (Blueprint $table) {
                $table->softDeletes();
            });
        }

        if (!Schema::hasColumn('cotizacion', 'deleted_at')) {
            Schema::table('cotizacion', function (Blueprint $table) {
                $table->softDeletes();
            });
        }

        // Agregar columna fk_id_proveedor y foreign key si no existe
        if (!Schema::hasColumn('ordenes', 'fk_id_proveedor')) {
            Schema::table('ordenes', function (Blueprint $table) {
                $table->integer('fk_id_proveedor')->after('fk_id_proyecto');
                $table->foreign('fk_id_proveedor')->references('ID_proveedor')->on('proveedores');
            });
        }
    }

    public function down(): void
    {
        // Eliminar foreign key y columna de ordenes si existen
        if (Schema::hasColumn('ordenes', 'fk_id_proveedor')) {
            Schema::table('ordenes', function (Blueprint $table) {
                $table->dropForeign(['fk_id_proveedor']);
                $table->dropColumn('fk_id_proveedor');
            });
        }

        // Eliminar soft deletes solo si existen
        if (Schema::hasColumn('clientes', 'deleted_at')) {
            Schema::table('clientes', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }
        if (Schema::hasColumn('proyecto', 'deleted_at')) {
            Schema::table('proyecto', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }
        if (Schema::hasColumn('materiales', 'deleted_at')) {
            Schema::table('materiales', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }
        if (Schema::hasColumn('proveedores', 'deleted_at')) {
            Schema::table('proveedores', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }
        if (Schema::hasColumn('servicio', 'deleted_at')) {
            Schema::table('servicio', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }
        if (Schema::hasColumn('cotizacion', 'deleted_at')) {
            Schema::table('cotizacion', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }
    }
};