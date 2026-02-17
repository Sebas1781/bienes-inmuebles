<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovablesTable extends Migration
{
    public function up()
    {
        Schema::create('movables', function (Blueprint $table) {
            // ID AutoIncrement
            $table->id('numero_consecutivo');

            // Nuevos campos
            $table->string('tipo_costo');
            $table->boolean('es_auto')->default(false);

            // Campos principales
            $table->integer('cuenta');
            $table->integer('sub_cuenta');
            $table->string('nombre_cuenta')->nullable();
            $table->string('numero_inventario')->nullable();
            $table->string('nombre_resguardatario')->nullable();
            $table->string('nombre_mueble')->nullable();
            $table->string('marca')->nullable();
            $table->string('modelo')->nullable();
            $table->string('numero_serie')->nullable();
            $table->string('numero_placa')->nullable();
            $table->string('numero_motor')->nullable();

            // Factura o CFDI
            $table->integer('factura_numero');
            $table->dateTime('factura_fecha');
            $table->string('factura_proveedor')->nullable();
            $table->integer('factura_costo')->nullable();

            // Póliza (nullable porque solo es requerida si es_auto es true)
            $table->char('poliza_tipo', 1)->nullable();
            $table->integer('poliza_numero')->nullable();
            $table->dateTime('poliza_fecha')->nullable();

            // Otros
            $table->dateTime('fecha_movimiento_alta');
            $table->string('area')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('movables');
    }
}
