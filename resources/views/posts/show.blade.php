@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- Contenido de la Publicación -->
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h1 class="card-title">{{ $post->title }}</h1>
                <p class="card-text">{{ $post->content }}</p>
                <p class="card-text"><small class="text-muted">Publicado por: {{ $post->user->name }}</small></p>
                
                {{-- Opciones de edición/eliminación del post --}}
                @if ($post->user_id === Auth::id())
                    <hr>
                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-warning btn-sm">Editar Publicación</a>
                    <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Seguro que quieres eliminar esta publicación?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Eliminar Publicación</button>
                    </form>
                @endif
                
                <hr>
                <a href="{{ route('posts.index') }}" class="btn btn-secondary btn-sm">← Volver a Publicaciones</a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Sección de Comentarios -->
        <h3 class="mb-3">Comentarios ({{ $post->comments->count() }})</h3>

        <!-- Formulario para Agregar Comentario -->
        @auth
            <div class="card mb-4">
                <div class="card-body bg-light">
                    <h5 class="card-title">Añadir un comentario</h5>
                    <form action="{{ route('comments.store', $post) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <textarea name="body" class="form-control" rows="3" placeholder="Escribe tu comentario aquí..." required></textarea>
                            @error('body')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Comentar</button>
                    </form>
                </div>
            </div>
        @else
            <div class="alert alert-info">Debes <a href="{{ route('login') }}">iniciar sesión</a> para comentar.</div>
        @endauth

        <!-- Lista de Comentarios -->
        <div class="comments-list">
            {{-- Ordena los comentarios por fecha de creación descendente para ver los más nuevos primero --}}
            @forelse ($post->comments->sortByDesc('created_at') as $comment)
                <div class="card mb-2">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <p class="mb-1">
                                <strong>{{ $comment->user->name }}</strong> 
                                <small class="text-muted"> - {{ $comment->created_at->diffForHumans() }}</small>
                            </p>
                            
                            {{-- Botón de Eliminar solo visible para el autor del comentario --}}
                            @if (Auth::check() && $comment->user_id === Auth::id())
                                <form action="{{ route('comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este comentario?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-2" title="Eliminar Comentario">
                                        &times;
                                    </button>
                                </form>
                            @endif
                        </div>
                        <p class="card-text mt-1">{{ $comment->body }}</p>
                    </div>
                </div>
            @empty
                <p>Sé el primero en comentar esta publicación.</p>
            @endforelse
        </div>
    </div>
@endsection