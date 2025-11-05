<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            // Clave foránea al Post, con eliminación en cascada
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            // Clave foránea al User, con eliminación en cascada
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // Contenido del comentario
            $table->text('body');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};