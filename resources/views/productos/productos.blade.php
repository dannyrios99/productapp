@extends('layouts.app')

@section( 'Productos')

@section('inventario')
    active-page
@endsection

@section('contenido')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="text-primary">Catálogo de Productos</h1>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crearProductoModal">
        Agregar Producto
    </button>
</div>

{{-- Tabla de productos --}}
<div class="card shadow-sm">
    <div class="card-body">
        <table id="tablaProductos" class="table table-hover align-middle">
            <thead class="table-primary">
                <tr>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Descripción</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $producto)
                    <tr>
                        <td>{{ $producto->nombre }}</td>
                        <td>${{ number_format($producto->precio, 2) }}</td>
                        <td>{{ $producto->descripcion }}</td>
                        <td class="text-center">
                            <!-- Botón Editar -->
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editarProductoModal{{ $producto->id }}">
                                <i data-feather="edit" class="text-white"></i>
                            </button>
                            <!-- Botón Eliminar -->
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#eliminarProductoModal{{ $producto->id }}">
                                <i data-feather="trash-2"></i>
                            </button>
                        </td>
                    </tr>

                    <!-- Modal Editar Producto -->
                    <div class="modal fade" id="editarProductoModal{{ $producto->id }}" tabindex="-1" aria-labelledby="editarProductoModalLabel{{ $producto->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('productos.editar', $producto->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editarProductoModalLabel{{ $producto->id }}">Editar Producto</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Nombre</label>
                                            <input type="text" class="form-control" name="nombre" value="{{ $producto->nombre }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Precio</label>
                                            <input type="text" class="form-control" name="precio" value="{{ $producto->precio }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Descripción</label>
                                            <textarea class="form-control" name="descripcion">{{ $producto->descripcion }}</textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-success">Actualizar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Eliminar Producto -->
                    <div class="modal fade" id="eliminarProductoModal{{ $producto->id }}" tabindex="-1" aria-labelledby="eliminarProductoModalLabel{{ $producto->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('productos.eliminar', $producto->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title" id="eliminarProductoModalLabel{{ $producto->id }}">Eliminar Producto</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                    </div>
                                    <div class="modal-body">
                                        ¿Estás seguro de que deseas eliminar el producto <strong>{{ $producto->nombre }}</strong>?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Crear Producto -->
<div class="modal fade" id="crearProductoModal" tabindex="-1" aria-labelledby="crearProductoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('productos.guardar') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="crearProductoModalLabel">Agregar Nuevo Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Precio</label>
                        <input type="text" class="form-control" name="precio" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea class="form-control" name="descripcion"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="imagen" class="form-label">Imagen del Producto</label>
                        <input type="file" class="form-control" name="imagen" id="imagen" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Producto</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- SweetAlert2 para mensajes de éxito --}}
@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: '{{ session('success') }}',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Aceptar'
    })
</script>
@endif
@endsection
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        feather.replace(); // (esto ya lo tienes)

        // Mostrar alerta si se acaba de crear un producto exitosamente
        @if(session('success'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: '{{ session('success') }}', // Muestra el texto "Producto creado exitosamente"
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true
            });
        @endif
    });
</script>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#tablaProductos').DataTable({
            language: {
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "No se encontraron resultados",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(filtrado de _MAX_ registros totales)",
                "search": "Buscar:",
                "paginate": {
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            }
        });
    });
</script>
