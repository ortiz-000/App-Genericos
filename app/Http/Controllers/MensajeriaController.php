<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inspeccion;
use Illuminate\Support\Facades\Auth;

class MensajeriaController extends Controller
{
    /**
     * Mostrar la vista con las inspecciones.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Query base
        $query = Inspeccion::query();

        // Si no es admin, solo sus inspecciones
        if ($user->rol !== 'admin') {
            $query->where('user_id', $user->id);
        }

        // Filtro por mensajero o vendedor
        if ($request->filled('mensajero')) {
            $search = $request->mensajero;
            $query->where(function($q) use ($search) {
                $q->where('mensajero', 'like', "%{$search}%")
                  ->orWhere('ruta', 'like', "%{$search}%");
            });
        }

        // Filtro por rango de fechas
        if ($request->filled('fecha_inicio')) {
            $query->where('fecha_inspeccion', '>=', $request->fecha_inicio);
        }
        if ($request->filled('fecha_fin')) {
            $query->where('fecha_inspeccion', '<=', $request->fecha_fin);
        }

        // Ordenar por fecha descendente
        $inspecciones = $query->orderBy('fecha_inspeccion', 'desc')->get();

        return view('mensajeria', compact('inspecciones'));
    }

    /**
     * Guardar una nueva inspección (moto o carro).
     */
    public function storeVehiculo(Request $request)
    {
        $user = Auth::user();

        // Validación básica
        $request->validate([
            'vehiculo' => 'required|in:moto,carro',
            'fecha_inspeccion' => 'required|date',
            'hora_inspeccion' => 'required',
            'arranque_realizado' => 'required',
            'mensajero' => 'required',
            'ruta' => 'required',
            'condiciones_conductor' => 'required',
            'placa' => 'required',
            'vencimiento_soat' => 'required|date',
            'vencimiento_licencia' => 'required|date',
            'kilometraje' => 'required|numeric',
        ]);

        // Crear nueva inspección
        Inspeccion::create([
            'user_id' => $user->id,
            'vehiculo' => $request->vehiculo,
            'fecha_inspeccion' => $request->fecha_inspeccion,
            'hora_inspeccion' => $request->hora_inspeccion,
            'arranque_realizado' => $request->arranque_realizado,
            'mensajero' => $request->mensajero,
            'email' => $request->email,
            'ruta' => $request->ruta,
            'ruta_otro' => $request->ruta_otro,
            'condiciones_conductor' => $request->condiciones_conductor,
            'placa' => $request->placa,
            'placa_otro' => $request->placa_otro,
            'vencimiento_soat' => $request->vencimiento_soat,
            'vencimiento_tecnomecanica' => $request->vencimiento_tecnomecanica,
            'vencimiento_licencia' => $request->vencimiento_licencia,
            'kilometraje' => $request->kilometraje,
            'uniforme' => $request->uniforme,
            'casco' => $request->casco,
            'chaleco' => $request->chaleco,
            'botas' => $request->botas,
            'impermeable' => $request->impermeable,
            'cinturon' => $request->cinturon,
            'documentos' => $request->documentos, // array
        ]);

        return redirect()->back()->with('success', 'Inspección registrada correctamente.');
    }

    public function storeCarro(Request $request)
{
    $user = Auth::user();

    // Validación
    $request->validate([
        'fecha_inspeccion' => 'required|date',
        'hora_inspeccion' => 'required',
        'arranque_realizado' => 'required',
        'mensajero' => 'required',
        'ruta' => 'required',
        'condiciones_conductor' => 'required',
        'placa' => 'required',
        'vencimiento_soat' => 'required|date',
        'vencimiento_licencia' => 'required|date',
        'kilometraje' => 'required|numeric',
    ]);

    // Crear inspección (NO updateOrCreate → historial)
    Inspeccion::create([
        'user_id' => $user->id,
        'vehiculo' => 'carro',

        'fecha_inspeccion' => $request->fecha_inspeccion,
        'hora_inspeccion' => $request->hora_inspeccion,
        'arranque_realizado' => $request->arranque_realizado,

        'mensajero' => $request->mensajero,
        'email' => $request->email,

        'ruta' => $request->ruta,
        'ruta_otro' => $request->ruta_otro,

        'condiciones_conductor' => $request->condiciones_conductor,

        'placa' => $request->placa,
        'placa_otro' => $request->placa_otro,

        'vencimiento_soat' => $request->vencimiento_soat,
        'vencimiento_tecnomecanica' => $request->vencimiento_tecnomecanica,
        'vencimiento_licencia' => $request->vencimiento_licencia,

        'kilometraje' => $request->kilometraje,

        // EPP
        'uniforme' => $request->uniforme,
        'botas' => $request->botas,
        'impermeable' => $request->impermeable,
        'cinturon' => $request->cinturon,

        // Documentos (array → json)
        'documentos' => $request->documentos,
    ]);

    return redirect()->back()->with('success', 'Inspección de carro registrada correctamente.');
}

    // Guardar inspección de moto
public function storeMoto(Request $request)
{
    $user = Auth::user();

    // Validación básica
$request->validate([
    'fecha_inspeccion' => 'required|date',
    'hora_inspeccion' => 'required',
    'arranque_realizado' => 'required',
    'mensajero' => 'required',
    'ruta' => 'required',
    'ruta_otro' => 'nullable|string',
    'condiciones_conductor' => 'required',
    'placa' => 'required',
    'placa_otro' => 'nullable|string',
    'vencimiento_soat' => 'required|date',
    'vencimiento_tecnomecanica' => 'nullable|date',
    'vencimiento_licencia' => 'required|date',
    'kilometraje' => 'required|numeric',
    'uniforme' => 'nullable|string',
    'casco' => 'nullable|string',
    'chaleco' => 'nullable|string',
    'botas' => 'nullable|string',
    'impermeable' => 'nullable|string',
    'cinturon' => 'nullable|string',
    'documentos' => 'nullable|array',
]);


    // Guardar o actualizar
    Inspeccion::updateOrCreate(
        [
            'user_id' => $user->id,
            'vehiculo' => 'moto', // fijo para este formulario
            'fecha_inspeccion' => $request->fecha_inspeccion,
        ],
        [
            'hora_inspeccion' => $request->hora_inspeccion,
            'arranque_realizado' => $request->arranque_realizado,
            'mensajero' => $request->mensajero,
            'email' => $request->email,
            'ruta' => $request->ruta,
            'ruta_otro' => $request->ruta_otro,
            'condiciones_conductor' => $request->condiciones_conductor,
            'placa' => $request->placa,
            'placa_otro' => $request->placa_otro,
            'vencimiento_soat' => $request->vencimiento_soat,
            'vencimiento_tecnomecanica' => $request->vencimiento_tecnomecanica,
            'vencimiento_licencia' => $request->vencimiento_licencia,
            'kilometraje' => $request->kilometraje,
            'uniforme' => $request->uniforme,
            'casco' => $request->casco,
            'chaleco' => $request->chaleco,
            'botas' => $request->botas,
            'impermeable' => $request->impermeable,
            'cinturon' => $request->cinturon,
            'documentos' => $request->documentos, // array de checkboxes
        ]
    );

    return redirect()->back()->with('success', 'Inspección de moto registrada correctamente.');
}



}
