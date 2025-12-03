<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Cliente;


class UserController extends Controller
{


    // Mostrar todos los usuarios
    public function usuarios()
    {
        $usuarios = User::all();
        return view('usuarios', compact('usuarios'));
    }

    // Guardar un nuevo usuario con rol y permisos
    public function store(Request $request)
    {
        // Validación
            $request->validate([
            'nombre' => 'required|string|max:255',
            'cedula' => 'required|string|unique:users,cedula',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'telefono' => 'nullable|string',
            'rol' => 'required|string',
        ]);


        // Crear usuario
        $user = User::create([
            'name' => $request->nombre,
            'cedula' => $request->cedula,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono,
            'rol' => $request->rol,
        ]);

        // Asignar rol al usuario
        $user->assignRole($request->rol);

        // Definir permisos según rol
        $permisosPorRol = [
            'operario' => ['agregar clientes', 'ver empleados'],
            'admin'    => ['ver clientes', 'asignar clientes', 'ver agregar clientes', 'editar clientes', 'eliminar clientes', 'ver empleados','ver usuarios','agregar usuarios','editar usuarios','eliminar usuarios']
        ];

        // Asignar permisos correspondientes
        if (isset($permisosPorRol[$request->rol])) {
            foreach ($permisosPorRol[$request->rol] as $perm) {
                if (!Permission::where('name', $perm)->exists()) {
                    Permission::create(['name' => $perm]);
                }
                $user->givePermissionTo($perm);
            }
        }

        return redirect()->route('usuarios')->with('success', 'Usuario agregado correctamente con rol y permisos.');
    }

        public function destroy(User $user)
        {
        $user->delete();
        return redirect()->route('usuarios')->with('success', 'Usuario eliminado correctamente.');
        }

        public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $user->name = $request->nombre;
    $user->cedula = $request->cedula;
    $user->email = $request->email;
    $user->telefono = $request->telefono;
    $user->rol = $request->rol;

    if ($request->password) {
        $user->password = bcrypt($request->password);
    }

    $user->save();

    return redirect()->back()->with('success', 'Usuario actualizado correctamente');
}



}
