<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('categories')) return;

        $col = DB::selectOne("SELECT IS_NULLABLE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME='categories' AND COLUMN_NAME='slug'");
        if ($col && strtoupper($col->IS_NULLABLE) === 'NO') {
            DB::statement("ALTER TABLE `categories` MODIFY COLUMN `slug` VARCHAR(255) NULL");
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('categories')) return;
        // Revertir a NOT NULL solo si estaba así antes (opcional). Lo dejamos sin cambio para no romper datos.
    }
};

