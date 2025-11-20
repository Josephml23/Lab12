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
        // Verifica si la tabla 'notas' no existe para evitar el error "Table already exists"
        if (!Schema::hasTable('notas')) {
            Schema::create('notas', function (Blueprint $table) {
                $table->id();
                
                // Clave Foránea: user_id (FK) con eliminación en cascada (si el usuario se borra)
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                
                $table->string('titulo');
                $table->text('contenido');
                
                // Opcionales para Eloquent avanzado (si no están en tu BD, omítelos o agrégalos)
                // $table->boolean('pinned')->default(false);
                // $table->enum('prioridad', ['baja', 'media', 'alta'])->default('media');
                
                // Borrado Lógico (deleted_at)
                $table->softDeletes(); 
                
                // created_at y updated_at
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notas');
    }
};  