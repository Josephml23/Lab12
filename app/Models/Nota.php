<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany; // <-- Importado
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Nota extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'titulo', 'contenido', 'pinned', 'prioridad']; // Agregué pinned y prioridad

    protected static function booted()
    {
        parent::booted(); // Llama al booted padre

        // Hook para eliminar dependencias antes de la eliminación de la nota
        static::deleting(function (Nota $nota) {
            // Elimina Recordatorio (HasOne)
            if ($nota->recordatorio) {
                $nota->recordatorio->delete(); 
            }
            // Elimina Actividades (HasMany)
            $nota->actividades()->delete();
        });

        // Alcance global: Solo mostrará notas activas (con recordatorios futuros y no completados)
        static::addGlobalScope('activa', function (Builder $builder) {
            $builder->whereHas('recordatorio', function ($query) {
                $query->where('fecha_vencimiento', '>=', now())->where('completado', false);
            });
        });
    }

    // Accesor: Formatear título con estado
    public function getTituloFormateadoAttribute()
    {
        // Se debe usar $this->recordatorio, pero se debe verificar si existe para evitar errores
        return optional($this->recordatorio)->completado ? "[Completado] {$this->titulo}" : $this->titulo;
    }

    // Scope Local: Usado específicamente para el conteo de la subconsulta en el controlador
    public function scopeActivaParaConteo(Builder $query): Builder
    {
        return $query->whereHas('recordatorio', function ($q) {
            $q->where('fecha_vencimiento', '>=', now())->where('completado', false);
        });
    }
    
    // Relación: Nota pertenece a un usuario (∞ <- 1)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relación: Nota tiene un recordatorio (1 -> 1)
    public function recordatorio(): HasOne
    {
        return $this->hasOne(Recordatorio::class);
    }
    
    // Relación NUEVA: Nota tiene muchas actividades (1 -> ∞)
    public function actividades(): HasMany
    {
        return $this->hasMany(Actividad::class);
    }
}