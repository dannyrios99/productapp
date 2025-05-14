<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PedidoProducto extends Model
{
    protected $fillable = ['pedido_id', 'producto_nombre', 'cantidad', 'precio'];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
}
