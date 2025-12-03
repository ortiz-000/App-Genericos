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
    // Método que muestra la lista de clientes
   public function clientes()
{
    $user = auth()->user();

    if ($user->hasRole('admin')) {
        // Admin ve todos
        $clientes = Cliente::all();
    } else {
        // El empleado solo ve los asignados a él
        $clientes = Cliente::where('empleado_id', $user->id)->get();
    }

    return view('clientes', compact('clientes'));
}

    //============FUNCIÓN PARA CREAR CLIENTES=====================//
    public function store(Request $request){

        //VALIDACIÓN DE DATOS
         $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'ciudad' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
         ]);

         Cliente::create([
            'nombre'=> $request->nombre,
            'direccion'=> $request->direccion,
            'ciudad'=> $request->ciudad,
            'telefono'=> $request->telefono,
            'empleado_id'=> $request->empleado_id,
         ]);

         // Redirigir a donde se desee después de agregar el cliente
        return redirect()->route('home')->with('success', 'Cliente agregado con éxito');
    }
    //============FUNCIÓN PARA CREAR CLIENTES=====================//


    //===========================FUNCIÓN PARA EDITAR CLIENTES=====================//
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
        // Si no existe, regresar con mensaje de error
        return redirect()->route('clientes')
                         ->with('error', 'Cliente no encontrado');
    }

   
    $cliente->update($validatedData);

   
    return redirect()->route('clientes')
                     ->with('success', 'Cliente actualizado correctamente');
}
 //=========================FUNCIÓN PARA EDITAR CLIENTES=====================//



 //=============================FUNCIÓN PARA ELIMINAR CLIENTES====================//
    public function destroy($id)
{
    // Buscar el cliente por ID
    $cliente = Cliente::findOrFail($id);

    // Eliminar al cliente
    $cliente->delete();

    // Redirigir con un mensaje de éxito
    return redirect()->route('clientes')->with('success', 'Cliente eliminado con éxito');
}
//=============================FUNCIÓN PARA ELIMINAR CLIENTES====================//


//=============================FUNCIÓN PARA IMPORTAR CLIENTES====================//
public function import(Request $request)
{
    // Validar archivo
    $request->validate([
        'excel_file' => 'required|file|mimes:xlsx,xls,csv',
    ]);

    // 1️⃣ Borrar todos los clientes de manera segura
    Cliente::query()->delete(); // NO usamos truncate

    // 2️⃣ Importar nuevo Excel
    Excel::import(new ClientesImport, $request->file('excel_file'));

    return redirect()->back()->with('success', 'Clientes importados correctamente y tabla reemplazada.');
}

}
 //=============================FUNCIÓN PARA IMPORTAR CLIENTES====================//


   