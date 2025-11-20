<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 🚨 CAMBIO CLAVE: Agregamos la verificación para evitar el error "Table already exists"
        if (!Schema::hasTable('recordatorios')) { 
            Schema::create('recordatorios', function (Blueprint $table) {
                $table->id();
                
                // Clave Foránea: nota_id con eliminación en cascada
                $table->foreignId('nota_id')->constrained()->onDelete('cascade');
                
                $table->dateTime('fecha_vencimiento');
                $table->boolean('completado')->default(false);
                
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('recordatorios');
    }
};