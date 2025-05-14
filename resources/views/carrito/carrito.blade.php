@extends('layouts.app')

@section('catalogo')
    active-page
@endsection

@section('contenido')
<div class="container py-4">
    <h1>Mi Carrito de Compras</h1>

    @if($carrito->isEmpty())
        <div class="alert alert-info">
            Tu carrito está vacío.
        </div>
         <div class="text-center py-5">
        <a href="{{ route('index') }}" class="btn btn-primary mt-3">
            <i data-feather="arrow-left" class="me-1"></i> Regresar al Catálogo
        </a>
    </div>
    @else
        <table class="table table-bordered text-center align-middle">
            <thead class="table-light">
                <tr>
                    <th>Imagen</th>
                    <th>Producto</th>
                    <th>Precio Unitario</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp

                @foreach($carrito as $producto)
                    @php
                        $subtotal = $producto->precio * $producto->cantidad;
                        $total += $subtotal;
                    @endphp
                    <tr>
                        <td>
                            @if($producto->imagen)
                                <img src="{{ asset('storage/' . $producto->imagen) }}" width="60" alt="Producto">
                            @else
                                <img src="{{ asset('images/default-product.png') }}" width="60" alt="Sin imagen">
                            @endif
                        </td>
                        <td>{{ $producto->nombre }}</td>
                        <td>${{ number_format($producto->precio) }}</td>
                        <td>{{ $producto->cantidad }}</td>
                        <td>${{ number_format($subtotal) }}</td>
                        <td>
                            <form class="form-eliminar" action="{{ route('carrito.eliminar', $producto->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">
                                    <i data-feather="trash-2" class="me-1"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
            <tfoot>
                <tr class="table-light">
                    <td colspan="4" class="text-end fw-bold">Total:</td>
                    <td class="fw-bold">${{ number_format($total, 2) }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="mt-4 d-flex justify-content-between flex-wrap gap-2">
            <a href="{{ route('index') }}" class="btn btn-primary">
                <i data-feather="arrow-left" class="me-1"></i> Regresar al Catálogo
            </a>

            <div class="d-flex gap-2">
                <form class="form-eliminar" action="{{ route('carrito.vaciar') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">
                        <i data-feather="trash-2" class="me-1"></i> Vaciar Carrito
                    </button>
                </form>

                <form action="{{ route('carrito.finalizar') }}" method="POST">
                    @csrf
                    <button class="btn btn-success">
                        <i data-feather="check" class="me-1"></i> Finalizar Compra
                    </button>
                </form>
            </div>
        </div>
    @endif
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const forms = document.querySelectorAll('.form-eliminar');

    forms.forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault(); // Evita el envío automático

            Swal.fire({
                title: '¿Quieres eliminar?',
                text: "No podrás deshacer esta acción 🚫",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#198754', // verde Bootstrap
                cancelButtonColor: '#d33',     // rojo fuerte
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Sí, eliminar',
                reverseButtons: true,
                background: '#fefefe',
                customClass: {
                    popup: 'animated fadeInDown faster' // Animación suave
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Si confirma, envía el formulario
                }
            })
        });
    });
});
</script>
@endsection
