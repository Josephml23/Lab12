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
                // Usamos Nota::query() para empezar la consulta de la tabla 'notas'
                'total_notas' => Nota::query()
                    ->selectRaw('count(*)')
                    // La columna user_id en la tabla 'notas' se compara con la 'id' de la tabla 'users'
                    ->whereColumn('notas.user_id', 'users.id') 
                    // Usamos el scope local del modelo Nota para filtrar notas activas
                    ->activaParaConteo() 
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