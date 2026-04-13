<?php
$request = Illuminate\Http\Request::create('/admin/galeria/producto', 'POST', [
    'modelo' => '1234',
    'nombre' => 'Test Product',
    'precio' => '100.00',
    'category_id' => App\Models\Category::first()->id ?? 1,
    'tallas' => '22,23',
    'activo' => 1
]);
try {
    $response = app(App\Http\Controllers\GalleryController::class)->storeProduct($request);
    echo "Success: \n";
    print_r($response);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
