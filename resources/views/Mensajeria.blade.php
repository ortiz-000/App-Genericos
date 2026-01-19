@extends('layouts.default')

@section('header')
    <div class="page-header text-center">
        <img src=" https://www.supergenericosdelvalle.com/wp-content/uploads/2023/12/Grupo-130.png" alt="Logo" class="img-fluid logo" style="max-width:150px;">
        <h2 class="mt-2">MENSAJERIA</h2>
    </div>
    
@endsection


@section('maincontent')
    <div class="row g-2 mb-3">
    <!-- Buscar por usuario (vendedor o mensajero) -->
    <div class="col-12 col-md-4">
        <input type="text" id="filterUsuario" placeholder="Buscar Vendedor o Mensajero..." class="form-control">
    </div>

    <!-- Fecha inicio -->
    <div class="col-12 col-md-4">
        <input type="date" id="filterFechaInicio" class="form-control" placeholder="Fecha inicio">
    </div>

    <!-- Fecha fin -->
    <div class="col-12 col-md-4">
        <input type="date" id="filterFechaFin" class="form-control" placeholder="Fecha fin">
    </div>
</div>

    <h2 class="text-center">plan estratégico de seguridad vial, (PESV).</h2>
    <button
    id="abrirMoto"
    type="button"
    class="btn btn-moto"
>
    <i class="fa-solid fa-motorcycle"></i>
</button>

    <button id="abrirCarro" class="btn btn-carro"><i class="fa-solid fa-car"></i></button>


