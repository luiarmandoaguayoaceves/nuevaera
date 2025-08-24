<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class GalleryController extends Controller
{
    // VISTA PÚBLICA (igual a como la tienes)
    public function index()
    {
        $productos = Product::with(['images','category'])
            ->where('activo', true)
            ->latest()
            ->paginate(12);

        $categorias = ['sandalia','tacón','casual','confort'];
        $tallas     = [22,23,24,25,26,27];

        return view('gallery.index', compact('productos','categorias','tallas'));
    }

    // PANEL ADMIN
    public function admin()
    {
        $productos = Product::with(['images' => fn($q) => $q->orderBy('orden'),'category'])
            ->latest()
            ->paginate(20);

        $categorias = Category::orderBy('nombre')->get(['id','nombre']);
        $siguienteModelo = (string) (((int) (Product::max('modelo') ?? 1000)) + 1);

        return view('admin.galeria.index', compact('productos','categorias','siguienteModelo'));
    }

    // CREAR PRODUCTO (con opción de subir imágenes de una vez)
    public function storeProduct(Request $request)
    {
        $data = $request->validate([
            'modelo'      => ['required','string','max:100', 'unique:products,modelo'],
            'nombre'      => ['required','string','max:150'],
            'descripcion' => ['nullable','string','max:5000'],
            'precio'      => ['required','numeric','min:0','max:999999.99'],
            'tallas'      => ['nullable','string'], // "22,23,24"
            'badge'       => ['nullable','string','max:50'],
            'activo'      => ['required','boolean'],
            'category_id' => ['nullable','integer','exists:categories,id'],

            // opcional: subir imágenes en el mismo form
            'files.*'     => ['sometimes','image','mimes:jpg,jpeg,png,webp,avif','max:5120'],
        ]);

        $data['tallas'] = !empty($data['tallas'])
            ? collect(explode(',', $data['tallas']))->map(fn($t)=>trim($t))->filter()->values()->all()
            : [];

        $data['precio'] = number_format((float)$data['precio'], 2, '.', '');

        $product = Product::create($data);

        // Si enviaste imágenes en el form de creación
        if ($request->hasFile('files')) {
            $current = 0;
            foreach ($request->file('files', []) as $i => $file) {
                $path = $file->store('productos', 'public');
                $product->images()->create([
                    'path'       => $path,
                    'alt'        => $product->nombre.' '.($i+1),
                    'is_primary' => $i === 0,
                    'orden'      => ++$current,
                ]);
            }
        }

        return redirect()->route('admin.galeria.index')->with('ok', "Producto creado.");
    }

    // ACTUALIZAR PRODUCTO
    public function updateProduct(Request $request, Product $product)
    {
        $data = $request->validate([
            'modelo'      => ['required','string','max:100', Rule::unique('products','modelo')->ignore($product->id)],
            'nombre'      => ['required','string','max:150'],
            'descripcion' => ['nullable','string','max:5000'],
            'precio'      => ['required','numeric','min:0','max:999999.99'],
            'tallas'      => ['nullable','string'],
            'badge'       => ['nullable','string','max:50'],
            'activo'      => ['required','boolean'],
            'category_id' => ['nullable','integer','exists:categories,id'],
        ]);

        $data['tallas'] = !empty($data['tallas'])
            ? collect(explode(',', $data['tallas']))->map(fn($t)=>trim($t))->filter()->values()->all()
            : [];

        $data['precio'] = number_format((float)$data['precio'], 2, '.', '');

        $product->update($data);

        return back()->with('ok', "Producto #{$product->id} actualizado.");
    }

    // APAGAR / PRENDER (toggle activo)
    public function toggleProduct(Product $product)
    {
        $product->update(['activo' => !$product->activo]);
        return back()->with('ok', "Producto #{$product->id} " . ($product->activo ? 'activado' : 'desactivado') . '.');
    }

    // ELIMINAR PRODUCTO (borra imágenes físicas)
    public function destroyProduct(Product $product)
    {
        foreach ($product->images as $img) {
            if ($img->path && Storage::disk('public')->exists($img->path)) {
                Storage::disk('public')->delete($img->path);
            }
            $img->delete();
        }
        $product->delete();

        return back()->with('ok', 'Producto eliminado.');
    }

    // --- el resto de métodos de imágenes que ya tenías (uploadImages, updateImage, makePrimary, sortImages, destroyImage) ---
}
