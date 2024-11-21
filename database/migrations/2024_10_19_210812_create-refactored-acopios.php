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
        //control module users
        Schema::create('cm_users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 80)->nullable();
            $table->string('gender', 32)->nullable();
            $table->string('email', 60)->nullable();
            $table->string('phone_number', 17)->nullable();
            $table->string('locale', 32)->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('events', function (Blueprint $table): void {
            $table->id();
            $table->string('name', 124);
            $table->string('faculty', 80);
            $table->string('description')->nullable();
            $table->dateTime('start');
            $table->dateTime('end');
            //creador/{admin|permisos}
            $table->foreignId('cm_user_id')->constrained()->cascadeOnDelete();
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
            $table->foreignId('cm_user_id')->constrained()->cascadeOnDelete();
            
            $table->foreignId('supplier_id')->constrained()->cascadeOnDelete();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
        //type,books_taken, books_donated, quantity, waste_id, event_id,
        //cm_user_id, donator_id 
        //donations: we could use this as a pivot model or not
        Schema::create('cm_user_event', function (Blueprint $table): void {
            $table->id();
            $table->boolean('type');//waste, books
            $table->tinyInteger('books_taken')->nullable();
            $table->tinyInteger('books_donated')->nullable();
            
            $table->decimal('quantity', 6, 3)->nullable();//max 999.999 kg
            $table->foreignId('waste_id')->nullable()->constrained()->cascadeOnDelete();

            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('cm_user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('donator_id')->constrained('cm_users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cm_user_event');
        Schema::dropIfExists('event_supplier');
        Schema::dropIfExists('wastes');
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('events');
        Schema::dropIfExists('cm_users');
    }
};
