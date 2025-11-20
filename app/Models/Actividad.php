<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Actividad extends Model
{
    // 🚨 AGREGAR ESTA LÍNEA PARA FORZAR EL NOMBRE DE LA TABLA
    protected $table = 'actividades'; 
    // ... el resto del código ...
    
    protected $fillable = [
        'nota_id',
        'descripcion',
        'estado',
        'fecha_inicio',
        'fecha_fin',
    ];

    public function nota(): BelongsTo
    {
        return $this->belongsTo(Nota::class);
    }
}