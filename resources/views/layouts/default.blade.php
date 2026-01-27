<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <!-- Estilos y scripts -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css'])
    <title>@yield('title', 'Mi App')</title>
</head>
<body>
    <div class="app-container">
        <!-- ================== SIDEBAR ================== -->
        @auth
        <button class="menu-toggle" id="menuToggle">☰</button>
        <aside class="sidebar">
        <div class="sidebar-user">  
            <img src="{{ Auth::user()->foto ?? asset('https://cdn.pixabay.com/photo/2024/02/26/19/39/monochrome-image-8598798_1280.jpg') }}" class="user-avatar">
            <div class="user-info">
                <span class="user-name">{{ Auth::user()->name }}</span>
                <span class="user-role">{{ Auth::user()->rol ?? 'Usuario' }}</span>
            </div>
            
        </div>
            <div class="sidebar-header">
                <img src="{{ asset('https://www.supergenericosdelvalle.com/wp-content/uploads/2023/12/Grupo-130.png') }}" alt="Logo" class="logo">
            </div>

            <ul class="sidebar-menu">


                @can('ver home')
                <li class="{{ request()->is('home') ? 'active' : '' }}">
                    <a href="{{ route('home') }}"><i class="fa-solid fa-house"></i> Home</a>
                </li>
                @endcan


                @can('ver usuarios')
                <li class="{{ request()->is('usuarios*') ? 'active' : '' }}">
                    <a href="{{ route('usuarios') }}"><i class="fa-solid fa-user"></i> Usuarios</a>
                </li>
                @endcan
                 
                @can('ver clientes')  
                <li class="{{ request()->is('clientes*') ? 'active' : '' }}">
                    <a href="{{ route('clientes') }}"><i class="fa-solid fa-users"></i> Clientes</a>
                </li>
                 @endcan

                 @can('ver empleados')
                <li class="{{ request()->is('empleados*') ? 'active' : '' }}">
                    <a href="{{ route('empleados') }}"><i class="fa-solid fa-user-tie"></i>Reportes de Empleados</a>
                </li>
                 @endcan
               

                @can('ver ruta')
               <li class="{{ request()->is('Ruta*') ? 'active' : '' }}">
                    <a href="{{ route('Ruta') }}"><i class="fa-solid fa-route"></i>Ruta</a>
                </li>
                @endcan
                
                @can('ver mensajeria')
                <li class="{{ request()->is('mensajeria*') ? 'active' : '' }}">
                    <a href="{{ route('mensajeria') }}"><i class="fa-solid fa-car"></i><i class="fa-solid fa-motorcycle"></i>Mensajeria</a>
                </li>
                @endcan

                @can('ver recorridos')
                <li class="{{ request()->is('recorrido*') ? 'active' : '' }}">
                    <a href="{{ route('recorrido') }}"><i class="fa-solid fa-car"></i><i class="fa-solid fa-motorcycle"></i>Recorrido</a>
                </li>
                @endcan
      
                
    <form id="logout-form" action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="sidebar-logout">
            <i class="fa-solid fa-right-from-bracket"></i> Salir
        </button>
    </form>
</li>

            </ul>
        </aside>
         @endauth
    
    <!-- ================== CONTENIDO PRINCIPAL ================== -->
    <main class="content">
        <!-- Sección de header opcional -->
        @yield('header')

        <!-- Sección de contenido principal -->
        <div class="page-inner">
            @yield('maincontent')
        </div>

        <!-- Sección de footer opcional -->
        @yield('footer')
    </main>
  @vite([ 'resources/js/app.js'])
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
