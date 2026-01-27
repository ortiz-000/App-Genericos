@extends('layouts.default')

@section('header')


<div class="page-header text-center">
    <img src="{{ asset('https://www.supergenericosdelvalle.com/wp-content/uploads/2023/12/Grupo-130.png') }}" alt="Logo" class="logo">
        <h2>Registro de Evidencias </h2>
    </div>

@endsection

@section('maincontent')

<div class="container mt-3">

    {{-- Filtros responsivos --}}
    <div class="row g-2 mb-3">
        <div class="col-12 col-md-4">
            <input type="text" id="filterVendedor" placeholder="Buscar Vendedor..." class="form-control">
        </div>
        <div class="col-12 col-md-4">
            <input type="text" id="filterCiudad" placeholder="Buscar Ciudad..." class="form-control">
        </div>
       <div class="col-12 col-md-4">
            <input type="date" id="filterFechaInicio" class="form-control" placeholder="Fecha inicio">
        </div>
        <div class="col-12 col-md-4">
            <input type="date" id="filterFechaFin" class="form-control" placeholder="Fecha fin">
        </div>

    </div>

    {{-- Tabla responsiva --}}
<div class="table-responsive">
    <table id="miTabla" class="table table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Asesor Comercial</th>
                <th class="d-none d-md-table-cell">Usuario</th>
                <th>Nombre</th>
                <th>Ciudad</th>
                <th>Ubicación</th>
                <th>Motivo</th>
                <th>Otro</th>
                <th>Foto</th>
                <th>Fecha</th>
                <th class="d-none d-md-table-cell">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($evidencias as $e)
                <tr>
                    <td>{{ $e->id }}</td>
                    <td>{{ $e->accesor_comercial }}</td>
                    <td class="d-none d-md-table-cell">{{ $e->usuario }}</td>
                    <td>{{ $e->nombre_establecimiento }}</td>
                    <td>{{ $e->ciudad_establecimiento }}</td>
                    <td>
                        <a href="{{ $e->ubicacion }}" 
                           class="btn btn-success btn-sm w-100" 
                           target="_blank">
                           Ver mapa
                        </a>
                    </td>
                    <td>{{ $e->motivo }}</td>
                    <td>{{ $e->otro }}</td>
                    <td>
                        @if($e->foto_establecimiento)
                            <img src="{{ asset('storage/' . $e->foto_establecimiento) }}"
                                 style="width: 60px; height: auto; border-radius: 5px;">
                        @else
                            <span class="text-muted">No foto</span>
                        @endif
                    </td>
                    <td> {{ $e->created_at }}</td>
                    <td class="d-none d-md-table-cell">
                        @can('eliminar reportes')
                        <form action="{{ route('empleados.reportes.destroy', $e->id) }}"
                              method="POST"
                              onsubmit="return confirm('¿Seguro que desea eliminar este reporte?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm w-100">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="11" class="text-center">No hay evidencias registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<!-- Alerta de envío -->
<div id="alerta" class="alerta">
    <div class="alerta-contenido">
        <p>Se envió correctamente</p>
        <button id="aceptarAlerta">Aceptar</button>
    </div>
</div>


</div>

@endsection

