<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'denominacion',
        'ubicacion',
        'comunidad',
        'clave_catastral',
        'coordenadas',
        'superficie_total',
        'uso_destino',
        'habitado',
        'propio',
        'comodato',
        'adscrito_a',
        'resguardo_servidor',
        'fecha_contrato',
        'imagen_principal',
        'luz',
        'predio',
        'agua',
        'file_luz',
        'file_predio',
        'file_agua',
        'oficinas_admin',
        'modulos_sanitarios',
        'bodega',
        'num_ventana',
        'tienda',
        'porton',
        'pintura',
        'fecha_pintura',
        'req_pintura',
        'recoleccion_basura',
        'fecha_recoleccion_basura',
        'req_recoleccion_basura',
        'poda',
        'fecha_poda',
        'req_poda',
        'impermeabilizacion',
        'fecha_impermeabilizacion',
        'req_impermeabilizacion',
        'retiro_estructuras',
        'malla',
        'sombra',
        'barda',
        'actividades',
    ];

    protected $casts = [
        'area' => 'decimal:2',
        'precio' => 'decimal:2',
    ];

    // Definir tipos de inmueble disponibles
    public static function getTipos()
    {
        return [
            'Casa',
            'Apartamento',
            'Local Comercial',
            'Oficina',
            'Terreno',
            'Bodega',
            'Edificio',
            'Otro'
        ];
    }

    // Definir estados de ocupación
    public static function getEstadosOcupacion()
    {
        return [
            'Disponible',
            'Ocupado',
            'Reservado',
            'En Proceso'
        ];
    }

    // Definir estados de mantenimiento
    public static function getEstadosMantenimiento()
    {
        return [
            'Excelente',
            'Bueno',
            'Regular',
            'Requiere Mantenimiento',
            'En Reparación'
        ];
    }
}
