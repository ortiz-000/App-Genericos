<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inspeccion extends Model
{
    use HasFactory;

    protected $table = 'inspecciones';

    protected $fillable = [
        'user_id',
        'vehiculo',
        'fecha_inspeccion',
        'hora_inspeccion',
        'arranque_realizado',
        'mensajero',
        'email',
        'ruta',
        'ruta_otro',
        'condiciones_conductor',
        'placa',
        'placa_otro',
        'vencimiento_soat',
        'vencimiento_tecnomecanica',
        'vencimiento_licencia',
        'kilometraje',
        'uniforme',
        'casco',
        'chaleco',
        'botas',
        'impermeable',
        'cinturon',
        'documentos',
    ];

    protected $casts = [
        'documentos' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
