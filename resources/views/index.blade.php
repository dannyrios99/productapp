@extends('layouts.app')

@section('catalogo')
    active-page
@endsection

@section('titulo', 'Inicio')

@section('contenido')

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="text-center mb-4">Bienvenido al Catálogo de Productos</h1>
        <a href="{{ route('carrito.ver') }}" class="btn btn-outline-primary position-relative">
            <i data-feather="shopping-cart"></i> Ver Carrito
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-count">
                {{ $cantidadCarrito ?? 0 }}
            </span>
        </a>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach ($productos as $producto)
            <div class="col">
                <div class="card h-100 shadow-sm product-card">
                    @if($producto->imagen)
                        <img src="{{ asset('storage/' . $producto->imagen) }}" class="card-img-top" alt="{{ $producto->nombre }}" style="object-fit: contain; height: 200px;">
                    @else
                        <!-- Imagen por defecto si no tiene imagen -->
                        <img src="{{ asset('images/default-product.png') }}" class="card-img-top" alt="Producto sin imagen" style="object-fit: cover; height: 200px;">
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-primary">{{ $producto->nombre }}</h5>
                        <div class="mt-auto d-flex flex-column gap-2">
                            <h6 class="fw-bold">${{ number_format($producto->precio) }}</h6>
                            <div class="d-grid gap-2">
                                <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#productoModal{{ $producto->id }}">
                                    <i data-feather="info" class="me-1"></i> Ver más
                                </button>
                                <button class="btn btn-success btn-sm add-to-cart" data-id="{{ $producto->id }}" data-product="{{ $producto->nombre }}">
                                    <i data-feather="shopping-cart" class="me-1"></i> Añadir al carrito
                                </button>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal del producto -->
            <div class="modal fade" id="productoModal{{ $producto->id }}" tabindex="-1" aria-labelledby="productoModalLabel{{ $producto->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="productoModalLabel{{ $producto->id }}">{{ $producto->nombre }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Descripción:</strong></p>
                            <p>{{ $producto->descripcion }}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

        @endforeach
    </div>

</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        feather.replace();

        const addToCartButtons = document.querySelectorAll('.add-to-cart');

        addToCartButtons.forEach(button => {
            button.addEventListener('click', function () {
                const productId = this.getAttribute('data-id');
                const productName = this.getAttribute('data-product');

                fetch('{{ route('carrito.agregar') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ producto_id: productId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // ✅ Mostrar alerta de añadido
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: `"${productName}" añadido al carrito`,
                            showConfirmButton: false,
                            timer: 1500,
                            timerProgressBar: true
                        });

                        // 🔥 Actualizar contador del carrito
                        const cartBadge = document.querySelector('.cart-count');
                        if (cartBadge) {
                            let count = parseInt(cartBadge.textContent) || 0;
                            cartBadge.textContent = count + 1;
                        }

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'No se pudo añadir al carrito'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un problema al añadir al carrito'
                    });
                });
            });
        });
    });
</script>
@endsection

