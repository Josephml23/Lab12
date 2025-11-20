<?php
namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\Nota; // Asegúrate de importar Nota
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
        $notas = Nota::all(); // Se necesitan las notas para asignar la actividad
        return view('actividades.create', compact('notas'));
    }

    // Almacena un nuevo recurso en la DB
    public function store(Request $request)
    {
        $request->validate(['descripcion' => 'required', 'nota_id' => 'required']);
        Actividad::create($request->all());
        return redirect()->route('actividades.index')->with('success', 'Actividad creada.');
    }

    // Muestra el recurso especificado
    public function show(Actividad $actividad)
    {
        return view('actividades.show', compact('actividad'));
    }

    // Muestra el formulario para editar
    public function edit(Actividad $actividad)
    {
        $notas = Nota::all();
        return view('actividades.edit', compact('actividad', 'notas'));
    }

    // Actualiza el recurso en la DB
    public function update(Request $request, Actividad $actividad)
    {
        $request->validate(['descripcion' => 'required']);
        $actividad->update($request->all());
        return redirect()->route('actividades.index')->with('success', 'Actividad actualizada.');
    }

    // Elimina el recurso de la DB
    public function destroy(Actividad $actividad)
    {
        $actividad->delete();
        return redirect()->route('actividades.index')->with('success', 'Actividad eliminada.');
    }
}