<?php

namespace Database\Seeders;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //ROLES Y PERMISOS//
        $admin = Role::firstOrCreate(['name' => 'admin']);
    $eliminarReportes = Permission::firstOrCreate(['name'=>'eliminar reportes']);
    $verRuta = Permission::firstOrCreate(['name'=>'ver ruta']);
    $verHome = Permission::firstOrCreate(['name'=>'ver home']);
    $verClientes = Permission::firstOrCreate(['name'=>'ver clientes']);
    $asignarClientes = Permission::firstOrCreate(['name'=>'asignar clientes']);
    $agregarClientes = Permission::firstOrCreate(['name'=>'agregar clientes']);
    $editarClientes = Permission::firstOrCreate(['name'=>'editar clientes']);
    $eliminarClientes = Permission::firstOrCreate(['name'=>'eliminar clientes']);
    $verEmpleados = Permission::firstOrCreate(['name'=>'ver empleados']);
    $verUsuarios = Permission::firstOrCreate(['name'=>'ver usuarios']);
    $agregarUsuarios = Permission::firstOrCreate(['name'=>'agregar usuarios']);
    $editarUsuarios = Permission::firstOrCreate(['name'=>'editar usuarios']);
    $eliminarUsuarios = Permission::firstOrCreate(['name'=>'eliminar usuarios']);
    $verPdfs = Permission::firstOrCreate(['name'=>'ver pdfs']);
    $agregarPdfs = Permission::firstOrCreate(['name'=>'agregar pdfs']);
    $eliminarPdfs = Permission::firstOrCreate(['name'=>'eliminar pdfs']);
    

        //ASIGNACIÓN DE PERMISOS A ADMIN

     $admin->givePermissionTo([
     $verHome,
     $verClientes,
     $asignarClientes,
     $agregarClientes,
     $editarClientes,
     $eliminarClientes,
     $verEmpleados,
     $verUsuarios,
     $agregarUsuarios,
     $editarUsuarios,
     $eliminarUsuarios,
     $verRuta,
     $eliminarReportes,
     $verPdfs,
     $agregarPdfs,
     $eliminarPdfs,
    ]);

        $vendedor = Role::firstOrCreate(['name' => 'vendedor']);
        //ASIGNACIÓN DE PERMISOS A OPERARIO
       $vendedor->givePermissionTo([
        $verHome,
        $agregarClientes,
        $verEmpleados,
        $verRuta,
        $verPdfs,
    ]);

   
    }
}
