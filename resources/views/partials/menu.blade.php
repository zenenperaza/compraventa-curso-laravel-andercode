<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="index.html" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="index.html" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="50">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="30" style="margin-top: 25px;">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">

                <li class="menu-title"><span>Dashboard</span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('dashboard') }}">
                        <i class="ri-window-line"></i> <span>Dashboard</span>
                    </a>
                </li>

                @if (Auth::check() && in_array(Auth::user()->role->name, ['Administrador','Mantenedor']))

                    <li class="menu-title"><span>Mantenimiento</span></li>

                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('categorias.index') }}">
                            <i class="ri-honour-line"></i> <span>Categoria</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link menu-link" href="">
                            <i class="ri-honour-line"></i> <span>Producto</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('customers.index') }}">
                            <i class="ri-honour-line"></i> <span>Cliente</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('suppliers.index') }}">
                            <i class="ri-honour-line"></i> <span>Proveedor</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('users.index') }}">
                            <i class="ri-honour-line"></i> <span>Usuario</span>
                        </a>
                    </li>

                @endif

                @if (Auth::check() && in_array(Auth::user()->role->name, ['Administrador','Comprador']))

                    <li class="menu-title"><span>Compra</span></li>

                    <li class="nav-item">
                        <a class="nav-link menu-link" href="">
                            <i class="ri-sword-line"></i> <span>Listado Compras</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link menu-link" href="">
                            <i class="ri-sword-line"></i> <span>Nueva Compra</span>
                        </a>
                    </li>

                @endif

                @if (Auth::check() && in_array(Auth::user()->role->name, ['Administrador','Vendedor']))

                    <li class="menu-title"><span>Ventas</span></li>

                    <li class="nav-item">
                        <a class="nav-link menu-link" href="">
                            <i class="ri-aliens-line"></i> <span>Listado Ventas</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link menu-link" href="">
                            <i class="ri-aliens-line"></i> <span>Nueva Venta</span>
                        </a>
                    </li>

                @endif

                @if (Auth::check() && in_array(Auth::user()->role->name, ['Administrador','Almacen']))

                    <li class="menu-title"><span>Inventario</span></li>

                    <li class="nav-item">
                        <a class="nav-link menu-link" href="">
                            <i class="ri-filter-line"></i> <span>Listado Inventario</span>
                        </a>
                    </li>

                @endif

                @if (Auth::check() && in_array(Auth::user()->role->name, ['Administrador','Analista']))

                    <li class="menu-title"><span>Transaccion</span></li>

                    <li class="nav-item">
                        <a class="nav-link menu-link" href="">
                            <i class="ri-money-dollar-circle-line"></i> <span>Listado Transaccion</span>
                        </a>
                    </li>

                @endif

            </ul>
        </div>
    </div>

    <div class="sidebar-background"></div>
</div>
