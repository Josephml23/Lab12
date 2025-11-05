@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <!-- Enlace a Font Awesome para iconos -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <!-- Estilos CSS personalizados para las tarjetas y el fondo -->
        <style>
            body {
                background-color: #f0f2f5; /* Fondo gris claro */
            }
            .custom-card {
                border-radius: 12px;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            }
            .custom-card:hover {
                transform: translateY(-5px); /* Efecto de elevación al pasar el ratón */
                box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            }
            .btn-primary-custom {
                background-color: #1a73e8; /* Azul */
                border-color: #1a73e8;
                transition: background-color 0.3s ease;
            }
            .btn-primary-custom:hover {
                background-color: #1565c0;
                border-color: #1565c0;
            }
            .floating-btn {
                position: fixed;
                bottom: 30px;
                right: 30px;
                width: 60px;
                height: 60px;
                border-radius: 50%;
                font-size: 24px;
                line-height: 1;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
                z-index: 1000;
            }
        </style>

        <h1 class="display-5 text-center mb-5 text-dark">
            <i class="fas fa-newspaper me-2 text-primary-custom"></i>
            Explora las Publicaciones
        </h1>

        <!-- Mensaje de éxito -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @forelse ($posts as $post)
                <div class="col">
                    <div class="card h-100 custom-card">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-primary mb-2">{{ $post->title }}</h5>
                            <p class="card-text text-muted mb-4">{{ Str::limit($post->content, 120) }}</p>

                            <div class="mt-auto d-flex justify-content-between align-items-center pt-2 border-top">
                                <small class="text-secondary">
                                    <i class="fas fa-user-circle me-1"></i> Por: {{ $post->user->name }}
                                </small>
                                <span class="badge bg-secondary rounded-pill">
                                    <i class="fas fa-comment-dots me-1"></i> {{ $post->comments->count() }}
                                </span>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-top-0 d-flex justify-content-end gap-2">
                            <a href="{{ route('posts.show', $post) }}" class="btn btn-sm btn-outline-info">
                                <i class="fas fa-eye me-1"></i> Ver
                            </a>

                            @can('update', $post)
                                <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="fas fa-edit me-1"></i> Editar
                                </a>
                            @endcan

                            @can('delete', $post)
                                <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta publicación?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash me-1"></i> Eliminar
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center custom-card p-4">
                        <h4 class="alert-heading"><i class="fas fa-info-circle me-2"></i> ¡No hay publicaciones aún!</h4>
                        <p class="mb-0">Sé el primero en crear una. Haz clic en el botón 'Nueva Publicación'.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Botón flotante para crear nueva publicación (Visible solo si está autenticado) -->
        @auth
            <a href="{{ route('posts.create') }}" class="btn btn-primary-custom floating-btn d-flex align-items-center justify-content-center" title="Crear nueva publicación">
                <i class="fas fa-plus"></i>
            </a>
        @endauth
    </div>
@endsection