<div class="row mt-4">
@forelse ($inspecciones as $inspeccion)

    <div class="col-12 col-md-6 col-lg-4 mb-3">
        <div class="inspeccion-card"
        data-vendedor="{{ strtolower($inspeccion->user->name) }}"
    data-mensajero="{{ strtolower($inspeccion->mensajero) }}"
    data-fecha="{{ $inspeccion->fecha_inspeccion }}"
    data-hora="{{ $inspeccion->hora_inspeccion }}"
        
        
        >
            {{-- HEADER --}}
            <div class="card-header">
                <strong>
                    {{ $inspeccion->vehiculo === 'moto' ? '🏍️ Moto' : '🚗 Carro' }}
                </strong>

                <h5 class="text-muted d-block">
                    {{ $inspeccion->user->name }}
                </h5>

                <small>
                    {{ \Carbon\Carbon::parse($inspeccion->fecha_inspeccion)->format('d/m/Y') }}
                    -
                    {{ \Carbon\Carbon::parse($inspeccion->hora_inspeccion)->format('h:i A') }}
                </small>
            </div>

            {{-- BODY --}}
            <div class="card-body">
                <p><strong>Placa:</strong> {{ $inspeccion->placa }}</p>
                <p><strong>Ruta:</strong> {{ $inspeccion->ruta }}</p>
                <p><strong>Kilometraje:</strong> {{ number_format($inspeccion->kilometraje) }} km</p>
            </div>

            {{-- FOOTER --}}
            <div class="card-footer text-end">
               <button 
                    type="button"
                    class="btn btn-sm btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#modalDetalle{{ $inspeccion->id }}">
                    Ver detalles
                </button>

            </div>

        </div>
    </div>

    {{-- MODAL (AQUÍ MISMO) --}}
 <div class="modal fade" id="modalDetalle{{ $inspeccion->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Detalle de inspección</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

            <h6 class="text-primary mb-2">Información General</h6>
            <p><strong>Vehículo:</strong> {{ ucfirst($inspeccion->vehiculo) }}</p>
            <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($inspeccion->fecha_inspeccion)->format('d/m/Y') }}</p>
           <p><strong>Hora:</strong>
                {{ \Carbon\Carbon::parse($inspeccion->hora_inspeccion)->format('h:i A') }}
            </p>



            <hr>

            <h6 class="text-primary mb-2">Mensajero</h6>
            <p><strong>Nombre:</strong> {{ $inspeccion->mensajero }}</p>
            <p><strong>Condiciones:</strong> {{ $inspeccion->condiciones_conductor }}</p>

            <hr>

            <h6 class="text-primary mb-2">Vehículo</h6>
            <p><strong>Placa:</strong> {{ $inspeccion->placa }}</p>

            @if($inspeccion->placa_otro)
                <p><strong>Otra placa:</strong> {{ $inspeccion->placa_otro }}</p>
            @endif

            <p><strong>Kilometraje:</strong> {{ number_format($inspeccion->kilometraje) }} km</p>

            <p><strong>SOAT vence:</strong> {{ $inspeccion->vencimiento_soat }}</p>

            @if($inspeccion->vencimiento_tecnomecanica)
                <p><strong>Tecnomecánica vence:</strong> {{ $inspeccion->vencimiento_tecnomecanica }}</p>
            @endif

            <p><strong>Licencia vence:</strong> {{ $inspeccion->vencimiento_licencia }}</p>

            <hr>

            <h6 class="text-primary mb-2">Ruta</h6>
            <p><strong>Ruta:</strong> {{ $inspeccion->ruta }}</p>

            @if($inspeccion->ruta_otro)
                <p><strong>Otra ruta:</strong> {{ $inspeccion->ruta_otro }}</p>
            @endif

            <hr>

            <h6 class="text-primary mb-2">Elementos de Seguridad</h6>
           <ul class="list-unstyled">
                <li>Uniforme: {{ $inspeccion->uniforme === 'cumple' ? '✔' : '✘' }}</li>
                <li>Botas: {{ $inspeccion->botas === 'cumple' ? '✔' : '✘' }}</li>
                <li>Impermeable: {{ $inspeccion->impermeable === 'cumple' ? '✔' : '✘' }}</li>
                @if($inspeccion->vehiculo === 'carro')
                    <li>Cinturón: {{ $inspeccion->cinturon === 'cumple' ? '✔' : '✘' }}</li>
                @elseif($inspeccion->vehiculo === 'moto')
                    <li>Casco: {{ $inspeccion->casco === 'cumple' ? '✔' : '✘' }}</li>
                    <li>Chaleco: {{ $inspeccion->chaleco === 'cumple' ? '✔' : '✘' }}</li>
                @endif
            </ul>



            <hr>

            <h6 class="text-primary mb-2">Documentos</h6>

            @if(is_array($inspeccion->documentos))
                <ul>
                    @foreach ($inspeccion->documentos as $doc)
                        <li>{{ ucfirst($doc) }}</li>
                    @endforeach
                </ul>
            @else
                <p>No se registraron documentos.</p>
            @endif

        </div>


        </div>
    </div>
</div>


@empty
    <div class="col-12 text-center">
        <p class="text-muted">No hay inspecciones registradas.</p>
    </div>
@endforelse
</div>




