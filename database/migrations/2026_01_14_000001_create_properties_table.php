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

            // Datos generales
            $table->string('denominacion')->nullable();
            $table->string('ubicacion')->nullable();
            $table->string('comunidad')->nullable();
            $table->string('clave_catastral')->nullable();
            $table->string('coordenadas')->nullable();
            $table->decimal('superficie_total', 10, 2)->nullable();
            $table->string('uso_destino')->nullable();

            // Propiedades booleanas
            $table->boolean('habitado')->default(false);
            $table->boolean('propio')->default(false);
            $table->boolean('comodato')->default(false);

            // Información adicional
            $table->string('adscrito_a')->nullable();
            $table->string('resguardo_servidor')->nullable();
            $table->date('fecha_contrato')->nullable();

            // Multimedia y servicios
            $table->string('imagen_principal')->nullable();
            $table->boolean('luz')->default(false);
            $table->boolean('predio')->default(false);
            $table->boolean('agua')->default(false);
            $table->string('file_luz')->nullable();
            $table->string('file_predio')->nullable();
            $table->string('file_agua')->nullable();

            // Equipamiento
            $table->integer('oficinas_admin')->nullable();
            $table->integer('modulos_sanitarios')->nullable();
            $table->integer('bodega')->nullable();
            $table->integer('num_ventana')->nullable();
            $table->integer('tienda')->nullable();
            $table->integer('porton')->nullable();

            // Mantenimiento
            $table->boolean('pintura')->default(false);
            $table->date('fecha_pintura')->nullable();
            $table->string('req_pintura')->nullable();
            $table->boolean('recoleccion_basura')->default(false);
            $table->date('fecha_recoleccion_basura')->nullable();
            $table->string('req_recoleccion_basura')->nullable();
            $table->boolean('poda')->default(false);
            $table->date('fecha_poda')->nullable();
            $table->string('req_poda')->nullable();
            $table->boolean('impermeabilizacion')->default(false);
            $table->date('fecha_impermeabilizacion')->nullable();
            $table->string('req_impermeabilizacion')->nullable();

            // Estructuras
            $table->boolean('retiro_estructuras')->default(false);
            $table->boolean('malla')->default(false);
            $table->boolean('sombra')->default(false);
            $table->boolean('barda')->default(false);

            // Observaciones
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