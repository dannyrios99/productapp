<title>Pedidos</title>

@extends('layouts.app')

@section('pedidos')
    active-page
@endsection

@section('contenido')
<div class="container py-4">
    <h1>Pedidos Recibidos</h1>

    @if($pedidos->isEmpty())
        <div class="alert alert-info">No hay pedidos todavía.</div>
    @else
        @foreach($pedidos as $pedido)
            <div class="card mb-4">
                <div class="card-header">
                    <strong>Pedido #{{ $pedido->id }}</strong>
                    <br>
                    Total: ${{ number_format($pedido->total, 2) }}
                    <br>
                    Fecha: {{ $pedido->created_at->format('d/m/Y H:i') }}
                </div>
                <div class="card-body">
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio unitario</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pedido->productos as $producto)
                                <tr>
                                    <td>{{ $producto->producto_nombre }}</td>
                                    <td>{{ $producto->cantidad }}</td>
                                    <td>${{ number_format($producto->precio, 2) }}</td>
                                    <td>${{ number_format($producto->precio * $producto->cantidad, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