<!-- Modal Inspección Moto -->
<div class="modal-custom" id="modalMoto">
    <div class="modal-content-custom">
        <div class="modal-header-custom">
            <h2> plan estratégico de seguridad vial, (PESV)</h2>
            <button type="button" class="btn-close-custom" id="cerrarModalMoto">
                &times;
            </button>
        </div>

        <div class="modal-body-custom">
            <!-- AQUÍ VA TU FORMULARIO -->
            <form action="{{ route('mensajeria.inspeccion.moto.store') }}" method="POST">
                @csrf
    <!-- Fecha y hora -->
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Fecha de inspección *</label>
            <input type="date" class="form-control" name="fecha_inspeccion" required>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Hora de inspección *</label>
            <input type="time" class="form-control" name="hora_inspeccion" required>
        </div>
    </div>

    <!-- Arranque -->
    <div class="mb-3">
        <label class="form-label">
            Arranque la moto, colóquela en neutro y déjela calentar durante 1 a 3 minutos (OBLIGATORIO). *
        </label>
        <select class="form-select" name="arranque_realizado" required>
            <option value="">Seleccione</option>
            <option value="si">Realizado</option>
        </select>
    </div>

    <!-- Mensajero -->
    <div class="mb-3">
        <label class="form-label">Conductor encargado</label>
        <div class="input-group">
            <span class="input-group-text">
                <i class="fa-regular fa-address-card"></i>
            </span>
            <input type="text"
                   class="form-control"
                   name="mensajero"
                   value="{{ auth()->user()->name }}"
                   readonly>
        </div>
    </div>
    <!-- Ruta -->
    <div class="mb-3">
        <label class="form-label">Ruta a realizar *</label>

        <div class="form-check">
            <input class="form-check-input" type="radio" name="ruta" value="Sur Valle" required>
            <label class="form-check-label">Sur del Valle</label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" name="ruta" value="Norte Valle">
            <label class="form-check-label">Norte del Valle</label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" name="ruta" value="Pereira">
            <label class="form-check-label">Pereira</label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" name="ruta" value="Quindio">
            <label class="form-check-label">Quindío</label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" name="ruta" value="Perifericas">
            <label class="form-check-label">Periféricas</label>
        </div>

        <input type="text" class="form-control mt-2" name="ruta_otro" placeholder="Otra ruta (opcional)">
    </div>

    <!-- Condiciones -->
    <div class="mb-3">
        <label class="form-label">¿Está en condiciones físicas y mentales para conducir? *</label>
        <select class="form-select" name="condiciones_conductor" required>
            <option value="">Seleccione</option>
            <option value="si">Sí</option>
            <option value="no">No</option>
        </select>
    </div>

    <!-- Placa -->
    <div class="mb-3">
        <label class="form-label">Placa de la motocicleta *</label>
        <select class="form-select" name="placa" required>
            <option value="">Seleccione</option>
            <option value="LKZ24F">LKZ24F</option>
            <option value="KPT26G">KPT26G</option>
        </select>
        <input type="text" class="form-control mt-2" name="placa_otro" placeholder="Otra placa (opcional)">
    </div>

    <!-- Fechas documentos -->
    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label">Vencimiento SOAT *</label>
            <input type="date" class="form-control" name="vencimiento_soat" required>
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Vencimiento Tecnomecánica</label>
            <input type="date" class="form-control" name="vencimiento_tecnomecanica">
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Vencimiento Licencia de Conducción *</label>
            <input type="date" class="form-control" name="vencimiento_licencia" required>
        </div>
    </div>

    <!-- Kilometraje -->
    <div class="mb-3">
        <label class="form-label">Kilometraje actual *</label>
        <input type="number" class="form-control" name="kilometraje" required>
    </div>

    <!-- EPP -->
    <h6 class="mt-4">Inspección de equipo de protección personal *</h6>

    <table class="table table-bordered align-middle">
        <thead>
            <tr>
                <th>Elemento</th>
                <th class="text-center">Cumple</th>
                <th class="text-center">No cumple</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Uniforme empresarial</td>
                <td class="text-center"><input type="radio" name="uniforme" value="cumple" required></td>
                <td class="text-center"><input type="radio" name="uniforme" value="no_cumple"></td>
            </tr>
            <tr>
                <td>Casco reglamentario</td>
                <td class="text-center"><input type="radio" name="casco" value="cumple" required></td>
                <td class="text-center"><input type="radio" name="casco" value="no_cumple"></td>
            </tr>
            <tr>
                <td>Chaleco reflectivo</td>
                <td class="text-center"><input type="radio" name="chaleco" value="cumple" required></td>
                <td class="text-center"><input type="radio" name="chaleco" value="no_cumple"></td>
            </tr>
            <tr>
                <td>Botas de seguridad</td>
                <td class="text-center"><input type="radio" name="botas" value="cumple" required></td>
                <td class="text-center"><input type="radio" name="botas" value="no_cumple"></td>
            </tr>
            <tr>
                <td>Traje impermeable</td>
                <td class="text-center"><input type="radio" name="impermeable" value="cumple" required></td>
                <td class="text-center"><input type="radio" name="impermeable" value="no_cumple"></td>
            </tr>
        </tbody>
    </table>

    <!-- Documentos -->
    <h6 class="mt-4">Inspección de documentos *</h6>

    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="documentos[]" value="SOAT">
        <label class="form-check-label">SOAT</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="documentos[]" value="Licencia">
        <label class="form-check-label">Licencia de conducción</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="documentos[]" value="Cedula">
        <label class="form-check-label">Cédula del conductor</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="documentos[]" value="Tarjeta">
        <label class="form-check-label">Tarjeta de propiedad</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="documentos[]" value="Carnet">
        <label class="form-check-label">Carnet laboral</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="documentos[]" value="Recibos">
        <label class="form-check-label">Recibos de caja</label>
    </div>
   
    <div class="mt-3 text-end">
        <button type="submit" class="btn btn-success">
            Guardar inspección de moto
        </button>
    </div>
