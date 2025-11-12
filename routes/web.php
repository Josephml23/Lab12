<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // Asegúrate de que esta línea esté presente si usas Auth::routes()
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NotaController;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('home'); // Si estás logeado, te envía al Dashboard/Posts.
    }
    return redirect()->route('login'); // Si NO estás logeado, te envía directamente al formulario de Login.
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Rutas para las publicaciones (ya existentes)
Route::resource('posts', PostController::class);

// Rutas para los comentarios <<---- NUEVAS RUTAS PARA COMENTARIOS
// Almacena un comentario: POST /posts/{post}/comments
Route::post('posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
// Elimina un comentario: DELETE /comments/{comment}
Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
Route::get('/notas', [NotaController::class, 'index'])->name('notas.index');
Route::post('/notas', [NotaController::class, 'store'])->name('notas.store');