<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'tipo',
        'direccion',
        'area',
        'numero_habitaciones',
        'numero_banos',
        'precio',
        'estado_ocupacion',
        'estado_mantenimiento',
        'descripcion',
        'propietario',
        'telefono_contacto',
        'email_contacto',
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
