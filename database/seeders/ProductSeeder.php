<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Aseguramos que existan categorías
        $categorias = [
            'Sandalia',
            'Tacón',
            'Casual',
            'Confort',
        ];

        foreach ($categorias as $catName) {
            Category::firstOrCreate(
                ['nombre' => $catName],
                ['slug' => Str::slug($catName)]
            );
        }

        // Productos de ejemplo
        $productos = [
            [
                'modelo' => '1030',
                'nombre' => 'Tacón elegante negro',
                'descripcion' => 'Tacón clásico para vestir con estilo.',
                'precio' => 899,
                'tallas' => [23,24,25,26],
                'badge' => 'Nuevo',
                'categoria' => 'Tacón',
                'imagenes' => ['/img/galeria/1.jpeg'],
            ],
            [
                'modelo' => '1031',
                'nombre' => 'Sandalia de verano beige',
                'descripcion' => 'Perfecta para un look fresco.',
                'precio' => 799,
                'tallas' => [22,23,24],
                'badge' => null,
                'categoria' => 'Sandalia',
                'imagenes' => ['/img/galeria/2.jpeg'],
            ],
            [
                'modelo' => '1032',
                'nombre' => 'Casual urbano blanco',
                'descripcion' => 'Cómodo y moderno para uso diario.',
                'precio' => 849,
                'tallas' => [24,25,26],
                'badge' => 'Oferta',
                'categoria' => 'Casual',
                'imagenes' => ['/img/galeria/3.jpeg'],
            ],
            [
                'modelo' => '1033',
                'nombre' => 'Confort piel café',
                'descripcion' => 'Comodidad y estilo para cualquier ocasión.',
                'precio' => 899,
                'tallas' => [22,23,24,25],
                'badge' => 'Hecho en México',
                'categoria' => 'Confort',
                'imagenes' => ['/img/galeria/4.jpeg'],
            ],
            [
                'modelo' => '1034',
                'nombre' => 'Tacón rojo pasión',
                'descripcion' => 'Tacón llamativo para eventos especiales.',
                'precio' => 950,
                'tallas' => [23,24,25],
                'badge' => null,
                'categoria' => 'Tacón',
                'imagenes' => ['/img/galeria/5.jpeg'],
            ],
            [
                'modelo' => '1035',
                'nombre' => 'Sandalia dorada fiesta',
                'descripcion' => 'Sandalia brillante para fiestas.',
                'precio' => 999,
                'tallas' => [22,23,24,25,26],
                'badge' => 'Edición especial',
                'categoria' => 'Sandalia',
                'imagenes' => ['/img/galeria/6.jpeg'],
            ],
            [
                'modelo' => '1036',
                'nombre' => 'Casual deportivo gris',
                'descripcion' => 'Comodidad para el día a día.',
                'precio' => 749,
                'tallas' => [24,25,26,27],
                'badge' => null,
                'categoria' => 'Casual',
                'imagenes' => ['/img/galeria/7.jpeg'],
            ],
            [
                'modelo' => '1037',
                'nombre' => 'Confort negro premium',
                'descripcion' => 'Máxima suavidad y elegancia.',
                'precio' => 899,
                'tallas' => [23,24,25],
                'badge' => 'Más vendido',
                'categoria' => 'Confort',
                'imagenes' => ['/img/galeria/8.jpeg'],
            ],
            [
                'modelo' => '1038',
                'nombre' => 'Sandalia juvenil rosa',
                'descripcion' => 'Color vibrante para los días soleados.',
                'precio' => 699,
                'tallas' => [22,23,24],
                'badge' => null,
                'categoria' => 'Sandalia',
                'imagenes' => ['/img/galeria/9.jpeg'],
            ],
            [
                'modelo' => '1039',
                'nombre' => 'Tacón nude elegante',
                'descripcion' => 'Tacón neutro que combina con todo.',
                'precio' => 920,
                'tallas' => [23,24,25,26],
                'badge' => 'Nuevo',
                'categoria' => 'Tacón',
                'imagenes' => ['/img/galeria/10.jpeg'],
            ],
        ];

        foreach ($productos as $p) {
            $categoria = Category::where('nombre', $p['categoria'])->first();

            $producto = Product::create([
                'category_id' => $categoria->id,
                'modelo'      => $p['modelo'],
                'nombre'      => $p['nombre'],
                'descripcion' => $p['descripcion'],
                'precio'      => $p['precio'],
                'tallas'      => $p['tallas'],
                'badge'       => $p['badge'],
                'activo'      => true,
            ]);

            foreach ($p['imagenes'] as $i => $img) {
                ProductImage::create([
                    'product_id' => $producto->id,
                    'path'       => $img,
                    'is_primary' => $i === 0,
                    'orden'      => $i + 1,
                ]);
            }
        }
    }
}
