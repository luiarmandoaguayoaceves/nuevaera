<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function galeria(Request $request)
    {
        $q         = trim((string) $request->input('q'));
        $categoria = trim((string) $request->input('categoria'));
        $talla     = trim((string) $request->input('talla'));

        $query = Producto::query()
            ->with(['imagenes' /*, 'tallas' */]); // ajusta a tus relaciones reales

        // Búsqueda por modelo/nombre
        if ($q !== '') {
            $query->where(function ($qq) use ($q) {
                $qq->where('modelo', 'like', "%{$q}%")
                   ->orWhere('nombre', 'like', "%{$q}%")
                   ->orWhere('color', 'like', "%{$q}%");
            });
        }

        // Categoría (columna o relación). Ajusta el campo si usas relación.
        if ($categoria !== '') {
            $query->where('categoria', $categoria);
        }

        // Talla (dos alternativas, comenta la que no uses):
        if ($talla !== '') {
            $n = (int) $talla;

            // a) Si tienes una columna JSON `tallas` (por ej. [22,23,24]):
            $query->whereJsonContains('tallas', $n);

            // b) Si tienes relación many-to-many `tallas` con pivot:
            // $query->whereHas('tallas', fn($qq) => $qq->where('numero', $n));
        }

        // Paginación (12 por página) y conteo total (para el “Mostrando … de …”)
        $productos = $query->latest()->paginate(12)->withQueryString();
        $total     = (clone $query)->count(); // si quieres el total filtrado
        // Si quieres total SIN filtros, usa Producto::count()

        // catálogo de categorías y tallas que mostrarás en filtros (llénalos desde BD si prefieres)
        $categorias = ['sandalia','tacón','casual','confort'];
        $tallas     = [22,23,24,25,26,27];

        $wa = config('services.whatsapp_sales');

        return view('galeria.index', compact('productos','total','categorias','tallas','q','categoria','talla','wa'));
    }
}
