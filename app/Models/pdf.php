<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pdf extends Model
{
    use HasFactory;

    protected $table = 'pdfs'; // ajusta si tu tabla tiene otro nombre

    // Campos que se pueden llenar de forma masiva
    protected $fillable = [
        'nombre',
        'ruta',
        'empleado_id',
    ];

    // Relación con el usuario (empleado)
    public function empleado()
    {
        return $this->belongsTo(User::class, 'empleado_id');
    }
}
