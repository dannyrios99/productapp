<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Carrito;
use App\Models\Pedido;
use App\Models\PedidoProducto;

class CarritoController extends Controller
{
    public function agregar(Request $request)
    {
        // 1. Recibir el ID del producto
        $productoId = $request->input('producto_id');

        // 2. Buscar el producto original en la tabla productos
        $producto = Producto::find($productoId);

        if (!$producto) {
            return response()->json(['success' => false, 'message' => 'Producto no encontrado']);
        }

        // 3. Buscar si ya existe en el carrito
        $carritoExistente = Carrito::where('producto_id', $productoId)->first();

        if ($carritoExistente) {
            // Si ya existe, aumentar cantidad
            $carritoExistente->cantidad += 1;
            $carritoExistente->save();
        } else {
            // Si no existe, crear nuevo
            Carrito::create([
                'producto_id' => $producto->id,
                'nombre' => $producto->nombre,
                'precio' => $producto->precio,
                'cantidad' => 1,
                'imagen' => $producto->imagen,
            ]);
        }

        // 4. Devolver respuesta
        return response()->json(['success' => true]);
    }

    public function verCarrito()
    {
        // 1. Traer todos los productos del carrito
        $carrito = Carrito::all();

        // 2. Pasarlos a la vista
        return view('carrito.carrito', compact('carrito'));
    }

    public function eliminar($id)
    {
        // Buscar el producto en el carrito por ID
        $producto = Carrito::find($id);

        if ($producto) {
            $producto->delete(); // Eliminar solo ese producto
        }

        return redirect()->route('carrito.ver')->with('success', 'Producto eliminado del carrito.');
    }

    public function vaciar()
    {
        Carrito::truncate(); // Borra todos los registros de la tabla carrito

        return redirect()->route('carrito.ver')->with('success', 'Carrito vaciado correctamente.');
    }

    public function finalizarCompra()
    {
        $carrito = Carrito::all();

        if ($carrito->isEmpty()) {
            return redirect()->route('carrito.ver')->with('error', 'Tu carrito está vacío.');
        }

        $total = 0;
        foreach ($carrito as $producto) {
            $total += $producto->precio * $producto->cantidad;
        }

        // Crear el pedido
        $pedido = Pedido::create([
            'nombre_cliente' => 'Cliente Anónimo', // opcional, si quieres pedirlo antes
            'total' => $total
        ]);

        // Asociar productos al pedido
        foreach ($carrito as $producto) {
            PedidoProducto::create([
                'pedido_id' => $pedido->id,
                'producto_nombre' => $producto->nombre,
                'cantidad' => $producto->cantidad,
                'precio' => $producto->precio
            ]);
        }

        // Vaciar carrito
        Carrito::truncate();

        return redirect()->route('index')->with('success', '¡Compra finalizada exitosamente!');
    }
}
