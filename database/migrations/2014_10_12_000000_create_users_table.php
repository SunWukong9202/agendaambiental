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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('clave', 7)->nullable()->unique();
            $table->string('nombre', 40);
            $table->string('ap_mat', 40);
            $table->string('ap_pat', 40);
            $table->string('genero', 15)->nullable();
            $table->string('procedencia', 40);
            $table->string('correo', 60);
            $table->string('telefono', 15);
            $table->string('password');
            $table->boolean('externo')->default(false);
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
