<?php

namespace App\Http\Controllers;
use App\Models\Pdf;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pdf;
use Illuminate\Support\Facades\Auth;

class RutaController extends Controller
{
    // Mostrar las rutas y PDFs (opcional)
    public function Ruta()
    {
        // Rutas estáticas (puedes traerlas desde DB si quieres)
        $rutas = [
            ['id' => 1, 'nombre' => 'Ruta Tuluá'],
            ['id' => 2, 'nombre' => 'Ruta Trujillo'],
        ];

        // Obtener PDFs filtrados por usuario
        $user = Auth::user();
        $rolesConAccesoTotal = ['admin', 'supervisor'];

        if (in_array($user->role, $rolesConAccesoTotal)) {
            $pdfs = Pdf::latest()->get();
        } else {
            $pdfs = Pdf::where('empleado_id', $user->id)->latest()->get();
        }

        return view('Ruta', compact('rutas', 'pdfs'));
    }

    // Listar PDFs en una vista separada (opcional)
    public function pdfs()
{
    $user = Auth::user();
    $rolesConAccesoTotal = ['admin', 'supervisor'];

    if (in_array($user->role, $rolesConAccesoTotal)) {
        $pdfs = Pdf::latest()->paginate(15); // <-- usar paginate
    } else {
        $pdfs = Pdf::where('empleado_id', $user->id)->latest()->paginate(15); // <-- paginate aquí también
    }

    return view('Ruta', compact('pdfs'));
}


    // Subir PDF
    public function storePdf(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'pdf' => 'required|file|mimes:pdf|max:10240', // 10 MB
            'nombre' => 'required|string|max:255',
        ]);

        $filePath = $request->file('pdf')->store('pdfs', 'public');

        Pdf::create([
            'nombre' => $request->nombre,
            'ruta' => $filePath,
            'empleado_id' => $user->id,
        ]);

        return redirect()->back()->with('success', 'PDF subido correctamente.');
    }

    // Eliminar PDF
    public function destroyPdf($id)
    {
        $pdf = Pdf::findOrFail($id);
        $user = Auth::user();

        // Solo el dueño o admin puede eliminar
        if ($pdf->empleado_id !== $user->id && $user->role !== 'admin') {
            abort(403, 'No tienes permiso para eliminar este PDF.');
        }

        $pdf->delete();

        return redirect()->back()->with('success', 'PDF eliminado correctamente.');
    }
    
}


