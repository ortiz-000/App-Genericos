<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recorrido;
use Illuminate\Support\Facades\Auth;

class RecorridoController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Recorrido::where('user_id', $user->id);

        if ($request->filled('desde') && $request->filled('hasta')) {
            $query->whereBetween('fecha', [
                $request->desde,
                $request->hasta
            ]);
        }

        $recorridos = $query->orderBy('fecha', 'desc')->get();

        return view('Recorrido', compact('recorridos'));
    }

    public function show($id)
    {
        $recorrido = Recorrido::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('recorridos.show', compact('recorrido'));
    }
}
