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
        Schema::create('reactivos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('grupo');
            $table->string('formula');
            $table->string('unidad');
            $table->boolean('visible')->default(true);
            $table->decimal('total', 8, 2)->default(0.00);//max 99 999 999.99 unidades almacenables
            $table->timestamps();
        });

        Schema::create('solicitud_reactivos', function (Blueprint $table) {
            $table->id();
            $table->decimal('cantidad', 4, 2);// max 9 999.99 u/solictud
            $table->string('observaciones')->nullable();
            $table->string('otro_reactivo')->nullable();
            $table->string('estado', 2);
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('reactivo_id')->constrained('reactivos')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('captura_reactivos', function (Blueprint $table) {
            $table->id();
            $table->string('foto')->nullable();
            $table->string('envase')->nullable();
            $table->decimal('peso', 5, 2)->default(0.00);//peso con envase
            $table->decimal('cantidad', 4, 2)->default(0.00); //max 9 999.99 u/captura
            $table->string('estado');//solido, liquido, gaseoso
            $table->dateTime('caducidad');
            $table->string('condicion');//nuevo, seminuevo, usado
            $table->string('facultad_procedencia')->nullable();
            $table->string('laboratorio_procedencia')->nullable();
// $table->string('donador')->nullable(); sustituido por resposanble_id
            $table->string('CRETIB')->nullable();
            $table->foreignId('responsable_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('reactivo_id')->constrained('reactivos')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reactivos');
        Schema::dropIfExists('solicitud_reactivos');
        Schema::dropIfExists('captura_reactivos');
    }
};
