<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
 // 1. Total General
 $totalInmuebles = Property::count();

 // 2. TIPOS (Adaptado para que tu vista lea ->tipo)
 $tiposInmuebles = Property::select('uso_destino as tipo', DB::raw('count(*) as total'))
     ->whereNotNull('uso_destino')
     ->groupBy('uso_destino')
     ->get();

 // 3. OCUPACIÓN (Adaptado para que tu vista lea ->estado_ocupacion)
 $habitados = Property::where('habitado', true)->count();
 $desocupados = Property::where('habitado', false)->count();

 // Creamos una colección manual para simular tu tabla antigua
 $estadosOcupacion = collect([
     (object)['estado_ocupacion' => 'Habitado', 'total' => $habitados],
     (object)['estado_ocupacion' => 'Desocupado', 'total' => $desocupados],
 ]);

 // 4. MANTENIMIENTO (Adaptado para que tu vista lea ->estado_mantenimiento)
 // Sumamos los booleanos de la nueva tabla
 $estadosMantenimiento = collect([
     (object)['estado_mantenimiento' => 'Requiere Pintura', 'total' => Property::where('pintura', true)->count()],
     (object)['estado_mantenimiento' => 'Recolección de Basura', 'total' => Property::where('recoleccion_basura', true)->count()],
     (object)['estado_mantenimiento' => 'Requiere Poda', 'total' => Property::where('poda', true)->count()],
     (object)['estado_mantenimiento' => 'Impermeabilización', 'total' => Property::where('impermeabilizacion', true)->count()],
     (object)['estado_mantenimiento' => 'Retiro de Estructuras', 'total' => Property::where('retiro_estructuras', true)->count()],
 ]);

 // 5. Lista para la tabla
 $properties = Property::paginate(10);

 return view('dashboard', compact(
     'totalInmuebles', 
     'tiposInmuebles', 
     'estadosOcupacion', 
     'estadosMantenimiento', 
     'properties'
 ));
    }
}
