<?php

namespace App\Http\Controllers;


use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    // Vista pública
    public function index()
    {
        $productos = Product::with(['images' => fn($q) => $q->orderBy('orden'), 'category'])
            ->where('activo', true)
            ->latest()
            ->paginate(12);


        $categorias = Category::orderBy('nombre')->get();
        $tallas     = [22, 23, 24, 25, 26, 27];

        return view('gallery.index', compact('productos', 'categorias', 'tallas'));
    }

    // Vista admin
    public function admin()
    {
        $productos = Product::with(['images' => fn($q) => $q->orderBy('orden'), 'category'])
            ->latest()
            ->paginate(20);

        $categorias = Category::orderBy('nombre')->get();

        $ultimo = Product::max('modelo');
        $siguienteModelo = $ultimo ? (string)((int)$ultimo + 1) : '1000';

        return view('admin.galeria.index', compact('productos', 'categorias', 'siguienteModelo'));
    }

    // --- CRUD PRODUCTO ---

    public function storeProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'modelo'      => ['required', 'string', 'max:50'],
            'nombre'      => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'precio'      => ['nullable', 'numeric', 'min:0'],
            'tallas'      => ['nullable', 'string'],
            'badge'       => ['nullable', 'string', 'max:50'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'activo'      => ['required', 'in:0,1'],
            'files.*'     => ['nullable', 'image', 'max:5120'],
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Por favor corrige los errores en el formulario.');
        }

        $data = $validator->validated();
        $data['tallas'] = $this->parseTallas($data['tallas'] ?? '');
        $data['activo'] = (bool) $data['activo'];

        $product = Product::create($data);

        if ($request->hasFile('files')) {
            $i = 0;
            foreach ($request->file('files') as $file) {
                $path = $file->store('galeria', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'path'       => $path,
                    'alt'        => $product->nombre,
                    'is_primary' => $i === 0,
                    'orden'      => $i + 1,
                ]);
                $i++;
            }
        }

        return back()->with('ok', 'Producto creado');
    }

    public function updateProduct(Request $request, Product $product)
    {
        $data = $request->validate([
            'modelo'      => ['required', 'string', 'max:50'],
            'nombre'      => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'precio'      => ['nullable', 'numeric', 'min:0'],
            'tallas'      => ['nullable', 'string'], // "22,23,24"
            'badge'       => ['nullable', 'string', 'max:50'],
            'category_id' => ['required', 'exists:categories,id'], // <- requerido
            'activo'      => ['required', 'in:0,1'],
            'files.*'     => ['nullable', 'image', 'max:5120'],
        ]);


        $data['tallas'] = $this->parseTallas($data['tallas'] ?? '');
        $data['activo'] = (bool) $data['activo'];

        $product->update($data);

        return back()->with('ok', 'Producto actualizado');
    }

    public function toggleProduct(Product $product)
    {
        $product->activo = !$product->activo;
        $product->save();

        return back()->with('ok', 'Estado actualizado');
    }

    public function destroyProduct(Product $product)
    {
        // borra archivos físicos
        foreach ($product->images as $img) {
            if ($img->path && Storage::disk('public')->exists($img->path)) {
                Storage::disk('public')->delete($img->path);
            }
        }
        $product->delete();
        return back()->with('ok', 'Producto eliminado');
    }

    // --- IMÁGENES ---

    public function uploadImages(Request $request, Product $product)
    {
        $request->validate([
            'files.*' => ['required', 'image', 'max:5120']
        ]);

        $ordenBase = (int) ($product->images()->max('orden') ?? 0);
        $i = 0;
        foreach ($request->file('files') as $file) {
            $path = $file->store('galeria', 'public');
            ProductImage::create([
                'product_id' => $product->id,
                'path'       => $path,
                'alt'        => $product->nombre,
                'is_primary' => $product->images()->count() === 0 && $i === 0,
                'orden'      => $ordenBase + $i + 1,
            ]);
            $i++;
        }

        return back()->with('ok', 'Imágenes cargadas');
    }

    public function updateImage(Request $request, ProductImage $image)
    {
        $request->validate(['alt' => ['nullable', 'string', 'max:255']]);
        $image->update(['alt' => $request->input('alt')]);
        return back()->with('ok', 'ALT actualizado');
    }

    public function makePrimary(ProductImage $image)
    {
        DB::transaction(function () use ($image) {
            ProductImage::where('product_id', $image->product_id)->update(['is_primary' => false]);
            $image->update(['is_primary' => true]);
        });
        return back()->with('ok', 'Marcada como principal');
    }

    public function sortImages(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'images'     => ['required', 'array'],
            'images.*.id'    => ['required', 'exists:product_images,id'],
            'images.*.orden' => ['required', 'integer', 'min:1'],
        ]);

        DB::transaction(function () use ($data) {
            foreach ($data['images'] as $row) {
                ProductImage::where('id', $row['id'])
                    ->where('product_id', $data['product_id'])
                    ->update(['orden' => $row['orden']]);
            }
        });

        return response()->json(['ok' => true]);
    }

    public function destroyImage(ProductImage $image)
    {
        $pid = $image->product_id;
        if ($image->path && Storage::disk('public')->exists($image->path)) {
            Storage::disk('public')->delete($image->path);
        }
        $wasPrimary = $image->is_primary;
        $image->delete();

        if ($wasPrimary) {
            $next = ProductImage::where('product_id', $pid)->orderBy('orden')->first();
            if ($next) $next->update(['is_primary' => true]);
        }

        return back()->with('ok', 'Imagen eliminada');
    }

    // --- helper ---
    private function parseTallas(string $csv): array
    {
        if ($csv === '') return [];
        return collect(explode(',', $csv))
            ->map(fn($v) => trim($v))
            ->filter(fn($v) => $v !== '')
            ->map(fn($v) => (int)$v)
            ->values()
            ->all();
    }

    public function replaceImage(Request $request, ProductImage $image)
    {
        $data = $request->validate([
            'file' => ['required', 'image', 'max:5120'], // 5 MB
            'alt'  => ['nullable', 'string', 'max:255'],
        ]);

        // Subir nueva
        $newPath = $request->file('file')->store('galeria', 'public');

        // Borrar antigua si está en el disk public (no borra URLs externas)
        if ($image->path && Storage::disk('public')->exists($image->path)) {
            Storage::disk('public')->delete($image->path);
        }

        // Actualizar registro
        $image->update([
            'path' => $newPath,
            'alt'  => $data['alt'] ?? $image->alt,
        ]);

        return back()->with('ok', 'Imagen reemplazada');
    }
}
