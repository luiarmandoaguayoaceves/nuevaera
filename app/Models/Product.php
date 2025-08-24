<?php

namespace App\Models;

use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'modelo', 'nombre', 'descripcion', 'precio', 'tallas', 'badge', 'activo'];
    protected $casts = ['tallas' => 'array', 'activo' => 'boolean', 'precio' => 'decimal:2'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function images()
    {
        return $this->hasMany(\App\Models\ProductImage::class)->orderBy('orden');
    }

    public function getImagenPrincipalAttribute()
    {
        $img = $this->images()->where('is_primary', true)->first()
            ?? $this->images()->orderBy('orden')->first();

        return $img?->url; // gracias al accesor del modelo
    }
}
