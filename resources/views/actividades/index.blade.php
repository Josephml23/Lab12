@extends('layouts.app') 

@section('content')
<h1>Gestión de Actividades</h1>

<a href="{{ route('actividades.create') }}">Crear Nueva Actividad</a>

<table>
    <thead>
        <tr>
            <th>Nota</th>
            <th>Descripción</th>
            <th>Estado</th>
            <th>Inicio</th>
            <th>Fin</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($actividades as $actividad)
        <tr>
            <td>{{ $actividad->nota?->titulo ?? 'Sin Nota' }}</td> 
            
            <td>{{ $actividad->descripcion }}</td>
            <td>{{ $actividad->estado }}</td>
            <td>{{ $actividad->fecha_inicio }}</td>
            <td>{{ $actividad->fecha_fin }}</td>
            <td>
                <a href="{{ url('actividades/' . $actividad->id . '/edit') }}">Editar</a>
                
                <form action="{{ url('actividades/' . $actividad->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection