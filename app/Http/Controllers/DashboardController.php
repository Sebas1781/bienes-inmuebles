<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total de inmuebles
        $totalInmuebles = Property::count();

        // Conteo por tipo de inmueble
        $tiposInmuebles = Property::select('tipo', DB::raw('count(*) as total'))
            ->groupBy('tipo')
            ->get();

        // Conteo por estado de ocupación
        $estadosOcupacion = Property::select('estado_ocupacion', DB::raw('count(*) as total'))
            ->groupBy('estado_ocupacion')
            ->get();

        // Conteo por estado de mantenimiento
        $estadosMantenimiento = Property::select('estado_mantenimiento', DB::raw('count(*) as total'))
            ->groupBy('estado_mantenimiento')
            ->get();

        return view('dashboard', compact(
            'totalInmuebles',
            'tiposInmuebles',
            'estadosOcupacion',
            'estadosMantenimiento'
        ));
    }
}