</form>
        </div>
    </div>
</div>

<!-- MODAL CARRO -->
<div class="modal-custom" id="modalCarro">

    <div class="modal-content-custom">

        <div class="modal-header-custom">
             <h2> plan estratégico de seguridad vial, (PESV)</h2>
            <button type="button" class="btn-close-custom" id="cerrarModalCarro">
                &times;
            </button>
        </div>

        <div class="modal-body-custom">

            <!-- AQUÍ VA TU FORMULARIO -->
            <form action="{{ route('mensajeria.inspeccion.carro.store') }}" method="POST">
                @csrf
             <input type="hidden" name="vehiculo" value="carro">    
              

    <!-- Fecha y hora -->
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Fecha de inspección *</label>
            <input type="date" class="form-control" name="fecha_inspeccion" required>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Hora de inspección *</label>
            <input type="time" class="form-control" name="hora_inspeccion" required>
        </div>
    </div>

    <!-- Arranque -->
    <div class="mb-3">
        <label class="form-label">
            Arranque el carro en neutro y déjelo calentar durante 3 a 5 minutos (OBLIGATORIO). *
        </label>
        <select class="form-select" name="arranque_realizado" required>
            <option value="">Seleccione</option>
            <option value="si">Realizado</option>
        </select>
    </div>

    <!-- Conductor / Inspector -->
   <div class="mb-3">
        <label class="form-label">Conductor encargado</label>
        <div class="input-group">
            <span class="input-group-text">
                <i class="fa-regular fa-address-card"></i>
            </span>
            <input type="text"
                   class="form-control"
                   name="mensajero"
                   value="{{ auth()->user()->name }}"
                   readonly>
        </div>
    </div>

    <!-- Ruta -->
    <div class="mb-3">
        <label class="form-label">Ruta a realizar *</label>

        <div class="form-check">
            <input class="form-check-input" type="radio" name="ruta" value="Sur Valle" required>
            <label class="form-check-label">Sur del Valle</label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" name="ruta" value="Norte Valle">
            <label class="form-check-label">Norte del Valle</label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" name="ruta" value="Pereira">
            <label class="form-check-label">Pereira</label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" name="ruta" value="Quindio">
            <label class="form-check-label">Quindío</label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" name="ruta" value="Perifericas">
            <label class="form-check-label">Periféricas</label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" name="ruta" value="Otro" id="rutaOtroRadio">
            <label class="form-check-label">Otra</label>
        </div>
         <input 
        type="text" 
        class="form-control mt-2"
        name="ruta_otro"
        placeholder="Escriba la ruta"
            >
        </div>
    </div>

    <!-- Condiciones -->
    <div class="mb-3">
        <label class="form-label">¿Está en condiciones físicas y mentales para conducir? *</label>
        <select class="form-select" name="condiciones_conductor" required>
            <option value="">Seleccione</option>
            <option value="si">Sí</option>
            <option value="no">No</option>
        </select>
    </div>

    <!-- Placa -->
 <div class="mb-3">
    <label class="form-label">Placa del vehículo *</label>

    <div class="form-check">
        <input class="form-check-input" type="radio" name="placa" value="CQC103" required>
        <label class="form-check-label">CQC103</label>
    </div>

    <div class="form-check">
        <input class="form-check-input" type="radio" name="placa" value="NXU026">
        <label class="form-check-label">NXU026</label>
    </div>

    <div class="form-check">
        <input class="form-check-input" type="radio" name="placa" value="Otro" id="placaOtroRadio">
        <label class="form-check-label">Otra</label>
    </div>

    <!-- INPUT PARA PLACA PERSONALIZADA -->
    <input
        type="text"
        class="form-control mt-2"
        name="placa_otro"
        placeholder="Escriba la placa"
    >
