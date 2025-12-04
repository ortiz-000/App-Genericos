<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pdf extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'ruta',
        'empleado_id',
        'creado_por',
    ];

    // Relación con el usuario asignado
    public function empleado()
    {
        return $this->belongsTo(User::class, 'empleado_id');
    }

    // Relación con el usuario que subió el PDF
    public function creador()
    {
        return $this->belongsTo(User::class, 'creado_por');
    }
}

