<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pdf;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RutaController extends Controller
{
    public function Ruta()
    {
        $rutas = [
            ['id' => 1, 'nombre' => 'Ruta Tuluá'],
            ['id' => 2, 'nombre' => 'Ruta Trujillo'],
        ];

        $user = Auth::user();
        $rolesConAccesoTotal = ['admin'];

        if (in_array($user->role, $rolesConAccesoTotal)) {
            $pdfs = Pdf::latest()->get();
        } else {
            $pdfs = Pdf::where(function($query) use ($user) {
                $query->where('empleado_id', $user->id)
                      ->orWhere('creado_por', $user->id);
            })->latest()->get();
        }

        $usuarios = User::all();

        return view('Ruta', compact('rutas', 'pdfs', 'usuarios'));
    }

    public function storePdf(Request $request)
    {
        $request->validate([
            'pdf' => 'required|file|mimes:pdf|max:10240',
            'nombre' => 'required|string|max:255',
            'empleado_id' => 'required|exists:users,id',
        ]);

        $filePath = $request->file('pdf')->store('pdfs', 'public');

        Pdf::create([
            'nombre' => $request->nombre,
            'ruta' => $filePath,
            'empleado_id' => $request->empleado_id,
            'creado_por' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'PDF subido correctamente y asignado al usuario.');
    }

    public function destroyPdf($id)
{
    $pdf = Pdf::findOrFail($id);
    $user = Auth::user();

    // Solo confía en el middleware de permisos
    // Admin con permiso puede borrar todo
    $pdf->delete();

    return redirect()->back()->with('success', 'PDF eliminado correctamente.');
}


    public function downloadPdf($id)
    {
        $pdf = Pdf::findOrFail($id);
        $user = Auth::user();

        if ($pdf->empleado_id !== $user->id && $pdf->creado_por !== $user->id && !in_array($user->role, ['admin'])) {
            abort(403, 'No tienes permiso para ver este PDF.');
        }

        $filePath = storage_path('app/public/' . $pdf->ruta);

        if (!file_exists($filePath)) {
            abort(404, 'Archivo no encontrado.');
        }

        return response()->file($filePath);
    }
}
