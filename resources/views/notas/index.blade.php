<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes and Reminders</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .container { max-width: 900px; margin: 0 auto; }
        .form-card, .user-card, .note-item { border: 1px solid #ccc; padding: 15px; margin-bottom: 20px; border-radius: 5px; }
        .user-card h3 { border-bottom: 1px solid #eee; padding-bottom: 10px; }
        .note-item { margin-top: 10px; border-left: 3px solid #007bff; background-color: #f8f9fa; }
        .badge { padding: 3px 8px; border-radius: 10px; color: white; font-size: 0.8em; margin-left: 5px; }
        .badge-pending { background-color: orange; }
        .badge-completed { background-color: green; }
        .active-notes-count { float: right; background-color: #007bff; color: white; padding: 5px 10px; border-radius: 3px; }
        label, input, select, textarea { display: block; width: 100%; box-sizing: border-box; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Notes and Reminders</h1>

        @if (session('success'))
            <div style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 20px; border: 1px solid #c3e6cb; border-radius: 5px;">
                {{ session('success') }}
            </div>
        @endif

        <div class="form-card">
            <h2>Formulario para Crear Nota</h2>
            <form action="{{ route('notas.store') }}" method="POST">
                @csrf
                <label for="user_id">Seleccionar Usuario</label>
                <select name="user_id" id="user_id" required>
                    @foreach (App\Models\User::all() as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>

                <label for="titulo">Título Nota</label>
                <input type="text" name="titulo" id="titulo" required>

                <label for="contenido">Contenido</label>
                <textarea name="contenido" id="contenido" required></textarea>

                <label for="fecha_vencimiento">Fecha Vencimiento</label>
                <input type="datetime-local" name="fecha_vencimiento" id="fecha_vencimiento" required>

                <button type="submit" style="background-color: #007bff; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">Añadir Nota (Botón Azul)</button>
            </form>
        </div>

        @foreach ($users as $user)
            <div class="user-card">
                <h3>Usuario: {{ $user->name }} <span class="active-notes-count">{{ $user->total_notas }} Active Notes</span></h3>
                
                @forelse ($user->notas as $nota)
                    <div class="note-item">
                        <strong>- {{ $nota->titulo_formateado }}</strong>
                        <p>{{ $nota->contenido }}</p>
                        <p>Due: {{ \Carbon\Carbon::parse($nota->recordatorio->fecha_vencimiento)->format('Y-m-d H:i') }} 
                            <span class="badge {{ $nota->recordatorio->completado ? 'badge-completed' : 'badge-pending' }}">
                                {{ $nota->recordatorio->completado ? 'Completed' : 'Pending' }}
                            </span>
                        </p>
                    </div>
                @empty
                    <p>No tiene notas activas.</p>
                @endforelse
            </div>
        @endforeach

    </div>
</body>
</html>