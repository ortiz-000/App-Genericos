<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Cliente;
use Illuminate\Support\Str;

class ClientesImport implements ToModel, WithHeadingRow
{
    
  public function model(array $row)
{
    $row = array_change_key_case($row, CASE_LOWER);

    $nombre    = $row['nombre'] ?? $row['name'] ?? 'Sin nombre';
    $direccion = $row['direccion'] ?? $row['direcci'] ?? $row['dirección'] ?? 'Sin dirección';
    $ciudad    = $row['ciudad'] ?? 'Sin ciudad';
    $telefono  = $row['telefono'] ?? $row['teléfono'] ?? 'Sin teléfono';
    $zona      = $row['zona'];

    return new Cliente([
        'nombre'      => $nombre,
        'direccion'   => $direccion,
        'ciudad'      => $ciudad,
        'telefono'    => $telefono,
        'empleado_id' => $zona,
    ]);
}

}
