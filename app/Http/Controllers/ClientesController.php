<?php
/*DEV <===============>Sebastian ortiz<=======================> */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\User;
use App\Imports\ClientesImport;
use Maatwebsite\Excel\Excel as MaatwebsiteExcel;
use Maatwebsite\Excel\Facades\Excel;

class ClientesController extends Controller
{
    // ===================== LISTA DE CLIENTES ===================== //
    public function clientes()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            // Admin ve todos los clientes
            $clientes = Cliente::all();
        } else {
            // Usuario normal solo ve los clientes que creó
            $clientes = Cliente::where('empleado_id', $user->id)->get();
        }

        // 🔹 Traemos evidencias existentes
        $evidencias = \DB::table('evidencias')
            ->select('nombre_establecimiento', 'ciudad_establecimiento')
            ->get()
            ->map(function ($e) {
                return strtoupper(trim($e->nombre_establecimiento)) . '|' . strtoupper(trim($e->ciudad_establecimiento));
            })
            ->toArray();

        // 🔹 Asignamos estado a cada cliente
        $clientes->transform(function ($cliente) use ($evidencias) {
            $key = strtoupper(trim($cliente->nombre)) . '|' . strtoupper(trim($cliente->ciudad));

            $cliente->estado = in_array($key, $evidencias)
                ? 'VISITADO'
                : 'PENDIENTE';

            return $cliente;
        });

        return view('clientes', compact('clientes'));
    }

    // ===================== CREAR CLIENTES ===================== //
    public function store(Request $request)
    {
        // Validación de datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'ciudad' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
        ]);

        // Crear cliente y asignar automáticamente al usuario actual
        Cliente::create([
            'nombre' => $request->nombre,
            'direccion' => $request->direccion,
            'ciudad' => $request->ciudad,
            'telefono' => $request->telefono,
            'empleado_id' => auth()->id(),
        ]);

        return redirect()->route('home')->with('success', 'Cliente agregado con éxito');
    }

    // ===================== EDITAR CLIENTES ===================== //
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'ciudad' => 'required|string|max:100',
            'telefono' => 'required|string|max:15',
        ]);

        $cliente = Cliente::find($id);

        if (!$cliente) {
            return redirect()->route('clientes')
                             ->with('error', 'Cliente no encontrado');
        }

        $cliente->update($validatedData);

        return redirect()->route('clientes')
                         ->with('success', 'Cliente actualizado correctamente');
    }

    // ===================== ELIMINAR CLIENTES ===================== //
    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();

        return redirect()->route('clientes')->with('success', 'Cliente eliminado con éxito');
    }

    // ===================== IMPORTAR CLIENTES ===================== //
    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        // Borrar todos los clientes existentes
        Cliente::query()->delete();

        // Importar nuevo Excel
        Excel::import(new ClientesImport, $request->file('excel_file'));

        return redirect()->back()->with('success', 'Clientes importados correctamente y tabla reemplazada.');
    }
}
