<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\Nota;
use Illuminate\Http\Request;

class ActividadController extends Controller
{
    // Muestra la lista de recursos
    public function index()
    {
        $actividades = Actividad::all();
        return view('actividades.index', compact('actividades'));
    }

    // Muestra el formulario para crear
    public function create()
    {
        $notas = Nota::all();
        return view('actividades.create', compact('notas'));
    }

    // Almacena un nuevo recurso en la DB
    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required',
            'nota_id' => 'required'
        ]);
        
        Actividad::create($request->all());
        return redirect()->route('actividades.index')->with('success', 'Actividad creada.');
    }

    // Muestra el recurso especificado
    // CAMBIO: Recibimos $id y buscamos manualmente
    public function show($id)
    {
        $actividad = Actividad::findOrFail($id);
        return view('actividades.show', compact('actividad'));
    }

    // Muestra el formulario para editar
    // CAMBIO: Recibimos $id y buscamos manualmente para evitar errores de ruta
    public function edit($id)
    {
        $actividad = Actividad::findOrFail($id);
        $notas = Nota::all();
        return view('actividades.edit', compact('actividad', 'notas'));
    }

    // Actualiza el recurso en la DB
    // CAMBIO: Recibimos $id
    public function update(Request $request, $id)
    {
        $actividad = Actividad::findOrFail($id); // Buscamos la actividad real

        $request->validate(['descripcion' => 'required']);
        $actividad->update($request->all());
        
        return redirect()->route('actividades.index')->with('success', 'Actividad actualizada.');
    }

    // Elimina el recurso de la DB
    // CAMBIO IMPORTANTE: Recibimos el $id directamente
    public function destroy($id)
    {
        // 1. Buscamos la actividad específica por su ID.
        // Si no existe, findOrFail lanzará un error 404 (mucho mejor que fallar en silencio).
        $actividad = Actividad::findOrFail($id);

        // 2. Ahora sí, la borramos.
        $actividad->delete();

        return redirect()->route('actividades.index')->with('success', 'Actividad eliminada.');
    }
}