<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DemoCatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $cat = Category::firstOrCreate(['slug'=>'tacon'], ['nombre'=>'Tacón']);
    $p = Product::create([
        'category_id'=>$cat->id,
        'modelo'=>'1030',
        'nombre'=>'Tacón Roma',
        'precio'=>899,
        'tallas'=>[22,23,24,25],
        'badge'=>'Nuevo',
        'activo'=>true,
    ]);
    // si quieres, copia manualmente 1-2 imágenes a storage/app/public/products/{id}/ y crea ProductImage a mano
}
}
