@extends('layouts.default')

@section('header')
    <div class="page-header text-center">
        <img src="{{ asset('https://www.supergenericosdelvalle.com/wp-content/uploads/2023/12/Grupo-130.png') }}" alt="Logo" class="logo">
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

    <!-- ================== BOTÓN AGREGAR USUARIO ================== -->
    <div class="actions-container mb-3 text-right">
        <button class="btn btn-add-user">
            <i class="fa-solid fa-user-plus"></i>
        </button>
    </div>

    <!-- ================== TABLA DE USUARIOS ================== -->
    <div class="table-responsive">
        <table id="miTabla" class="table table-striped table-hover">
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
                        <td>{{ $u->cedula ?? '' }}</td>
                        <td>{{ $u->nombre ?? $u->name }}</td>
                        <td>{{ $u->email }}</td>
                        <td>••••••</td>
                        <td>{{ $u->telefono ?? '' }}</td>
                        <td>{{ $u->rol ?? '' }}</td>
                        <td>
                            <button type="button" class="btn_edit_users">
                              <i class="fa-regular fa-pen-to-square"></i>
                            </button>
                        <form action="{{ route('usuarios.destroy', $u->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No hay usuarios registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- ================== MODAL AGREGAR USUARIO ================== -->
    <section class="modal" id="modalAgregar">
        <div class="modal__container">
            <h1 class="modal__title">Agregar Usuario</h1>

            <form action="{{ route('usuarios.store') }}" method="POST">
                @csrf
                
                <label>Nombre</label>
                <i class="fa-solid fa-person-circle-plus"></i>
                <input class="controls" type="text" name="nombre" placeholder="Ingrese el nombre">

                <label>Cedula</label>
                <i class="fa-solid fa-id-card"></i>
                <input class="controls" type="text" name="cedula" placeholder="Ingrese la cedula">

                <label>Email</label>
                <i class="fa-solid fa-envelope"></i>
                <input class="controls" type="email" name="email" placeholder="Ingrese el email">

                <label>Password</label>
                <i class="fa-solid fa-lock"></i>
                <input class="controls" type="password" name="password" placeholder="Ingrese la contraseña">

                <label>Telefono</label>
                <i class="fa-solid fa-phone"></i>
                <input class="controls" type="text" name="telefono" placeholder="Ingrese el telefono">
                
                <label>Rol</label>
                <i class="fa-solid fa-user-tag"></i>
                <select class="selecte" name="rol">
                    <option value="vendedor">Vendedor</option>
                    <option value="admin">Administrador</option>
                </select>

                <div>
                    <button type="submit" class="btn btn-primary">Agregar</button>
                    <a href="#" class="close-modal-btn">Cancelar</a>
                </div>
            </form>
        </div>
    </section>

    <!-- ================== MODAL EDITAR USUARIO ================== -->
    <section class="modal__editar" id="modalEditar">
    <div class="modal_container">
        <h1 class="modal_title">Editar Usuario</h1>

        <form id="formEditar" action="" method="POST">
            @csrf
            @method('PATCH')

            

            <input type="hidden" name="id" id="edit_id">


            <label>Nombre</label>
            <input class="controls" type="text" name="nombre" id="edit_nombre" placeholder="Ingrese su nombre">

            <label>Cedula</label>
            <input class="controls" type="text" name="cedula" id="edit_cedula" placeholder="Ingrese su cédula">

            <label>Email</label>
            <input class="controls" type="email" name="email" id="edit_email" placeholder="Ingrese su email">

            <label >Nueva contraseña</label>
            <input class="controls" type="password" name="password" id="edit_password" placeholder="Nueva contraseña (opcional)">

            <label>Telefono</label>
            <input class="controls" type="text" name="telefono" id="edit_telefono" placeholder="Ingrese su teléfono">


            <label>Rol</label>
            <select class="selected" name="rol" id="edit-rol">
                <option value="vendedor">Vendedor</option>
                <option value="admin">Administrador</option>
            </select>

            <div>
                <button type="submit" class="Edit_usuario">Guardar cambios</button>
                <a href="#" class="close_modal_btn">Cerrar</a>
            </div>
        </form>
    </div>
</section>

@endsection
