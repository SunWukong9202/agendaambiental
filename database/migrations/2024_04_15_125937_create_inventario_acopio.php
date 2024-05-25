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
        Schema::create('articulos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->unsignedInteger('cantidad')->default(0);
            $table->boolean('es_refaccion')->default(false);
            $table->timestamps();
        });

        Schema::create('solicitudes_articulos', function (Blueprint $table) {
            $table->id();
            $table->string('comentario')->nullable();
            $table->string('otro_articulo')->nullable();
            $table->boolean('estado')->default(false);
            $table->foreignId('solicitante_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('articulo_id')
                ->nullable()
                ->default(null)
                ->constrained('articulos')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('capturas_articulos', function (Blueprint $table) {
            $table->id();
            $table->string('observaciones')->nullable();
            $table->string('condicion');
            $table->foreignId('capturista_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('articulo_id')->constrained('articulos')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('reparaciones', function (Blueprint $table) {
            $table->id();
            $table->string('observaciones')->nullable();
            $table->string('estado');
            // $table->string('asignacion')->nullable();
            $table->foreignId('captura_id')->constrained('capturas_articulos')->cascadeOnDelete();
            $table->foreignId('revisado_por')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('refacciones', function (Blueprint $table) {
            $table->unsignedSmallInteger('cantidad');    
            // en caso de no querer obligar a crear la refaccion necesitamos este campo        
            // $table->string('nombre')->nullable(); <-- 
            $table->foreignId('reparacion_id')->constrained('reparaciones')->cascadeOnDelete();
            $table->foreignId('articulo_id')->constrained('articulos')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articulos');
        Schema::dropIfExists('capturas_articulos');
        Schema::dropIfExists('solicitudes_articulos');
        
        Schema::dropIfExists('reparaciones');
        Schema::dropIfExists('refacciones');
    }
};
