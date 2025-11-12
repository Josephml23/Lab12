<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Nota;
use Illuminate\Http\Request;

class NotaController extends Controller
{
    public function index()
    {
        // Cargar usuarios con sus notas activas, recordatorios, y subconsulta para el total de notas activas
        $users = User::with(['notas', 'notas.recordatorio'])
            ->addSelect([
                'total_notas' => Nota::selectRaw('count(*)')
                    ->whereColumn('user_id', 'users.id')
                    // Filtra solo las notas que cumplen con el alcance global 'activa'
                    ->whereHas('recordatorio', fn($query) => $query->where('fecha_vencimiento', '>=', now())->where('completado', false))
            ])
            ->get();

        return view('notas.index', compact('users'));
    }

    // Crear una nota con un recordatorio
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'fecha_vencimiento' => 'required|date|after:now',
        ]);

        $note = Nota::create([
            'user_id' => $validated['user_id'],
            'titulo' => $validated['titulo'],
            'contenido' => $validated['contenido'],
        ]);

        $note->recordatorio()->create([
            'fecha_vencimiento' => $validated['fecha_vencimiento'],
        ]);

        return redirect()->route('notas.index')->with('success', 'Nota creada!');
    }
}