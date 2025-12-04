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
            <input type="text" id="filterCliente" placeholder="Buscar Cliente..." class="form-control">
        </div>
        <div class="col-12 col-md-4">
            <input type="text" id="filterCiudad" placeholder="Buscar Ciudad..." class="form-control">
        </div>
        <div class="col-12 col-md-4">
            <input type="date" id="filterFecha" class="form-control">
        </div>
    </div>

    {{-- Tabla responsiva --}}
    <div class="table-responsive">
        <table id="miTabla" class="table table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Accesor Comercial</th>
                    <th>Usuario</th>
                    <th>Nombre</th>
                    <th>Ciudad</th>
                    <th>Ubicación</th>
                    <th>Motivo</th>
                    <th>Otro</th>
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

                    <td>{{ $e->created_at }}</td>

                    <td>
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
                @endforeach
            </tbody>
        </table>
    </div>

</div>

@endsection

