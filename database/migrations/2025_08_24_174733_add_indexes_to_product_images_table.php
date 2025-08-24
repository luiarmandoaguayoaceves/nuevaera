<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_images', function (Blueprint $table) {
            // Índice para listar por producto y ordenar por 'orden'
            $table->index(['product_id', 'orden'], 'pi_product_orden_idx');

            // Índice para encontrar rápido la imagen principal de un producto
            $table->index(['product_id', 'is_primary'], 'pi_product_primary_idx');
        });
    }

    public function down(): void
    {
        Schema::table('product_images', function (Blueprint $table) {
            $table->dropIndex('pi_product_orden_idx');
            $table->dropIndex('pi_product_primary_idx');
        });
    }
};
