<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmpleadosController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\RutaController;
use App\Models\User;
use Spatie\Permission\Models\Permission;

// Cuando entren a la app, ir al login primero
Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas públicas (sin autenticación)
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginPost'])->name('login.post');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

// Rutas privadas (solo si el usuario está logueado)
Route::middleware('auth')->group(function () {

    //====================>HOME<===========================>//
     Route::get('/home', [HomeController::class, 'index'])->name('home')
   ->middleware('permission:ver home');
    //
  
    //VENDEDORES
    
    ///====================>HOME<===========================>//



    

      //<===================>CIELNTES <=======================>//
     Route::get('/clientes', [ClientesController::class, 'clientes'])->name('clientes')
    ->middleware('permission:ver clientes');


    Route::post('/clientes/asignar', [ClientesController::class, 'asignar'])
    ->name('clientes.asignar')
    ->middleware('permission:asignar clientes');

    Route::post('/clientes', [ClientesController::class, 'store'])
    ->middleware('permission:agregar clientes')
    ->name('clientes.store');


    Route::delete('/clientes/{id}', [ClientesController::class, 'destroy'])
    ->middleware('permission:eliminar clientes')
    ->name('clientes.destroy');


     Route::post('/import', [ClientesController::class, 'import'])
     ->middleware('permission:asignar clientes')
     ->name('clientes.import');

    Route::patch('/clientes/{id}', [ClientesController::class, 'update'])
    ->name('clientes.update')
    ->middleware('permission:editar clientes');
    //<===================>CIELNTES <=======================>//



    
    //<===================>USUARIOS<========================>//
    Route::get('/usuarios', [UserController::class, 'usuarios'])->name('usuarios')
    ->middleware('permission:ver usuarios'); 

    Route::post('/usuarios/guardar', [UserController::class, 'store'])
    ->name('usuarios.store')
    ->middleware('permission:agregar usuarios');


    Route::delete('/usuarios/{user}', [UserController::class, 'destroy'])
    ->name('usuarios.destroy')
    ->middleware('permission:eliminar usuarios');


    Route::patch('/usuarios/{id}', [UserController::class, 'update'])
    ->middleware('role:admin')
    ->name('usuarios.update');
   //<===================>USUARIOS<========================>//
   


    //<===========================>EMPLEADOS<==========================>//

    Route::get('/empleados', [EmpleadosController::class, 'empleados'])->name('empleados')
    ->middleware('permission:ver empleados');

    
    Route::post('/empleados/evidencia', [EmpleadosController::class, 'storeEvidencia'])
    ->name('empleados.evidencia.store')
    ->middleware('auth'); // protege la ruta

    Route::get('/empleados/evidencias', [EmpleadosController::class, 'verEvidencias'])
    ->name('empleados.evidencias.index')
    ->middleware('auth'); 



    Route::delete('empleados/reportes/{id}', [EmpleadosController::class, 'destroy'])
    ->name('empleados.reportes.destroy')
    ->middleware('permission:eliminar reportes');

    
    //<===========================>EMPLEADOS<==========================>//

    
    //<===========================>RUTA<==========================>//

    Route::get('/Ruta', [RutaController::class, 'Ruta'])->name('Ruta')
    ->middleware('permission:ver ruta'); 


    //<===========================>RUTA<==========================>//
    Route::get('/ruta/pdfs', [RutaController::class, 'pdfs'])->name('ruta.pdfs')->middleware('auth');
    Route::post('/ruta/pdfs', [RutaController::class, 'storePdf'])->name('ruta.pdfs.store')->middleware('auth');
    Route::delete('/ruta/pdfs/{id}', [RutaController::class, 'destroyPdf'])->name('ruta.pdfs.destroy')->middleware('auth');

    
    Route::get('/ruta', [RutaController::class, 'Ruta'])->name('ruta.pdfs.index')->middleware('auth');
    Route::post('/ruta/pdf/store', [RutaController::class, 'storePdf'])->name('ruta.pdfs.store')->middleware('auth');
    Route::delete('/ruta/pdf/destroy/{id}', [RutaController::class, 'destroyPdf'])->name('ruta.pdfs.destroy')->middleware('auth');
    Route::get('/ruta/pdf/download/{id}', [RutaController::class, 'downloadPdf'])->name('ruta.pdfs.download')->middleware('auth');


     //<===========================>RUTA<==========================>//
});
