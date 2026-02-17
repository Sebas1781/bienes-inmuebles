<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movable extends Model
{
    use HasFactory;

    protected $table = 'movables';
    protected $primaryKey = 'numero_consecutivo';

    protected $fillable = [
        'tipo_costo',
        'es_auto',
        'cuenta',
        'sub_cuenta',
        'nombre_cuenta',
        'numero_inventario',
        'nombre_resguardatario',
        'nombre_mueble',
        'marca',
        'modelo',
        'numero_serie',
        'numero_placa',
        'numero_motor',
        'factura_numero',
        'factura_fecha',
        'factura_proveedor',
        'factura_costo',
        'poliza_tipo',
        'poliza_numero',
        'poliza_fecha',
        'fecha_movimiento_alta',
        'area',
    ];

    protected $casts = [
        'es_auto' => 'boolean',
        'factura_fecha' => 'datetime',
        'poliza_fecha' => 'datetime',
        'fecha_movimiento_alta' => 'datetime',
    ];
}
