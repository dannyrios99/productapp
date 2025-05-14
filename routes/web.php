<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\PedidoController;

Route::get('/', [ProductoController::class, 'index'])->name('index');

// Productos
Route::get('/productos', [ProductoController::class, 'productos'])->name('productos.productos');
Route::post('/productos/guardar', [ProductoController::class, 'guardar'])->name('productos.guardar');
Route::put('/productos/{id}/editar', [ProductoController::class, 'editar'])->name('productos.editar');
Route::delete('/productos/{id}/eliminar', [ProductoController::class, 'eliminar'])->name('productos.eliminar');

//carrito
Route::post('/agregar-al-carrito', [CarritoController::class, 'agregar'])->name('carrito.agregar');
Route::get('/carrito', [CarritoController::class, 'verCarrito'])->name('carrito.ver');
Route::delete('/carrito/eliminar/{id}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
Route::delete('/carrito/vaciar', [CarritoController::class, 'vaciar'])->name('carrito.vaciar');
Route::post('/carrito/finalizar', [CarritoController::class, 'finalizarCompra'])->name('carrito.finalizar');

// Pedidos
Route::get('/pedidos', [PedidoController::class, 'verPedidos'])->name('pedidos.ver');



