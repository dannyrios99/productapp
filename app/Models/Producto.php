<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos'; // ← Indicas que la tabla se llama productos
    protected $fillable = ['nombre', 'precio', 'descripcion', 'imagen'];
}
