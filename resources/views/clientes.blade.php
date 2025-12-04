@extends('layouts.default')

@section('header')
    <div class="page-header text-center">
        <img src="{{ asset('https://www.supergenericosdelvalle.com/wp-content/uploads/2023/12/Grupo-130.png') }}" alt="Logo" class="logo">
        <h2>LISTA CLIENTES </h2>
    </div>
@endsection

@section('maincontent')
    <!-- ================== BUSCADOR ================== -->
    <div class="search-container mb-3">
        <input id="searchInput" type="text" placeholder="Buscar..." class="search-input">
        <button class="btn btn-search">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>
    </div>

    <!-- ================== TABLA DE CLIENTES ================== -->
    <div class="table-responsive">
        <table id="miTabla" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Ciudad</th>
                    <th>Teléfono</th>
                    <th>empleado_id</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clientes as $c)
                    <tr>
                        <td>{{ $c->id }}</td>
                        <td>{{ $c->nombre }}</td>
                        <td>{{ $c->direccion }}</td>
                        <td>{{ $c->ciudad }}</td>
                        <td>{{ $c->telefono }}</td>
                        <td>{{ $c->empleado_id ?? 'N/A' }}</td>

                        <td>
                            <!-- Botón Editar con datos dinámicos -->
                            <button class="btn-editar" 
                                data-id="{{ $c->id }}" 
                                data-nombre="{{ $c->nombre }}" 
                                data-direccion="{{ $c->direccion }}" 
                                data-ciudad="{{ $c->ciudad }}" 
                                data-telefono="{{ $c->telefono }}">
                                
                             <i class="fa-regular fa-pen-to-square"></i></button>

                            <!-- Botón Eliminar -->
                            <form action="{{ route('clientes.destroy', $c->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este cliente?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-borrar">
                                    <i class="fa-solid fa-trash"></i> 
                                </button>
                            </form>
                        </td>
                    </tr>     
                @endforeach
                
                <!-- Mensaje por defecto si no hay clientes -->
                @if($clientes->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center">No hay clientes registrados.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Modal para Editar Cliente -->
    <section class="modal" id="modalEditarCliente">
        <div class="modal__conatiner">
            <h1 modal__title>Editar Cliente</h1>

            <form id="Formedit" action="" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="id" id="edit_id">
                
                <label>Nombre</label>
                <input class="controls" type="text" name="nombre" id="edit_nombre" placeholder="Ingrese el nombre">

                <label>Dirección</label>
                <input class="controls" type="text" name="direccion" id="edit_direccion" placeholder="Ingrese la direccion">

                <label>Ciudad</label>
                <input class="controls" type="text" name="ciudad" id="edit_ciudad" placeholder="Ingrese la ciudad">

                <label>Teléfono</label>
                <input class="controls" type="text" name="telefono" id="edit_telefono" placeholder="Ingrese el teléfono">

                <div>
                    <button type="submit" class="btn btn-edit-user">Guardar cambios</button>
                    <a href="#" class="modal-close">Cerrar</a>
                </div>
            </form>
        </div>
    </section>
    
@endsection
