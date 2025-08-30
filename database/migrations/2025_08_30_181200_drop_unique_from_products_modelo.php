<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Quita el índice único en products.modelo si existe
        if (!Schema::hasTable('products')) return;

        $exists = collect(DB::select("SHOW INDEXES FROM `products` WHERE Key_name = 'products_modelo_unique'"))->isNotEmpty();
        if ($exists) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropUnique('products_modelo_unique');
            });
        }
    }

    public function down(): void
    {
        // Restaurar UNIQUE en caso de rollback (no recomendado si aceptas duplicados)
        if (!Schema::hasTable('products')) return;

        $exists = collect(DB::select("SHOW INDEXES FROM `products` WHERE Key_name = 'products_modelo_unique'"))->isNotEmpty();
        if (!$exists) {
            Schema::table('products', function (Blueprint $table) {
                $table->unique('modelo');
            });
        }
    }
};

