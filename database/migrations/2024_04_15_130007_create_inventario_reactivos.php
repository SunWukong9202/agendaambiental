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
            $table->decimal('total', 10, 2)->default(0.00);//max 99 999 999.99 unidades almacenables
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('solicitudes_reactivos', function (Blueprint $table) {
            $table->id();
            $table->decimal('cantidad', 6, 2);// max 9 999.99 u/solictud
            $table->string('comentario')->nullable();
            $table->string('otro_reactivo')->nullable();
            $table->boolean('estado')->default(false);

            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('reactivo_id')->nullable()
                ->default(null)->constrained('reactivos')
                ->cascadeOnDelete();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });

        Schema::create('donaciones_reactivos', function (Blueprint $table) {
            $table->id();
            $table->string('foto')->nullable();
            $table->string('envase', 40);
            $table->decimal('peso', 7, 2)->default(0.00);//peso con envase
            $table->decimal('cantidad', 6, 2)->default(0.00); //max 9 999.99 u/captura
            $table->string('estado', 1);//solido, liquido, gaseoso
            $table->dateTime('caducidad');
            $table->string('condicion', 2);//nuevo, seminuevo, usado
            $table->string('fac_proc')->nullable();//facultad_procedencia
            $table->string('lab_proc')->nullable();//laboratorio_procedencia
// $table->string('donador')->nullable(); sustituido por resposanble_id
            $table->string('CRETIB', 30)->nullable();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('reactivo_id')->constrained('reactivos')->cascadeOnDelete();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reactivos');
        Schema::dropIfExists('solicitudes_reactivos');
        Schema::dropIfExists('donaciones_reactivos');
    }
};
