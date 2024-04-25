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
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable();
            $table->string('descripcion')->nullable();
            $table->string('sede')->nullable();
            $table->string('cartel')->nullable();
            $table->dateTime('ini_convocatoria');
            $table->dateTime('ini_evento');
            $table->dateTime('fin_convocatoria');
            $table->unsignedSmallInteger('inscritos')->default(0);
            $table->boolean('es_acopio')->default(false);
            $table->timestamps();//created_at, updated_at
        });

        
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id();
            $table->string('rfc', 13)->nullable();
            $table->string('cp', 6)->nullable();
            $table->string('calle', 100)->nullable();
            $table->string('num_ext', 10)->nullable();
            $table->string('num_int', 10)->nullable();
            $table->string('colonia', 100)->nullable();
            $table->string('municipio', 100)->nullable();
            $table->string('estado', 80)->nullable();
            $table->string('telefono', 15)->nullable();
            $table->string('correo', 100)->nullable();
            $table->string('razon_social')->nullable();
            $table->string('giro_empresa', 100)->nullable();
            $table->timestamps();
        });

        Schema::create('registros', function (Blueprint $table) {
            //checar como guardar los certificados url/blob y si es posible minificar
            $table->string('cert_participacion')->nullable();
            $table->string('cert_b_practicas')->nullable();
            $table->decimal('costo', 4, 2)->default(0.00);//xxxx.xx max(9999.99)
            $table->boolean('compromiso_pago');
            $table->foreignId('user_id')
                ->constrained('users')->cascadeOnDelete();
            $table->foreignId('evento_id')
                ->constrained('eventos')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('residuos', function (Blueprint $table) {
            $table->id();
            $table->string('categoria');
            $table->string('unidad', 4)->default('Kg');
            $table->timestamps();
        });

        Schema::create('acopio_por_categorias', function (Blueprint $table) {
            $table->id();
            $table->decimal('total', 8, 2)->default(0.00);
            $table->foreignId('acopio_id')
                ->constrained('eventos')->cascadeOnDelete();
            $table->foreignId('residuo_id')
                ->constrained('residuos')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('entregas', function (Blueprint $table) {
            $table->decimal('cantidad', 8, 2)->default(0.00);

            $table->foreignId('categoria_id')
                ->constrained('acopio_por_categorias')->cascadeOnDelete();

            $table->foreignId('proveedor_id')
                ->constrained('proveedores')->cascadeOnDelete();

            $table->timestamps();
        });

        Schema::create('donaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('donados')->default(0);
            $table->unsignedSmallInteger('tomados')->default(0);
            $table->boolean('de_residuos')->default(false);

            $table->foreignId('capturista_id')
                ->constrained('users')->cascadeOnDelete();

            $table->foreignId('donador_id')
                ->constrained('users')->cascadeOnDelete();

            $table->foreignId('acopio_id')
                ->constrained('eventos')->cascadeOnDelete();

            $table->timestamps();
        });

        Schema::create('donacion_por_categorias', function (Blueprint $table) {
            $table->id();
            $table->decimal('cantidad', 4, 2)->default(0.00);

            $table->foreignId('donacion_id')
                ->constrained('donaciones')->cascadeOnDelete();
            $table->foreignId('residuo_id')
                ->constrained('residuos')->cascadeOnDelete();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos');
        Schema::dropIfExists('registros');
        Schema::dropIfExists('acopio_por_categorias');
        Schema::dropIfExists('donaciones');

        Schema::dropIfExists('donacion_por_categorias');
        Schema::dropIfExists('residuos');

        Schema::dropIfExists('entregas');
        Schema::dropIfExists('proveedores');

    }
};
