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
            $table->string('key', 7)->nullable()->unique();
            $table->string('name', 40);
            $table->string('gender', 15);
            $table->string('procedence', 40)->nullable();
            $table->string('email', 60);
            $table->string('phone_number', 17)->nullable();
            $table->string('password');
            $table->boolean('has_account')->default(false);
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
