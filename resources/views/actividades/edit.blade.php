@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Actividad</h1>

    <form action="{{ url('actividades/' . $actividad->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 15px;">
            <label for="nota_id">Nota:</label>
            <select name="nota_id" id="nota_id" required>
                @foreach($notas as $nota)
                    <option value="{{ $nota->id }}" {{ $actividad->nota_id == $nota->id ? 'selected' : '' }}>
                        {{ $nota->titulo }}
                    </option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label for="descripcion">Descripción:</label>
            <input type="text" name="descripcion" id="descripcion" value="{{ $actividad->descripcion }}" required>
        </div>

        <div style="margin-bottom: 15px;">
            <label for="estado">Estado:</label>
            <input type="text" name="estado" id="estado" value="{{ $actividad->estado }}" required>
        </div>

        <div style="margin-bottom: 15px;">
            <label for="fecha_inicio">Fecha Inicio:</label>
            <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ $actividad->fecha_inicio }}" required>
        </div>

        <div style="margin-bottom: 15px;">
            <label for="fecha_fin">Fecha Fin:</label>
            <input type="date" name="fecha_fin" id="fecha_fin" value="{{ $actividad->fecha_fin }}" required>
        </div>

        <button type="submit">Actualizar Actividad</button>
        <a href="{{ route('actividades.index') }}" style="margin-left: 10px;">Cancelar</a>
    </form>
</div>
@endsection