<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct()
    {
        // Solo usuarios autenticados pueden comentar o eliminar
        $this->middleware('auth');
    }

    /**
     * Almacena un nuevo comentario para un post específico.
     */
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        $post->comments()->create([
            'body' => $request->body,
            'user_id' => Auth::id(), // Asigna automáticamente el ID del usuario autenticado
        ]);

        return redirect()->route('posts.show', $post)->with('success', 'Comentario publicado.');
    }

    /**
     * Elimina un comentario.
     */
    public function destroy(Comment $comment)
    {
        // Verifica que solo el autor del comentario pueda eliminarlo
        if ($comment->user_id !== Auth::id()) {
            abort(403, 'No tienes permiso para eliminar este comentario.');
        }

        $comment->delete();

        // Redirige de vuelta a la publicación original
        return redirect()->route('posts.show', $comment->post)->with('success', 'Comentario eliminado.');
    }
}