<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = ['product_id','path','alt','is_primary','orden'];

    public function product() { return $this->belongsTo(Product::class); }

    public function getUrlAttribute()
    {
        return Storage::url($this->path);
    }
}

