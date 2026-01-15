<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            
            // GENERALES
            // Recomendación: dejarlos nullable por si falta información al registrar
            $table->string('denominacion')->nullable(); 
            $table->string('ubicacion')->nullable();
            $table->string('comunidad')->nullable();
            $table->string('clave_catastral')->nullable();
            $table->string('coordenadas')->nullable();
            $table->string('superficie_total')->nullable();
            $table->string('uso_destino')->nullable();
            
            // Booleanos (Estos están perfectos así)
            $table->boolean('habitado')->default(false);
            $table->boolean('propio')->default(false);
            $table->boolean('comodato')->default(false);
            
            $table->string('adscrito_a')->nullable();
            $table->string('resguardo_servidor')->nullable();
            $table->date('fecha_contrato')->nullable(); // Importante: nullable por si no hay contrato a mano

            // MULTIMEDIA Y SERVICIOS
            $table->string('imagen_principal')->nullable();
            $table->boolean('luz')->default(false);
            $table->boolean('predio')->default(false);
            $table->boolean('agua')->default(false);

            // EQUIPAMIENTO
            $table->string('oficinas_admin')->nullable();
            $table->string('modulos_sanitarios')->nullable();
            $table->string('bodega')->nullable();
            $table->string('num_ventana')->nullable();
            $table->string('tienda')->nullable();
            $table->string('porton')->nullable();

            // MANTENIMIENTO
            $table->boolean('pintura')->default(false);
            $table->date('fecha_pintura')->nullable();
            $table->string('req_pintura')->nullable();
            
            $table->boolean('recoleccion_basura')->default(false);
            $table->date('fecha_recoleccion')->nullable();
            $table->string('req_recoleccion')->nullable();
            
            $table->boolean('poda')->default(false);
            $table->date('fecha_poda')->nullable();
            $table->string('req_poda')->nullable();
            
            $table->boolean('impermeabilizacion')->default(false);
            $table->date('fecha_imper')->nullable();
            $table->string('req_imper')->nullable();

            // ESTRUCTURAS
            $table->boolean('retiro_estructuras')->default(false);
            $table->boolean('malla')->default(false);
            $table->boolean('sombra')->default(false);
            $table->boolean('barda')->default(false);

            $table->text('actividades')->nullable();
            
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('properties');
    }
}