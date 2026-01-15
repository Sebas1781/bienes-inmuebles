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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('tipo');
            $table->text('direccion')->nullable();
            $table->decimal('area', 10, 2)->nullable();
            $table->integer('numero_habitaciones')->nullable();
            $table->integer('numero_banos')->nullable();
            $table->decimal('precio', 12, 2)->nullable();
            $table->string('estado_ocupacion')->default('Disponible');
            $table->string('estado_mantenimiento')->default('Bueno');
            $table->text('descripcion')->nullable();
            $table->string('propietario')->nullable();
            $table->string('telefono_contacto')->nullable();
            $table->string('email_contacto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
