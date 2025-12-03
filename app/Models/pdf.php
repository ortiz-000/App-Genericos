<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pdf extends Model
{
    protected $fillable = [
        'nombre',
        'ruta',
        'empleado_id'
    ];



    // Relación con usuario
    public function empleado()
    {
        return $this->belongsTo(User::class, 'empleado_id');
    }
}
