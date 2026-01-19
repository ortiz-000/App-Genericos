@extends('layouts.default')

@section('header')
<div class="page-header text-center">
    <img src="https://www.supergenericosdelvalle.com/wp-content/uploads/2023/12/Grupo-130.png" alt="Logo" class="logo">
    <h2>Lista de Usuarios</h2>
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

<!-- ================== BOTÓN AGREGAR ================== -->
<div class="actions-container mb-3 text-right">
    <button class="btn btn-add-user">
        <i class="fa-solid fa-user-plus"></i>
    </button>
</div>

<!-- ================== TABLA ================== -->
<div class="table-responsive">
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Cédula</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Password</th>
            <th>Teléfono</th>
            <th>Rol</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    @forelse($usuarios as $u)
        <tr>
            <td>{{ $u->id }}</td>
            <td>{{ $u->cedula }}</td>
            <td>{{ $u->name }}</td>
            <td>{{ $u->email }}</td>
            <td>••••••</td>
            <td>{{ $u->telefono }}</td>
            <td>{{ $u->rol }}</td>
            <td>
                <!-- EDITAR -->
                <button class="btn-editar"
                    type="button"
                    class="btn_edit_users"
                    data-id="{{ $u->id }}"
                    data-nombre="{{ $u->name }}"
                    data-cedula="{{ $u->cedula }}"
                    data-email="{{ $u->email }}"
                    data-telefono="{{ $u->telefono }}"
                    data-rol="{{ $u->rol }}"
                >
                    <i class="fa-regular fa-pen-to-square"></i>
                </button>

                <!-- ELIMINAR -->
                <form action="{{ route('usuarios.destroy', $u->id) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-delete" onclick="return confirm('¿Eliminar usuario?')">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="8" class="text-center">No hay usuarios registrados</td>
        </tr>
    @endforelse
    </tbody>
</table>
</div>

<!-- ================== MODAL AGREGAR ================== -->
<section class="modal" id="modalAgregar">
<div class="modal__cont">
<h1>Agregar Usuario</h1>

<form action="{{ route('usuarios.store') }}" method="POST">
@csrf

<label>Nombre</label>
<input class="controls" type="text" placeholder="Ingrese el Nombre" name="nombre">

<label>Cédula</label>
<input class="controls" type="text" placeholder="Ingrese la Cédula" name="cedula">

<label>Email</label>
<input class="controls" type="email" placeholder="Ingrese el Email" name="email">

<label>Password</label>
<input class="controls" type="password" placeholder="Ingrese la Contraseña" name="password">

<label>Teléfono</label>
<input class="controls" type="text" placeholder="Ingrese el Teléfono" name="telefono">

<label>Rol</label>
<select class="selected" name="rol">
    <option value="vendedor">Vendedor</option>
    <option value="admin">Administrador</option>
    <option value="mensajero">Mensajero</option>
</select>

<div>
    <button  type="submit" class="btn btn-primary">Agregar</button>
    <a href="#" class="close-modal-btn">Cancelar</a>
</div>
</form>
</div>
</section>

<!-- ================== MODAL EDITAR ================== -->
<section class="modal__editar" id="modalEditar">
<div class="modal_container">
<h1>Editar Usuario</h1>

<form id="formEditar" method="POST">
@csrf
@method('PATCH')

<input type="hidden" id="edit_id">

<label>Nombre</label>
<input class="controls" type="text" name="nombre" id="edit_nombre">

<label>Cédula</label>
<input class="controls" type="text" name="cedula" id="edit_cedula">

<label>Email</label>
<input class="controls" type="email" name="email" id="edit_email">

<label>Nueva contraseña</label>
<input class="controls" type="password" name="password" placeholder="Solo si deseas cambiarla">

<label>Teléfono</label>
<input class="controls" type="text" name="telefono" id="edit_telefono">

<label>Rol</label>
<select class="selected" name="rol" id="edit-rol">
    <option value="vendedor">Vendedor</option>
    <option value="admin">Administrador</option>
    <option value="mensajero">Mensajero</option>
</select>

<div>
    <button type="submit" class="Edit_usuario">Guardar cambios</button>
    <a href="#" class="close_modal_btn">Cerrar</a>
</div>

</form>
</div>
</section>

@endsection
