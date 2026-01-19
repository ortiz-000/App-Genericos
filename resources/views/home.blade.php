@extends('layouts.default')

@section('header')


<div class="page-header text-center">
<div class="page-header text-center">
    <img src=" https://www.supergenericosdelvalle.com/wp-content/uploads/2023/12/Grupo-130.png" alt="Logo" class="img-fluid logo" style="max-width:150px;">
    <h2 class="mt-2">HOME</h2>
</div>

   
@endsection

@section('maincontent')
    <!-- BUSCADOR -->
    <div class="search-container mb-3 d-flex flex-wrap">
        <input id="searchInput" type="text" placeholder="Buscar..." class="form-control flex-grow-1 mb-2 mb-md-0">
        <button class="btn btn-primary ms-md-2">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>
    </div>


    <!-- FORMULARIO PARA CARGAR EXCEL -->
    @can('asignar clientes')
        <form action="{{ route('clientes.import') }}" method="POST" enctype="multipart/form-data" class="mb-3">
            @csrf
            <label for="excel_file" class="form-label">Cargar archivo Excel</label>
            <input type="file" name="excel_file" id="excel_file" class="form-control" accept=".xlsx, .xls" required>
           <button type="submit" class="btn Excel">
                <i class="fa-solid fa-file-export"></i>EXCEL
            </button>

        </form>
    @endcan

    <!-- BOTÓN AGREGAR CLIENTE -->
    <div class="actions-container mb-3 text-end">
        <button type="button" class="btn btn-success Clienteadd">
            <i class="fa-solid fa-user-plus"></i>
        </button>
    </div>

<div class="table-responsive">
    <table id="miTabla" class="table table-striped table-hover">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th class="d-none d-md-table-cell">Dirección</th>
                <th>Ciudad</th>
                <th class="d-none d-md-table-cell">Teléfono</th>
                <th class="d-none d-md-table-cell">Empleado</th>
                <th>Estado de Evidencia</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->id }}</td>
                    <td>{{ $cliente->nombre }}</td>
                    <td class="d-none d-md-table-cell">{{ $cliente->direccion }}</td>
                    <td>{{ $cliente->ciudad }}</td>
                    <td class="d-none d-md-table-cell">{{ $cliente->telefono }}</td>
                    <td class="d-none d-md-table-cell">
                        {{ $cliente->empleado ? $cliente->empleado->id . ' - ' . $cliente->empleado->name : 'N/A' }}
                    </td>
                    <td class="text-center">
                        @if ($cliente->estado === 'VISITADO')
                            <span class="badge bg-success">Visitado</span>
                        @else
                            <span class="badge bg-warning text-dark">Pendiente</span>
                        @endif
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
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No hay clientes registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>



    <!-- MODAL AGREGAR CLIENTE -->
    <section class="modal" id="modalClientes">
        <div class="modal__container">
            <center><h1 class="modal__title">Agregar Cliente</h1></center>
            <form action="{{ route('clientes.store') }}" method="POST">
                @csrf

                <label>Nombre</label>
                <i class="fa-regular fa-user"></i>
                <input class="controls" type="text" name="nombre" placeholder="Ingrese el nombre" class="form-control mb-2" required>
                
                 <label>Dirección</label>
                 <i class="fa-solid fa-road"></i>
                <input class="controls" type="text" name="direccion" placeholder="Ingrese la dirección" class="form-control mb-2" required>

                 <label>Ciudad</label>
                 <i class="fa-solid fa-city"></i>
                <input class="controls" type="text" name="ciudad" placeholder="Ingrese la ciudad" class="form-control mb-2" required>

                 <label>Telefono</label>
                 <i class="fa-solid fa-phone"></i>
                <input class="controls" type="text" name="telefono" placeholder="Ingrese el teléfono" class="form-control mb-2" required>


                <div class="mt-2">
                    <button type="submit" class="btn Agregar">Agregar</button>
                    <a href="#" class="Cerrar-model">Cerrar</a>
                </div>
            </form>
        </div>
    </section>
    <!-- ALERTAS -->



    <!-------MODAL ENVIAR EVIDENCIA------->
    <section class="modal" id="modalEvidencia">
    <div class="modalContent">
        <center><h1 class="moda__title">EVIDENCIA</h1></center>

        <form action="{{ route('empleados.evidencia.store') }}" method="POST" enctype="multipart/form-data" id="formEvidencia">
            <!-- CSRF token si es Laravel -->
            @csrf

            <!-- Accesor Comercial -->
            <label>Accesor Comercial</label>
            <i class="fa-regular fa-address-card"></i>
            <input class="controls" type="text" name="accesor_comercial" value="{{ auth()->user()->name }}" readonly>

            <!-- Usuario -->
            <label>Email</label>
            <i class="fa-regular fa-envelope"></i>
            <input class="controls" type="email" name="usuario" value="{{ auth()->user()->email }}" readonly>

            <!-- Nombre del Establecimiento -->
            <label>Nombre del Establecimiento</label>
            <i class="fa-regular fa-building"></i>
            <input class="controls" type="text" name="nombre_establecimiento" id="nombre_establecimiento" required placeholder="Nombre de el Establecimiento">

            <!-- Ciudad del Establecimiento -->
            <label>Ciudad del Establecimiento</label>
            <i class="fa-solid fa-city"></i>
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
            <i class="fa-solid fa-camera"></i>
            <input type="file" name="foto_establecimiento" accept="image/*" capture="environment" required>


            <!-- Botón de envío -->
            <button type="submit" id="btnEnviarEvidencia" class="btn btn-primary mt-2">
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
