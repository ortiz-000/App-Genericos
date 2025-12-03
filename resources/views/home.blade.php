@extends('layouts.default')

@section('header')


<div class="page-header text-center">
        <h2>HOME </h2>
    </div>
@endsection

@section('maincontent')
    <!-- BUSCADOR -->
     <div class="search-container mb-3">
        <input id="searchInput" type="text" placeholder="Buscar..." class="search-input">
        <button class="btn btn-search">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>
    </div>

    <!-- FORMULARIO PARA CARGAR EXCEL -->
    @can('asignar clientes')
        <form action="{{ route('clientes.import') }}" method="POST" enctype="multipart/form-data" class="mb-3">
            @csrf
            <label for="excel_file" class="form-label">Cargar archivo Excel</label>
            <input type="file" name="excel_file" id="excel_file" class="form-control" accept=".xlsx, .xls" required>
           <button type="submit" class="btn btn-primary mt-2">
                <i class="fa-regular fa-file-excel me-1"></i> Cargar Excel
            </button>

        </form>
    @endcan

    <!-- BOTÓN AGREGAR CLIENTE -->
    <div class="actions-container mb-3 text-end">
        <button type="button" class="btn btn-success Clienteadd">
            <i class="fa-regular fa-user"></i> Agregar Cliente
        </button>
    </div>

    <!-- TABLA DE CLIENTES -->
    <div class="table-responsive">
        <table id="miTabla" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Ciudad</th>
                    <th>Teléfono</th>
                    <th>empleado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clientes as $cliente)
                    <tr>
                        <td>{{ $cliente->id }}</td>
                        <td>{{ $cliente->nombre }}</td>
                        <td>{{ $cliente->direccion }}</td>
                        <td>{{ $cliente->ciudad }}</td>
                        <td>{{ $cliente->telefono }}</td>
                       <td>
                            {{ $cliente->empleado ? $cliente->empleado->id . ' - ' . $cliente->empleado->name : 'N/A' }}
                    </td>


                        <td>    
                           <button 
                                class="btn btn-evidencia"
                                data-nombre="{{ $cliente->nombre }}"
                                data-ciudad="{{ $cliente->ciudad }}">
                                <i class="fa-solid fa-paper-plane"></i>
                            </button>

                            <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que desea eliminar este cliente?')">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No hay clientes registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- MODAL AGREGAR CLIENTE -->
    <section class="modal" id="modalClientes">
        <div class="modal__container">
            <h1 class="modal__title">Agregar Cliente</h1>
            <form action="{{ route('clientes.store') }}" method="POST">
                @csrf
                <input class="controls" type="text" name="nombre" placeholder="Ingrese el nombre" class="form-control mb-2" required>
                <input class="controls" type="text" name="direccion" placeholder="Ingrese la dirección" class="form-control mb-2" required>
                <input class="controls" type="text" name="ciudad" placeholder="Ingrese la ciudad" class="form-control mb-2" required>
                <input class="controls" type="text" name="telefono" placeholder="Ingrese el teléfono" class="form-control mb-2" required>
                <div class="mt-2">
                    <button type="submit" class="btn btn-primary">Agregar</button>
                    <a href="#" class="modal-close btn btn-secondary">Cerrar</a>
                </div>
            </form>
        </div>
    </section>

    <!-------MODAL ENVIAR EVIDENCIA------->
    <section class="modal" id="modalEvidencia">
    <div class="modalContent">
        <h1 class="moda__title">EVIDENCIA</h1>

        <form action="{{ route('empleados.evidencia.store') }}" method="POST" enctype="multipart/form-data">
            <!-- CSRF token si es Laravel -->
            @csrf
            <!-- Accesor Comercial -->
            <label>Accesor Comercial</label>
            <input class="controls" type="text" name="accesor_comercial" value="{{ auth()->user()->name }}" readonly>

            <!-- Usuario -->
            <label>Usuario</label>
            <input class="controls" type="email" name="usuario" value="{{ auth()->user()->email }}" readonly>

            <!-- Nombre del Establecimiento -->
            <label>Nombre del Establecimiento</label>
            <input class="controls" type="text" name="nombre_establecimiento" id="nombre_establecimiento" required placeholder="Nombre de el Establecimiento">

            <!-- Ciudad del Establecimiento -->
            <label>Ciudad del Establecimiento</label>
            <input class="controls" type="text" name="ciudad_establecimiento" id="ciudad_establecimiento" required placeholder="Ciudad Donde se encuentra el Establecimiento">

            <!-- Ubicación (link) -->
            <input class="controls" type="hidden" name="ubicacion" id="ubicacion">

            <!-- Tipo de Visita -->
           <!-- Motivo -->
            <div class="col-md-6">
                <label for="motivo" class="form-label">Motivo</label>
                <select name="motivo" id="motivo" class="form-select" required>
                    <option value="">Seleccione...</option>
                    <option value="Venta exitosa">Venta exitosa</option>
                    <option value="Cobro exitoso">Cobro exitoso</option>
                    <option value="Cliente nuevo">Cliente nuevo</option>
                    <option value="Entrega de pedido">Entrega de pedido</option>
                    <option value="No satisfactorio">No satisfactorio</option>
                    <option value="Otro">Otro</option>
                </select>
            </div>

            <!-- Campo Otro (solo obligatorio si escogen "Otro") -->
            <div class="col-md-6" id="otro-container" style="display:none;">
                <label for="otro" class="form-label">Especificar</label>
                <input type="text" id="otro" name="otro" class="form-control">
            </div>

            <!-- Foto del Establecimiento -->
            <label>Foto del Establecimiento</label>
            <input type="file" name="foto_establecimiento" accept="image/*" capture="environment" required>


            <!-- Botón de envío -->
            <button type="submit" class="btn btn-primary mt-2">
                <i class="fa-regular fa-file-excel me-1"></i> Enviar Evidencia
            </button>

            <!-- Botón para cerrar modal -->
            <button type="button" class="btn btn-secondary mt-2" onclick="document.getElementById('modalEvidencia').style.display='none'">
                Cerrar
            </button>
        </form>
    </div>
</section>
@endsection
