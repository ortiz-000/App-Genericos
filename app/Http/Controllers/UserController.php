<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role; // asegúrate de tenerlo arriba

class UserController extends Controller
{
    // LISTAR USUARIOS
    public function usuarios()
    {
        $usuarios = User::all();
        return view('usuarios', compact('usuarios'));
    }

    // CREAR USUARIO
    public function store(Request $request)
    {
        $request->validate([
            'nombre'   => 'required|string|max:255',
            'cedula'   => 'required|string|unique:users,cedula',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'telefono' => 'nullable|string',
            'rol'      => 'required|string',
        ]);

        $user = User::create([
            'name'     => $request->nombre,
            'cedula'   => $request->cedula,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono,
            'rol'      => $request->rol,
        ]);

        $user->assignRole($request->rol);

        return redirect()->route('usuarios')
            ->with('success', 'Usuario creado correctamente');
    }

    // ELIMINAR
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('usuarios')
            ->with('success', 'Usuario eliminado correctamente');
    }

    // 🔥 EDITAR USUARIO (AQUÍ ESTÁ LA CLAVE)
    public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    // VALIDACIÓN (ignora el mismo usuario)
    $request->validate([
        'cedula' => 'required|string|unique:users,cedula,' . $user->id,
        'email'  => 'required|email|unique:users,email,' . $user->id,
    ]);

    $user->name     = $request->nombre;
    $user->cedula   = $request->cedula;
    $user->email    = $request->email;
    $user->telefono = $request->telefono;
    $user->rol      = $request->rol;

    // 🔐 SOLO SI ESCRIBE CONTRASEÑA
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    // 🔑 Sincroniza el rol y permisos automáticamente
    $user->syncRoles([$request->rol]);

    return redirect()->back()
        ->with('success', 'Usuario actualizado correctamente');
}
}
