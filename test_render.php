<?php
try {
    $productos = App\Models\Product::with(['images', 'category'])->paginate(12);
    $categorias = App\Models\Category::all();
    $tallas = [22, 23, 24];
    $view = view('gallery.index', compact('productos', 'categorias', 'tallas'))->render();
    echo "Render successful\n";
} catch (\Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo $e->getFile() . ':' . $e->getLine() . "\n";
}
