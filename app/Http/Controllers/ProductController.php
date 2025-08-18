<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $q         = trim((string) $request->q);
        $categoria = (string) $request->categoria;
        $talla     = (string) $request->talla;

        $query = Product::with(['images','category'])->where('activo', true);

        if ($q !== '') {
            $query->where(function($qq) use ($q) {
                $qq->where('modelo','like',"%{$q}%")
                   ->orWhere('nombre','like',"%{$q}%")
                   ->orWhere('descripcion','like',"%{$q}%");
            });
        }
        if ($categoria !== '') {
            $query->whereHas('category', fn($c) => $c->where('slug',$categoria)->orWhere('nombre',$categoria));
        }
        if ($talla !== '') {
            $query->whereJsonContains('tallas', (int)$talla);
        }

        $products   = $query->latest()->paginate(12)->withQueryString();
        $categorias = Category::orderBy('nombre')->get();
        $tallas     = [22,23,24,25,26,27];

        return view('productos.index', compact('products','categorias','tallas','q','categoria','talla'));
    }

    public function create()
    {
        $categorias = Category::orderBy('nombre')->get();
        return view('productos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'modelo'      => ['required','string','max:50','unique:products,modelo'],
            'nombre'      => ['nullable','string','max:120'],
            'descripcion' => ['nullable','string'],
            'precio'      => ['nullable','numeric','min:0'],
            'category_id' => ['nullable', Rule::exists('categories','id')],
            'tallas'      => ['nullable','array'],
            'tallas.*'    => ['integer','between:20,30'],
            'badge'       => ['nullable','string','max:40'],
            'imagenes'    => ['nullable','array'],
            'imagenes.*'  => ['image','mimes:jpg,jpeg,png,webp','max:4096'],
            'principal'   => ['nullable','integer'], // índice de la imagen principal
        ]);

        $product = Product::create([
            'category_id' => $data['category_id'] ?? null,
            'modelo'      => $data['modelo'],
            'nombre'      => $data['nombre'] ?? null,
            'descripcion' => $data['descripcion'] ?? null,
            'precio'      => $data['precio'] ?? null,
            'tallas'      => $data['tallas'] ?? [],
            'badge'       => $data['badge'] ?? null,
            'activo'      => true,
        ]);

        // Guardar imágenes (storage/app/public/products/{id}/...)
        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $idx => $file) {
                $path = $file->store("products/{$product->id}", 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'path'       => $path,
                    'alt'        => "Modelo {$product->modelo}",
                    'is_primary' => ((int)($data['principal'] ?? -1) === $idx),
                    'orden'      => $idx,
                ]);
            }
        }

        // Si ninguna quedó como principal, marca la primera
        if (!$product->images()->where('is_primary',true)->exists()) {
            $first = $product->images()->orderBy('orden')->first();
            if ($first) { $first->update(['is_primary'=>true]); }
        }

        return redirect()->route('productos.index')->with('ok','Producto creado');
    }

    public function edit(Product $producto)
    {
        $categorias = Category::orderBy('nombre')->get();
        $producto->load('images','category');
        return view('productos.edit', compact('producto','categorias'));
    }

    public function update(Request $request, Product $producto)
    {
        $data = $request->validate([
            'modelo'      => ['required','string','max:50', Rule::unique('products','modelo')->ignore($producto->id)],
            'nombre'      => ['nullable','string','max:120'],
            'descripcion' => ['nullable','string'],
            'precio'      => ['nullable','numeric','min:0'],
            'category_id' => ['nullable', Rule::exists('categories','id')],
            'tallas'      => ['nullable','array'],
            'tallas.*'    => ['integer','between:20,30'],
            'badge'       => ['nullable','string','max:40'],
            'imagenes'    => ['nullable','array'],
            'imagenes.*'  => ['image','mimes:jpg,jpeg,png,webp','max:4096'],
            'principal'   => ['nullable','integer'],
            'activo'      => ['boolean'],
        ]);

        $producto->update([
            'category_id' => $data['category_id'] ?? null,
            'modelo'      => $data['modelo'],
            'nombre'      => $data['nombre'] ?? null,
            'descripcion' => $data['descripcion'] ?? null,
            'precio'      => $data['precio'] ?? null,
            'tallas'      => $data['tallas'] ?? [],
            'badge'       => $data['badge'] ?? null,
            'activo'      => (bool)($data['activo'] ?? $producto->activo),
        ]);

        if ($request->hasFile('imagenes')) {
            $baseOrden = ($producto->images()->max('orden') ?? -1) + 1;
            foreach ($request->file('imagenes') as $i => $file) {
                $path = $file->store("products/{$producto->id}", 'public');
                ProductImage::create([
                    'product_id' => $producto->id,
                    'path'       => $path,
                    'alt'        => "Modelo {$producto->modelo}",
                    'is_primary' => false, // decidimos después
                    'orden'      => $baseOrden + $i,
                ]);
            }
        }

        // actualizar principal si vino índice
        if ($request->filled('principal')) {
            $producto->images()->update(['is_primary'=>false]);
            $img = $producto->images()->orderBy('orden')->skip((int)$data['principal'])->first();
            if ($img) { $img->update(['is_primary'=>true]); }
        }

        return back()->with('ok','Producto actualizado');
    }

    public function destroy(Product $producto)
    {
        // Esto borra también imágenes (por foreign key cascade)
        // Opcional: borrar archivos físicos
        foreach ($producto->images as $img) {
            Storage::disk('public')->delete($img->path);
        }
        $producto->delete();
        return redirect()->route('productos.index')->with('ok','Producto eliminado');
    }
}
