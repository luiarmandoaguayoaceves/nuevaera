<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    // PÚBLICO
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

    // ADMIN
    public function admin()
    {
        $productos = Product::with(['images' => fn($q) => $q->orderBy('orden'),'category'])
            ->latest()
            ->paginate(20);

        return view('admin.galeria.index', compact('productos'));
    }

    public function updateProduct(Request $request, Product $product)
    {
        $data = $request->validate([
            'modelo'      => ['required','string','max:100'],
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

    // SUBIDA MÚLTIPLE: usa alt y orden incremental
    public function uploadImages(Request $request, Product $product)
    {
        $request->validate([
            'files.*' => ['required','image','mimes:jpg,jpeg,png,webp,avif','max:5120'],
        ], ['files.*.image' => 'Cada archivo debe ser una imagen válida.']);

        $uploaded = [];
        $currentMax = (int) ($product->images()->max('orden') ?? 0);

        foreach ($request->file('files', []) as $file) {
            $path = $file->store('productos', 'public');
            $alt  = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME); // default legible
            $orden = ++$currentMax;

            $img = $product->images()->create([
                'path'       => $path,
                'alt'        => $alt,
                'is_primary' => $product->images()->count() === 0,
                'orden'      => $orden,
            ]);

            $uploaded[] = $img;
        }

        if ($request->wantsJson()) {
            return response()->json(['ok' => true, 'images' => $uploaded, 'base_url' => asset('storage')]);
        }

        return back()->with('ok', 'Imágenes subidas.');
    }

    // EDITAR ALT (y opcionalmente reorden individual)
    public function updateImage(Request $request, ProductImage $image)
    {
        $data = $request->validate([
            'alt'   => ['nullable','string','max:255'],
            'orden' => ['nullable','integer','min:0'],
        ]);

        $image->update($data);

        return back()->with('ok', 'Imagen actualizada.');
    }

    public function destroyImage(ProductImage $image)
    {
        $product = $image->product;

        if ($image->path && Storage::disk('public')->exists($image->path)) {
            Storage::disk('public')->delete($image->path);
        }
        $image->delete();

        if ($product && !$product->images()->where('is_primary', true)->exists()) {
            $next = $product->images()->orderBy('orden')->first();
            if ($next) $next->update(['is_primary' => true]);
        }

        return back()->with('ok', 'Imagen eliminada.');
    }

    public function makePrimary(ProductImage $image)
    {
        $product = $image->product;
        $product->images()->update(['is_primary' => false]);
        $image->update(['is_primary' => true]);

        return back()->with('ok', 'Imagen principal actualizada.');
    }

    // arrastrar y soltar
    // payload: images: [{id: 10, orden:1}, ...]
    public function sortImages(Request $request)
    {
        $data = $request->validate([
            'images' => ['required','array'],
            'images.*.id'    => ['required','integer','exists:product_images,id'],
            'images.*.orden' => ['required','integer','min:0'],
        ]);

        foreach ($data['images'] as $i) {
            ProductImage::where('id', $i['id'])->update(['orden' => $i['orden']]);
        }

        return response()->json(['ok' => true]);
    }
}
