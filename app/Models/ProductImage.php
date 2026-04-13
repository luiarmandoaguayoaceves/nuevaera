<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'path',
        'alt',
        'is_primary',
        'orden',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    // Le decimos a Laravel que SIEMPRE adjunte el atributo dinámico 'url' al exportar a JSON o Array
    protected $appends = ['url'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // app/Models/ProductImage.php

    public function getUrlAttribute()
    {
        // Si la ruta ya es una URL completa de internet, la dejamos pasar
        if (filter_var($this->path, FILTER_VALIDATE_URL)) {
            return $this->path;
        }

        // Retornamos la ruta SIEMPRE apuntando a la carpeta /img/ que está en public
        // Esto arreglará el error de la captura
        return asset('img/' . $this->path);
    }

    public function scopeOrdered($q)
    {
        return $q->orderBy('orden');
    }
}
