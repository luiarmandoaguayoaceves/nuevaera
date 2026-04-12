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

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // app/Models/ProductImage.php

    public function getUrlAttribute()
    {
        // Si el path ya es una URL completa (http...), la regresamos tal cual
        if (filter_var($this->path, FILTER_VALIDATE_URL)) {
            return $this->path;
        }

        // Si el path contiene 'galeria/', significa que se subió por el administrador al storage
        if (str_contains($this->path, 'galeria/')) {
            return asset('storage/' . $this->path);
        }

        // De lo contrario, asumimos que es una imagen local en la carpeta public/img/
        return asset('img/' . $this->path);
    }

    public function scopeOrdered($q)
    {
        return $q->orderBy('orden');
    }
}
