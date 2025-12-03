<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index()
{
    $user = auth()->user();

    if ($user->hasRole('admin')) {
        $clientes = Cliente::all();  // Admin ve todo
    } else {
        $clientes = Cliente::where('empleado_id', $user->id)->get(); // Filtra por empleado
    }

    return view('home', compact('clientes'));
}

}
