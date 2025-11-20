<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('actividades', function (Blueprint $table) {
            $table->id();
            // Clave Foránea a 'notas' con eliminación en cascada (Cascade Delete) 
            $table->foreignId('nota_id')->constrained('notas')->onDelete('cascade');
            // Columnas de la tabla actividades 
            $table->string('descripcion');
            $table->string('estado');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('actividades');
    }
};