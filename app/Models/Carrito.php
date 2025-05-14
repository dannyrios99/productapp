<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    protected $table = 'carrito'; 

    protected $fillable = [
        'producto_id', 'nombre', 'precio', 'cantidad', 'imagen',
    ];
}