</div>
  
    <!-- Fechas documentos -->
    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label">Vencimiento SOAT *</label>
            <input type="date" class="form-control" name="vencimiento_soat" required>
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Vencimiento Tecnomecánica</label>
            <input type="date" class="form-control" name="vencimiento_tecnomecanica">
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Vencimiento Licencia de Conducción *</label>
            <input type="date" class="form-control" name="vencimiento_licencia" required>
        </div>
    </div>

    <!-- Kilometraje -->
    <div class="mb-3">
        <label class="form-label">Kilometraje actual *</label>
        <input type="number" class="form-control" name="kilometraje" required>
    </div>

    <!-- EPP -->
    <h6 class="mt-4">Inspección de equipo de protección personal *</h6>

    <table class="table table-bordered align-middle">
        <thead>
            <tr>
                <th>Elemento</th>
                <th class="text-center">Cumple</th>
                <th class="text-center">No cumple</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Uniforme empresarial</td>
                <td class="text-center"><input type="radio" name="uniforme" value="cumple" required></td>
                <td class="text-center"><input type="radio" name="uniforme" value="no_cumple"></td>
            </tr>
            <tr>
                <td>Botas de seguridad</td>
                <td class="text-center"><input type="radio" name="botas" value="cumple" required></td>
                <td class="text-center"><input type="radio" name="botas" value="no_cumple"></td>
            </tr>
            <tr>
                <td>Traje impermeable</td>
                <td class="text-center"><input type="radio" name="impermeable" value="cumple" required></td>
                <td class="text-center"><input type="radio" name="impermeable" value="no_cumple"></td>
            </tr>
            <tr>
                <td>Cinturón de seguridad</td>
                <td class="text-center"><input type="radio" name="cinturon" value="cumple" required></td>
                <td class="text-center"><input type="radio" name="cinturon" value="no_cumple"></td>
            </tr>
        </tbody>
    </table>

    <!-- Documentos -->
    <h6 class="mt-4">Inspección de documentos *</h6>

    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="documentos[]" value="SOAT">
        <label class="form-check-label">SOAT</label>
    </div>

    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="documentos[]" value="Licencia">
        <label class="form-check-label">Licencia de conducción</label>
    </div>

    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="documentos[]" value="Cedula">
        <label class="form-check-label">Cédula del conductor</label>
    </div>

    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="documentos[]" value="Tarjeta">
        <label class="form-check-label">Tarjeta de propiedad</label>
    </div>

    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="documentos[]" value="Carnet">
        <label class="form-check-label">Carnet laboral</label>
    </div>

    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="documentos[]" value="Recibos">
        <label class="form-check-label">Recibos de caja</label>
    </div>

    <div class="text-end mt-4">
    <button type="submit" class="btn btn-primary">
        Guardar inspección
    </button>
</div>


</form>


        </div>

    </div>
</div>






@endsection