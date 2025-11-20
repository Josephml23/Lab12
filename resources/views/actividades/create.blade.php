@extends('layouts.app') 

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1>Crear Nueva Actividad</h1>
            <a href="{{ route('actividades.index') }}" class="btn btn-secondary mb-3">Volver a Actividades</a>

            {{-- 1. El formulario apunta al método 'store' del controlador --}}
            <form action="{{ route('actividades.store') }}" method="POST">
                @csrf 

                {{-- Campo para seleccionar la Nota (FK) --}}
                <div class="form-group mb-3">
                    <label for="nota_id">Nota Asociada:</label>
                    <select name="nota_id" id="nota_id" class="form-control @error('nota_id') is-invalid @enderror" required>
                        <option value="">-- Seleccione una Nota --</option>
                        {{-- La variable $notas viene del método create() del controlador --}}
                        @foreach ($notas as $nota)
                            <option value="{{ $nota->id }}" {{ old('nota_id') == $nota->id ? 'selected' : '' }}>
                                {{ $nota->titulo }} (ID: {{ $nota->id }})
                            </option>
                        @endforeach
                    </select>
                    @error('nota_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Campo Descripción --}}
                <div class="form-group mb-3">
                    <label for="descripcion">Descripción:</label>
                    <input type="text" name="descripcion" id="descripcion" class="form-control @error('descripcion') is-invalid @enderror" value="{{ old('descripcion') }}" required>
                    @error('descripcion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Campo Estado (Ejemplo simple con select) --}}
                <div class="form-group mb-3">
                    <label for="estado">Estado:</label>
                    <select name="estado" id="estado" class="form-control @error('estado') is-invalid @enderror" required>
                        <option value="pendiente" {{ old('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="en progreso" {{ old('estado') == 'en progreso' ? 'selected' : '' }}>En Progreso</option>
                        <option value="completado" {{ old('estado') == 'completado' ? 'selected' : '' }}>Completado</option>
                    </select>
                    @error('estado')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Campo Fecha Inicio --}}
                <div class="form-group mb-3">
                    <label for="fecha_inicio">Fecha de Inicio:</label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control @error('fecha_inicio') is-invalid @enderror" value="{{ old('fecha_inicio') }}" required>
                    @error('fecha_inicio')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                {{-- Campo Fecha Fin --}}
                <div class="form-group mb-3">
                    <label for="fecha_fin">Fecha de Finalización:</label>
                    <input type="date" name="fecha_fin" id="fecha_fin" class="form-control @error('fecha_fin') is-invalid @enderror" value="{{ old('fecha_fin') }}">
                    @error('fecha_fin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Botón de Enviar --}}
                <button type="submit" class="btn btn-primary">Guardar Actividad</button>
            </form>
        </div>
    </div>
</div>
@endsection