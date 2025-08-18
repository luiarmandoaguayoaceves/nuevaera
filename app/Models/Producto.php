<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;


    public function imagenes()
{
    return $this->hasMany(ProductoImagen::class);
}

// Si usas JSON en columna 'tallas' y quieres casteo:
protected $casts = [
    'tallas' => 'array',
];

// Accessor opcional para imagen
public function getImagenUrlAttribute()
{
    return $this->attributes['imagen_url']
        ?? optional($this->imagenes()->first())->url
        ?? null;
}

}
