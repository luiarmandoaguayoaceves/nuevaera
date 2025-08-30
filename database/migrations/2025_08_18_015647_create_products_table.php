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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('modelo');           // p.ej. 1030
            $table->string('nombre')->nullable();         // opcional: “Sandalia Roma”
            $table->text('descripcion')->nullable();
            $table->decimal('precio', 10, 2)->nullable(); // si no lo publicas, déjalo null
            $table->json('tallas')->nullable();           // p.ej. [22,23,24]
            $table->string('badge')->nullable();          // “Nuevo”, “Oferta”, etc.
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
