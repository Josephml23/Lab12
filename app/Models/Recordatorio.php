<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recordatorio extends Model
{
    use HasFactory;

    protected $fillable = ['nota_id', 'fecha_vencimiento', 'completado'];

    // Relación: Recordatorio pertenece a una nota [cite: 28]
    public function nota()
    {
        return $this->belongsTo(Nota::class);
    }
}