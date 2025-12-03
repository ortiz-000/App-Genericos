@extends('layouts.default')

@section('maincontent')
<h2>PDFs</h2>

<form action="{{ route('ruta.pdfs.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="text" name="nombre" placeholder="Nombre del PDF" required>
    <input type="file" name="pdf" accept="application/pdf" required>
    <button type="submit">Subir PDF</button>
</form>

<hr>
  <div class="table-responsive">
        <table id="miTabla" class="table table-striped table-hover">
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
            <td><a href="/storage/{{ $p->ruta }}" target="_blank">Ver PDF</a></td>
            <td>{{ $p->created_at }}</td>
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
