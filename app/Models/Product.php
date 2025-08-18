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

    protected $fillable = ['category_id','modelo','nombre','descripcion','precio','tallas','badge','activo'];
    protected $casts = ['tallas' => 'array', 'activo' => 'boolean', 'precio'=>'decimal:2'];

    public function category() { return $this->belongsTo(Category::class); }
    public function images()   { return $this->hasMany(ProductImage::class)->orderBy('orden'); }

    public function getImagenPrincipalAttribute()
    {
        $img = $this->images()->where('is_primary', true)->first() ?? $this->images()->first();
        return $img?->path ? Storage::url($img->path) : null;
    }
}
