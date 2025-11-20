@extends('layouts.app')

@section('content')

{{-- ESTILOS CSS MODERNOS (Incrustados para asegurar que se vean bien sin instalar librerías) --}}
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f0f2f5;
    }

    .page-title {
        font-size: 1.5rem;
        color: #1f2937;
        font-weight: 700;
        margin: 0;
    }

    .btn-primary {
        background-color: #3b82f6;
        color: white;
        padding: 0.6rem 1.2rem;
        border-radius: 0.5rem;
        text-decoration: none;
        font-weight: 500;
        transition: background-color 0.2s;
    }
    .btn-primary:hover { background-color: #2563eb; }

    .table-container {
        background: white;
        border-radius: 0.75rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    thead {
        background-color: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
    }

    th {
        padding: 1rem;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        color: #6b7280;
        letter-spacing: 0.05em;
    }

    td {
        padding: 1rem;
        border-bottom: 1px solid #e5e7eb;
        color: #374151;
        vertical-align: middle;
    }

    tr:last-child td { border-bottom: none; }
    tr:hover { background-color: #f9fafb; }

    /* Badges para estados */
    .badge {
        padding: 0.25rem 0.6rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .badge-neutral { background-color: #e5e7eb; color: #374151; }
    
    /* Botones de acción pequeños */
    .action-btn {
        padding: 0.4rem 0.8rem;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        text-decoration: none;
        margin-right: 0.5rem;
        cursor: pointer;
        border: none;
        display: inline-block;
    }
    .btn-edit { background-color: #e0f2fe; color: #0284c7; }
    .btn-edit:hover { background-color: #bae6fd; }
    
    .btn-delete { background-color: #fee2e2; color: #dc2626; }
    .btn-delete:hover { background-color: #fecaca; }

    /* Alerta de éxito */
    .alert-success {
        background-color: #d1fae5;
        color: #065f46;
        padding: 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
        border: 1px solid #a7f3d0;
    }
</style>

<div class="container" style="max-width: 1000px; margin: 0 auto; padding: 20px;">
    
    {{-- Mensaje de Feedback (Éxito) --}}
    @if(session('success'))
        <div class="alert-success">
            <strong>¡Éxito!</strong> {{ session('success') }}
        </div>
    @endif

    {{-- Encabezado de la página --}}
    <div class="page-header">
        <h1 class="page-title">Gestión de Actividades</h1>
        <a href="{{ route('actividades.create') }}" class="btn-primary">
            + Nueva Actividad
        </a>
    </div>

    {{-- Tabla de Datos --}}
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Nota Asociada</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Fechas (Inicio - Fin)</th>
                    <th style="text-align: center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($actividades as $actividad)
                <tr>
                    {{-- Columna Nota: Negrita para destacar --}}
                    <td style="font-weight: 600;">
                        {{ $actividad->nota?->titulo ?? '— Sin asignar —' }}
                    </td> 
                    
                    {{-- Columna Descripción: Color suave --}}
                    <td style="color: #4b5563;">
                        {{ $actividad->descripcion }}
                    </td>

                    {{-- Columna Estado: Badge visual --}}
                    <td>
                        <span class="badge badge-neutral">{{ $actividad->estado }}</span>
                    </td>

                    {{-- Columna Fechas: Formato compacto --}}
                    <td style="font-size: 0.9rem;">
                        <div>In: {{ $actividad->fecha_inicio }}</div>
                        <div style="color: #9ca3af">Fin: {{ $actividad->fecha_fin }}</div>
                    </td>

                    {{-- Columna Acciones --}}
                    <td style="text-align: center">
                        {{-- Botón Editar --}}
                        <a href="{{ url('actividades/' . $actividad->id . '/edit') }}" class="action-btn btn-edit">
                            Editar
                        </a>
                        
                        {{-- Botón Eliminar (Formulario) --}}
                        <form action="{{ url('actividades/' . $actividad->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn btn-delete" onclick="return confirm('¿Estás seguro de borrar esta actividad permanentemente?')">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                {{-- Estado vacío: Si no hay actividades --}}
                <tr>
                    <td colspan="5" style="text-align: center; padding: 3rem; color: #9ca3af;">
                        No hay actividades registradas aún.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection