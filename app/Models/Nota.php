<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Nota extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'titulo', 'contenido'];

    // Alcance global: Solo mostrará notas activas (con recordatorios futuros y no completados)
    protected static function booted()
    {
        static::addGlobalScope('activa', function (Builder $builder) {
            $builder->whereHas('recordatorio', function ($query) {
                $query->where('fecha_vencimiento', '>=', now())->where('completado', false);
            });
        });
    }

    // Accesor: Formatear título con estado
    public function getTituloFormateadoAttribute()
    {
        return $this->recordatorio->completado ? "[Completado] {$this->titulo}" : $this->titulo;
    }

    // Scope Local: Usado específicamente para el conteo de la subconsulta en el controlador
    public function scopeActivaParaConteo(Builder $query)
    {
        return $query->whereHas('recordatorio', function ($q) {
            $q->where('fecha_vencimiento', '>=', now())->where('completado', false);
        });
    }
    
    // Relación: Nota pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación: Nota tiene un recordatorio
    public function recordatorio()
    {
        return $this->hasOne(Recordatorio::class);
    }
}