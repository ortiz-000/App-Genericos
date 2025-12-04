@extends('layouts.default')

@section('header')


<div class="page-header text-center">
    <img src="{{ asset('https://www.supergenericosdelvalle.com/wp-content/uploads/2023/12/Grupo-130.png') }}" alt="Logo" class="logo">
        <h2>Registro de Evidencias </h2>
    </div>

@endsection

@section('maincontent')
<div class="filter-container mb-3">
    <input type="text" id="filterCliente" placeholder="Buscar Cliente..." class="form-control mb-2">
    <input type="text" id="filterCiudad" placeholder="Buscar Ciudad..." class="form-control mb-2">
    <input type="date" id="filterFecha" class="form-control mb-2">
</div>

    {{-- <div class="search-container mb-3">
        <input id="searchInput" type="text" placeholder="Buscar..." class="search-input">
        <button class="btn btn-search">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>
    </div> --}}

<div class="container mt-4">

    <!-- Botón para abrir la modal -->

    <!-- Tabla de evidencias -->
    <div class="table-responsive">
        <table id="miTabla" class="table table-striped table-hover">
         <thead>
            <tr>
                <th>ID</th>
                <th>Accesor Comercial</th>
                <th>Usuario</th>
                <th>Nombre del Establecimiento</th>
                <th>Ciudad</th>
                <th>Ubicación</th>
                <th>motivo</th>
                <th>otro</th>
                <th>Foto</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach($evidencias as $e)
            <tr>
                <td>{{ $e->id }}</td>
                <td>{{ $e->accesor_comercial }}</td>
                <td>{{ $e->usuario }}</td>
                <td>{{ $e->nombre_establecimiento }}</td>
                <td>{{ $e->ciudad_establecimiento }}</td>

                <td>
                    <a href="{{ $e->ubicacion }}" target="_blank" class="btn btn-sm btn-success">
                        Ver mapa
                    </a>
                </td>

                <td>{{ $e->motivo }}</td>
                 <td>{{ $e->otro }}</td>

                <td>
                    @if($e->foto_establecimiento)
                       <img src="/storage/{{ $e->foto_establecimiento }}" width="60">



                    @else
                        No hay foto
                    @endif
                </td>
                <td>{{ $e->created_at }}</td>

                @can('eliminar reportes')
                    
             
                <td>
                    <form action="{{ route('empleados.reportes.destroy', $e->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que desea eliminar este reporte?')">
                            <i class="fa-solid fa-trash"></i> Borrar
                        </button>
                 @endcan
                    </form>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
