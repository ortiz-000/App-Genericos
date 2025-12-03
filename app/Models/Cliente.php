<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'direccion',
        'ciudad',
        'telefono',
        'empleado_id',   // ← IMPORTANTE
    ];
    public function empleado()
{
    return $this->belongsTo(User::class, 'empleado_id');
}

}
