<!DOCTYPE html>
<html>
<head>
    <title>Notes and Reminders</title>
    <!-- Usando Tailwind CDN para darle un poco de estilo, como en el ejemplo -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: Inter, sans-serif; background-color: #f4f7f9; }
        .container { max-width: 900px; }
    </style>
</head>
<body class="p-8">

    <div class="container mx-auto bg-white p-6 shadow-xl rounded-lg">
        <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">Notes and Reminders</h1>

        <!-- Mensaje de éxito -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Formulario para Crear Nota -->
        <h2 class="text-xl font-semibold text-gray-700 mb-4 border-b pb-2">Formulario para Crear Nota</h2>
        <form method="POST" action="{{ route('notas.store') }}" class="space-y-4 mb-10 p-4 border rounded-lg bg-gray-50">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-700">Seleccionar Usuario</label>
                    <select name="user_id" id="user_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                        @foreach (\App\Models\User::all() as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="titulo" class="block text-sm font-medium text-gray-700">Título Nota</label>
                    <input type="text" name="titulo" id="titulo" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                </div>
            </div>

            <div>
                <label for="contenido" class="block text-sm font-medium text-gray-700">Contenido</label>
                <textarea name="contenido" id="contenido" required rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border"></textarea>
            </div>

            <div>
                <label for="fecha_vencimiento" class="block text-sm font-medium text-gray-700">Fecha Vencimiento</label>
                <input type="datetime-local" name="fecha_vencimiento" id="fecha_vencimiento" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
            </div>

            <div class="text-center">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-150">
                    Añadir Nota
                </button>
            </div>
        </form>

        <!-- Listado de Usuarios y Notas -->
        <h2 class="text-xl font-semibold text-gray-700 mb-4 border-b pb-2">Listado de Notas Activas</h2>

        @foreach ($users as $user)
            <div class="mb-6 p-4 border rounded-lg shadow-sm bg-blue-50">
                <!-- Nombre y cantidad de notas activas (obtenido de la subconsulta) -->
                <h3 class="text-lg font-bold text-blue-800 mb-3">
                    Usuario: {{ $user->name }} 
                    <span class="text-sm bg-blue-200 text-blue-900 px-3 py-1 rounded-full ml-2">
                        {{ $user->total_notas }} Active Notes
                    </span>
                </h3>

                @if ($user->notas->count())
                    <div class="space-y-3">
                        @foreach ($user->notas as $nota)
                            <div class="p-3 border rounded-md bg-white shadow-xs">
                                <!-- Título formateado (usando el accesor: [Completado] si aplica) -->
                                <strong class="block text-gray-900">{{ $nota->titulo_formateado }}</strong>
                                <p class="text-gray-600 text-sm mb-1">{{ $nota->contenido }}</p>

                                <!-- Fecha de vencimiento y estado -->
                                <div class="text-xs text-gray-500 mt-1">
                                    Due: {{ $nota->recordatorio->fecha_vencimiento->format('Y-m-d H:i') }}
                                    @php
                                        $status = $nota->recordatorio->completado ? 'Completed' : 'Pending';
                                        $color = $nota->recordatorio->completado ? 'bg-gray-300 text-gray-800' : 'bg-yellow-200 text-yellow-800';
                                    @endphp
                                    <span class="ml-2 px-2 py-0.5 rounded-full {{ $color }} font-medium">
                                        {{ $status }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-sm">No tiene notas activas o visibles (revisa el alcance global).</p>
                @endif
            </div>
        @endforeach
    </div>

</body>
</html>