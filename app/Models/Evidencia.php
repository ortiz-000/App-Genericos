<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evidencia extends Model
{
    protected $fillable = [
        'accesor_comercial',
        'usuario',
        'nombre_establecimiento',
        'ciudad_establecimiento',
        'ubicacion',
        'motivo',
        'otro',
        'foto_establecimiento',
        'empleado_id',
    ];
}
