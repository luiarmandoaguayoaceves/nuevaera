<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imagenes extends Model
{
    use HasFactory;
    protected $table = 'imagenes';
    protected $primaryKey = 'id';
    protected $connection = 'mysql';

    protected $fillable = ['nombre'];
}
