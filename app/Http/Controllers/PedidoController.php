<?php

namespace App\Http\Controllers;
use App\Models\Pedido;

use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function verPedidos()
    {
        $pedidos = Pedido::with('productos')->orderBy('created_at', 'desc')->get();
        return view('pedidos.pedidos', compact('pedidos'));
    }
}
