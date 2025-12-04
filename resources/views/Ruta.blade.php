@extends('layouts.default')

@section('maincontent')
<div class="page-header text-center">
    <img src="{{ asset('https://www.supergenericosdelvalle.com/wp-content/uploads/2023/12/Grupo-130.png') }}" alt="Logo" class="logo">
        <h2>RUTERO PDFS </h2>
    </div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- Formulario de subida --}}
<form action="{{ route('ruta.pdfs.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="text" name="nombre" placeholder="Nombre del PDF" required>
    <input type="file" name="pdf" accept="application/pdf" required>

    {{-- Select para asignar usuario --}}
    <select name="empleado_id" required>
        <option value="">Selecciona un usuario</option>
        @foreach($usuarios as $u)
            <option value="{{ $u->id }}">{{ $u->name }}</option>
        @endforeach
    </select>

    <button type="submit">Subir PDF</button>
</form>

<hr>

{{-- Tabla de PDFs --}}
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
    <tr>
        <th>Nombre</th>
        <th>Asignado a</th> <!-- nueva columna -->
        <th>Archivo</th>
        <th>Fecha</th>
        <th>Acciones</th>
    </tr>
</thead>
<tbody>
    @foreach($pdfs as $p)
    <tr>
        <td>{{ $p->nombre }}</td>
        <td>{{ $p->empleado->name }}</td> <!-- aquí -->
        <td>
            <a href="{{ route('ruta.pdfs.download', $p->id) }}" target="_blank">Ver PDF</a>
        </td>
        <td>{{ $p->created_at->format('d/m/Y H:i') }}</td>

        
        @can('eliminar pdfs')
        <td>
            <form action="{{ route('ruta.pdfs.destroy', $p->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('¿Seguro que desea eliminar este PDF?')" class="btn-borrar"> <i class="fa-solid fa-trash"></i></button>
            </form>
        </td>
         @endcan
    </tr>
    @endforeach
</tbody>

    </table>
</div>
@endsection
