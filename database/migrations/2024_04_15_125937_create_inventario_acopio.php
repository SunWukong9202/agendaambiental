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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->unsignedInteger('cantidad')->default(0);
            $table->boolean('es_refaccion')->default(false);
            $table->timestamps();
        });

        Schema::create('solicitud_productos', function (Blueprint $table) {
            $table->id();
            $table->string('comentario')->nullable();
            $table->string('estado');
            $table->foreignId('solicitante_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('producto_id')->constrained('productos')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('captura_productos', function (Blueprint $table) {
            $table->id();
            $table->string('observaciones')->nullable();
            $table->string('condicion');
            $table->foreignId('capturista_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('producto_id')->constrained('productos')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('reparaciones', function (Blueprint $table) {
            $table->id();
            $table->string('observaciones')->nullable();
            $table->string('estado');
            // $table->string('asignacion')->nullable();
            $table->foreignId('captura_id')->constrained('captura_productos')->cascadeOnDelete();
            $table->foreignId('revisado_por')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('refacciones', function (Blueprint $table) {
            $table->unsignedSmallInteger('cantidad');    
            // en caso de no querer obligar a crear la refaccion necesitamos este campo        
            // $table->string('nombre')->nullable(); <-- 
            $table->foreignId('reparacion_id')->constrained('reparaciones')->cascadeOnDelete();
            $table->foreignId('producto_id')->constrained('productos')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
        Schema::dropIfExists('captura_productos');
        Schema::dropIfExists('solicitud_productos');
        
        Schema::dropIfExists('reparaciones');
        Schema::dropIfExists('refacciones');
    }
};
