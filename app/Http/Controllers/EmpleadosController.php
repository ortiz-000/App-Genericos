<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evidencia;
use Illuminate\Support\Facades\Auth;

class EmpleadosController extends Controller
{
    // ========================================
    // GUARDAR EVIDENCIA
    // ========================================
    public function storeEvidencia(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->back()->with('error', 'Debes iniciar sesión para enviar evidencia.');
        }

        // Validar datos del formulario
        $request->validate([
            'accesor_comercial'      => 'required|string|max:255',
            'usuario'                => 'required|email|max:255',
            'nombre_establecimiento' => 'required|string|max:255',
            'ciudad_establecimiento' => 'required|string|max:255',
            'ubicacion'              => 'nullable|string|max:500',
            'motivo'                 => 'required|string|max:255',
            'otro'                   => 'nullable|string|max:255',
            'foto_establecimiento'   => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
        ]);

        // Manejo de imagen
        $fotoPath = null;
        if ($request->hasFile('foto_establecimiento')) {
            $fotoPath = $request->file('foto_establecimiento')->store('evidencias', 'public');
        }

        // Motivo final (si eligieron "Otro")
        $motivoFinal = $request->motivo == 'Otro' ? $request->otro : $request->motivo;

        // Guardar evidencia
        Evidencia::create([
            'accesor_comercial'      => $request->accesor_comercial,
            'usuario'                => $request->usuario,
            'nombre_establecimiento' => $request->nombre_establecimiento,
            'ciudad_establecimiento' => $request->ciudad_establecimiento,
            'ubicacion'              => $request->ubicacion,
            'motivo'                 => $motivoFinal,
            'otro'                   => $request->otro,
            'foto_establecimiento'   => $fotoPath,
            'empleado_id'            => $user->id,
        ]);

        return redirect()->route('empleados')->with('success', 'Evidencia enviada con éxito!');
    }

    // ========================================
    // HISTORIAL DE EVIDENCIAS (TOTAL)
    // ========================================
    public function empleados()
    {
        $user = Auth::user();

        if (strtolower($user->rol) === 'admin') {
            // Admin ve todas las evidencias, historial completo
            $evidencias = Evidencia::orderBy('created_at', 'desc')->get();
        } else {
            // Otros usuarios solo ven sus propias evidencias
            $evidencias = Evidencia::where('empleado_id', $user->id)
                                   ->orderBy('created_at', 'desc')
                                   ->get();
        }

        return view('empleados', compact('evidencias'));
    }

    // ========================================
    // ELIMINAR EVIDENCIA (solo manual)
    // ========================================
    public function destroy($id)
    {
        $reporte = Evidencia::findOrFail($id);
        $reporte->delete();

        return redirect()->back()->with('success', 'Reporte eliminado correctamente.');
    }
}
