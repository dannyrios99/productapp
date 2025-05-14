<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>@yield('titulo') Mi Catálogo</title>

    <!-- CSS -->
    <link href="{{ asset('sb-admin/css/styles.css') }}" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">


    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
        .active-page {
            font-weight: bold;
            color: #0d6efd !important;
            background-color: rgba(13, 110, 253, 0.1);
            border-radius: 0.375rem;
        }
        /* Estilo de las tarjetas de productos */
        .product-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 0.75rem;
            overflow: hidden;
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }
    </style>
    
</head>

<body class="sb-nav-fixed">

    <!-- Top Navbar -->
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="{{ route('index') }}">Mi Catálogo</a>

        <!-- Sidebar Toggle -->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"><i data-feather="menu"></i></button>

        <!-- Search Bar -->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Buscar..." aria-label="Buscar..." />
                <button class="btn btn-primary" type="button"><i data-feather="search"></i></button>
            </div>
        </form>

        <!-- User Dropdown -->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i data-feather="user"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#">Configuración</a></li>
                    <li><a class="dropdown-item" href="#">Actividad</a></li>
                    <li><hr class="dropdown-divider" /></li>
                    <li><a class="dropdown-item" href="#">Cerrar sesión</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <div id="layoutSidenav">
        <!-- Sidebar -->
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <ul class="nav flex-column">
                        <li class="sb-sidenav-menu-heading">Principal</li>
                        <li class="nav-item">
                            <a class="nav-link @yield('catalogo')" href="{{ route('index') }}"><i data-feather="home" class="me-2"></i> Catalogo</a>
                        </li>

                        <li class="sb-sidenav-menu-heading">Gestion Inventario</li>
                        <li class="nav-item"><a class="nav-link @yield('inventario')" href="{{ route('productos.productos') }}">
                            <i data-feather="package" class="me-2"></i>Inventario</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @yield('pedidos')" href="{{ route('pedidos.ver') }}">
                                <i data-feather="clipboard" class="me-2"></i> Pedidos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                                <i data-feather="book-open" class="me-2"></i> Más opciones
                                <i data-feather="chevron-down" class="float-end"></i>
                            </a>
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                <ul class="nav flex-column ms-3">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Reportes</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Usuarios</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Conectado como:</div>
                    Administrador
                </div>
            </nav>
        </div>

        <!-- Contenido principal -->
        <div id="layoutSidenav_content">
            <main class="p-4">
                @yield('contenido')
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid text-center small">
                    &copy; 2025 Mi Catálogo
                </div>
            </footer>
        </div>
    </div>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- Tu script de SB Admin -->
    <script src="{{ asset('sb-admin/js/scripts.js') }}"></script>

    <!-- Activar Feather Icons -->
    <script>
        feather.replace()
    </script>

@yield('scripts')
<script>
    @if(session('success'))
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        });
    @endif

    @if(session('error'))
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: "{{ session('error') }}",
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        });
    @endif
</script>
</body>
</html>
