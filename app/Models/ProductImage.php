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

    // URL pública (requiere php artisan storage:link)
    public function getUrlAttribute()
    {
        $p = ltrim($this->path, '/');

        // URL completa
        if (Str::startsWith($p, ['http://', 'https://'])) return $this->path;

        // Rutas dentro de /public
        if (Str::startsWith($p, ['img/', 'public/img/'])) {
            $p = Str::after($p, 'public/'); // limpia 'public/' si viniera
            return asset($p);               // => /img/galeria/...
        }

        // Default: disk 'public' (storage:link)
        return Storage::url($p);            // => /storage/...
    }

    public function scopeOrdered($q)
    {
        return $q->orderBy('orden');
    }
}
