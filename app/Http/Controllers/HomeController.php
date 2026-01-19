<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
public function index()
{
    $user = auth()->user();

    if ($user->hasRole('admin')) {
        $clientes = Cliente::all();
    } else {
        $clientes = Cliente::where('empleado_id', $user->id)->get();
    }

    // Traer evidencias existentes
    $evidencias = DB::table('evidencias')
        ->select('nombre_establecimiento', 'ciudad_establecimiento')
        ->get()
        ->map(function ($e) {
            return strtoupper(trim($e->nombre_establecimiento)) . '|' .
                   strtoupper(trim($e->ciudad_establecimiento));
        })
        ->toArray();

    // Asignar estado
    $clientes->transform(function ($cliente) use ($evidencias) {
        $key = strtoupper(trim($cliente->nombre)) . '|' .
               strtoupper(trim($cliente->ciudad));

        $cliente->estado = in_array($key, $evidencias)
            ? 'VISITADO'
            : 'PENDIENTE';

        return $cliente;
    });

    return view('home', compact('clientes'));
}

}
