<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // <--- ¡Importante! Necesario para las consultas agrupadas

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Obtener la lista de inmuebles para la tabla (paginada)
        $properties = Property::latest()->paginate(10);

        // 2. Tarjeta 1: Total numérico de inmuebles
        $totalInmuebles = Property::count();

        // 3. Tarjeta 2: Categorías (Agrupadas por 'uso_destino')
        // Esto cuenta cuántos hay de cada tipo (Ej: 5 Oficinas, 3 Bodegas)
        $tiposInmuebles = Property::select('uso_destino as tipo', DB::raw('count(*) as total'))
            ->groupBy('uso_destino')
            ->get();

        // 4. Tarjeta 3: Estatus de Ocupación
        // Cuenta cuántos están habitados (1) y cuántos no (0)
        $estadosOcupacion = Property::select(
            DB::raw('CASE WHEN habitado = 1 THEN "Habitado" ELSE "Deshabitado" END as estado_ocupacion'),
            DB::raw('count(*) as total')
        )->groupBy('habitado')->get();

        // 5. Tarjeta 4: Alertas de Mantenimiento
        // Sumamos cuántos inmuebles tienen marcada la casilla "Sí" (1) en cada tipo de mantenimiento
        $pintura = Property::where('pintura', 1)->count();
        $basura = Property::where('recoleccion_basura', 1)->count();
        $poda = Property::where('poda', 1)->count();
        $imper = Property::where('impermeabilizacion', 1)->count();

        // Creamos una colección manual para enviarla a la vista de forma ordenada
        $estadosMantenimiento = collect([
            (object)['estado_mantenimiento' => 'Requiere Pintura', 'total' => $pintura],
            (object)['estado_mantenimiento' => 'Recolección Basura', 'total' => $basura],
            (object)['estado_mantenimiento' => 'Poda y Jardín', 'total' => $poda],
            (object)['estado_mantenimiento' => 'Impermeabilización', 'total' => $imper],
        ]);

        // 6. Enviamos TODAS las variables a la vista
        return view('dashboard', compact(
            'properties',
            'totalInmuebles',
            'tiposInmuebles',
            'estadosOcupacion',
            'estadosMantenimiento'
        ));
    }
}