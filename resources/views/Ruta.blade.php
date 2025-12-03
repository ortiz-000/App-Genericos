@extends('layouts.default')

@section('maincontent')
<h2>PDFs</h2>

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
                <th>Archivo</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pdfs as $p)
            <tr>
                <td>{{ $p->nombre }}</td>
                <td>
                    <a href="{{ route('ruta.pdfs.download', $p->id) }}" target="_blank">Ver PDF</a>
                </td>
                <td>{{ $p->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    <form action="{{ route('ruta.pdfs.destroy', $p->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('¿Seguro que desea eliminar este PDF?')">Borrar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
