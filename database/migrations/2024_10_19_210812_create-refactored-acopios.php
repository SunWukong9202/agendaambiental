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
        Schema::create('events', function (Blueprint $table): void {
            $table->id();
            $table->string('name', 124);
            $table->string('faculty', 80);
            $table->string('description');
            $table->dateTime('start');
            $table->dateTime('end');

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('suppliers', function (Blueprint $table): void {
            $table->id();
            $table->string('name', 80);
            $table->string('tax_id', 16)->nullable(); // RFC
            $table->string('postal_code', 6)->nullable(); // CP
            $table->string('street', 64)->nullable(); // Calle
            $table->string('ext_number', 10)->nullable(); // Num_ext
            $table->string('int_number', 10)->nullable(); // Num_int
            $table->string('neighborhood', 64)->nullable(); // Colonia
            $table->string('town', 64)->nullable(); // Municipio
            $table->string('state', 64)->nullable(); // Estado
            $table->string('phone_number', 17)->nullable(); // Telefono
            $table->string('email', 80)->nullable(); // Correo
            $table->string('business_name', 128)->nullable(); // Razon_social
            $table->string('business_activity', 80)->nullable(); // Giro_empresa
            $table->timestamps();
        });

        Schema::create('wastes', function (Blueprint $table): void {
            $table->id();
            $table->string('category', 32);
            $table->string('unit', 4)->default('Kg');
            $table->timestamps();
        });
        
        //deliveries: this will be use better as a relation 
        Schema::create('event_supplier', function (Blueprint $table): void {
            $table->id();
            $table->decimal('quantity', 8, 3);//max: 99.999 toneladas o 99 999.999 kg
            $table->foreignId('waste_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            $table->foreignId('supplier_id')->constrained()->cascadeOnDelete();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
        //donations: we could use this as a pivot model or not
        Schema::create('event_user', function (Blueprint $table): void {
            $table->id();
            $table->string('type', 16);//waste, books
            $table->tinyInteger('books_taken')->default(0);
            $table->tinyInteger('books_donated')->default(0);
            
            $table->decimal('quantity', 6, 3)->nullable();//max 999.999 kg
            $table->foreignId('waste_id')->nullable()->constrained()->cascadeOnDelete();

            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('donator_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_user');
        Schema::dropIfExists('event_supplier');
        Schema::dropIfExists('wastes');
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('events');        
    }
};
