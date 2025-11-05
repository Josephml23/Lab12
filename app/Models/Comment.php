<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // Campos que se pueden asignar masivamente
    protected $fillable = ['body', 'user_id', 'post_id'];

    /**
     * Relación: Un comentario pertenece a un usuario (User).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación: Un comentario pertenece a una publicación (Post).
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}