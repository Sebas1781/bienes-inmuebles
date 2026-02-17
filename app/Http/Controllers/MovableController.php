<?php

namespace App\Http\Controllers;

use App\Models\Movable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovableController extends Controller
{
    /**
     * Muestra la lista de bienes muebles.
     */
    public function index(Request $request)
    {
        // Construir query con filtros
        $query = Movable::query();

        // Filtro por búsqueda de nombre
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre_mueble', 'like', "%{$search}%")
                  ->orWhere('marca', 'like', "%{$search}%")
                  ->orWhere('modelo', 'like', "%{$search}%");
            });
        }

        // Filtro por área
        if ($request->filled('area')) {
            $query->where('area', $request->area);
        }

        // Filtro por tipo de costo
        if ($request->filled('tipo_costo')) {
            $query->where('tipo_costo', $request->tipo_costo);
        }

        // 1. Lista de bienes muebles para la tabla
        $movables = $query->latest()->paginate(10);

        // 2. Estadísticas
        $totalMuebles = Movable::count();

        // 3. Agrupación por Área
        $porArea = Movable::select('area', DB::raw('count(*) as total'))
            ->whereNotNull('area')
            ->groupBy('area')
            ->get();

        // 4. Agrupación por Marca
        $porMarca = Movable::select('marca', DB::raw('count(*) as total'))
            ->whereNotNull('marca')
            ->groupBy('marca')
            ->get();

        // 5. Agrupación por Resguardatario
        $porResguardatario = Movable::select('nombre_resguardatario', DB::raw('count(*) as total'))
            ->whereNotNull('nombre_resguardatario')
            ->groupBy('nombre_resguardatario')
            ->get();

        return view('movables.index', compact(
            'movables',
            'totalMuebles',
            'porArea',
            'porMarca',
            'porResguardatario'
        ));
    }

    /**
     * Muestra el formulario para crear un nuevo bien mueble.
     */
    public function create()
    {
        return view('movables.create');
    }

    /**
     * Guarda el nuevo bien mueble en la base de datos.
     */
    public function store(Request $request)
    {
        // Validación base
        $rules = [
            'tipo_costo' => 'required|string',
            'cuenta' => 'required|integer',
            'sub_cuenta' => 'required|integer',
            'factura_numero' => 'required|integer',
            'factura_fecha' => 'required|date',
            'fecha_movimiento_alta' => 'required|date',
        ];

        // Si es auto, los campos de póliza son requeridos
        if ($request->has('es_auto') && $request->es_auto == '1') {
            $rules['poliza_tipo'] = 'required|string|max:1';
            $rules['poliza_numero'] = 'required|integer';
            $rules['poliza_fecha'] = 'required|date';
        }

        $request->validate($rules);

        $input = $request->all();

        // Convertir checkbox es_auto a booleano
        $input['es_auto'] = $request->has('es_auto') ? true : false;

        // Convertir campos vacíos a null
        $nullables = [
            'nombre_cuenta', 'numero_inventario', 'nombre_resguardatario',
            'nombre_mueble', 'marca', 'modelo', 'numero_serie',
            'numero_placa', 'numero_motor', 'factura_proveedor',
            'factura_costo', 'area', 'poliza_tipo', 'poliza_numero', 'poliza_fecha'
        ];
        
        foreach ($nullables as $field) {
            if (empty($input[$field])) {
                $input[$field] = null;
            }
        }

        Movable::create($input);

        return redirect()->route('movables.index')
            ->with('success', 'Bien mueble agregado correctamente.');
    }

    /**
     * Muestra el formulario para editar un bien mueble.
     */
    public function edit($id)
    {
        $movable = Movable::findOrFail($id);
        return view('movables.edit', compact('movable'));
    }

    /**
     * Actualiza el bien mueble en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $movable = Movable::findOrFail($id);

        // Validación base
        $rules = [
            'tipo_costo' => 'required|string',
            'cuenta' => 'required|integer',
            'sub_cuenta' => 'required|integer',
            'factura_numero' => 'required|integer',
            'factura_fecha' => 'required|date',
            'fecha_movimiento_alta' => 'required|date',
        ];

        // Si es auto, los campos de póliza son requeridos
        if ($request->has('es_auto') && $request->es_auto == '1') {
            $rules['poliza_tipo'] = 'required|string|max:1';
            $rules['poliza_numero'] = 'required|integer';
            $rules['poliza_fecha'] = 'required|date';
        }

        $request->validate($rules);

        $input = $request->all();

        // Convertir checkbox es_auto a booleano
        $input['es_auto'] = $request->has('es_auto') ? true : false;

        // Convertir campos vacíos a null
        $nullables = [
            'nombre_cuenta', 'numero_inventario', 'nombre_resguardatario',
            'nombre_mueble', 'marca', 'modelo', 'numero_serie',
            'numero_placa', 'numero_motor', 'factura_proveedor',
            'factura_costo', 'area', 'poliza_tipo', 'poliza_numero', 'poliza_fecha'
        ];
        
        foreach ($nullables as $field) {
            if (empty($input[$field])) {
                $input[$field] = null;
            }
        }

        $movable->update($input);

        return redirect()->route('movables.index')
            ->with('success', 'Bien mueble actualizado correctamente.');
    }

    /**
     * Elimina el bien mueble de la base de datos.
     */
    public function destroy($id)
    {
        $movable = Movable::findOrFail($id);
        $movable->delete();

        return redirect()->route('movables.index')
            ->with('success', 'Bien mueble eliminado correctamente.');
    }
}
