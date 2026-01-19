<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Indispensable para las gráficas del dashboard
use Illuminate\Support\Facades\Storage; // Para manejar archivos/imágenes

class PropertyController extends Controller
{
    /**
     * Muestra el Dashboard principal con la tabla y las estadísticas.
     */
    public function index()
    {
        // 1. LISTA DE INMUEBLES (Tabla)
        $properties = Property::latest()->paginate(10);

        // 2. ESTADÍSTICAS (Tarjetas superiores)
        
        // Tarjeta 1: Total
        $totalInmuebles = Property::count();

        // Tarjeta 2: Categorías (Agrupado por uso_destino)
        $tiposInmuebles = Property::select('uso_destino as tipo', DB::raw('count(*) as total'))
            ->groupBy('uso_destino')
            ->get();

        // Tarjeta 3: Ocupación (Habitado vs Deshabitado)
        $estadosOcupacion = Property::select(
            DB::raw('CASE WHEN habitado = 1 THEN "Habitado" ELSE "Deshabitado" END as estado_ocupacion'),
            DB::raw('count(*) as total')
        )->groupBy('habitado')->get();

        // Tarjeta 4: Mantenimiento (Conteo manual de alertas)
        $pintura = Property::where('pintura', 1)->count();
        $basura = Property::where('recoleccion_basura', 1)->count();
        $poda = Property::where('poda', 1)->count();
        $imper = Property::where('impermeabilizacion', 1)->count();

        // Colección manual para la vista
        $estadosMantenimiento = collect([
            (object)['estado_mantenimiento' => 'Requiere Pintura', 'total' => $pintura],
            (object)['estado_mantenimiento' => 'Recolección Basura', 'total' => $basura],
            (object)['estado_mantenimiento' => 'Poda y Jardín', 'total' => $poda],
            (object)['estado_mantenimiento' => 'Impermeabilización', 'total' => $imper],
        ]);

        // Retornar la vista 'dashboard' con TODAS las variables necesarias
        return view('dashboard', compact(
            'properties', 
            'totalInmuebles', 
            'tiposInmuebles', 
            'estadosOcupacion', 
            'estadosMantenimiento'
        ));
    }

    /**
     * Muestra el formulario para crear un nuevo inmueble.
     */
    public function create()
    {
        return view('properties.create');
    }

    /**
     * Guarda el nuevo inmueble en la base de datos.
     */
    public function store(Request $request)
    {
        // 1. Validación básica
        $request->validate([
            'denominacion' => 'required',
            'ubicacion' => 'required',
            'imagen_principal' => 'nullable|image|max:5120', // Máx 5MB
        ]);

        $input = $request->all();

        // 2. Manejo de Fechas Vacías (Convertir "" a null para evitar errores SQL)
        $fechas = ['fecha_contrato', 'fecha_pintura', 'fecha_recoleccion_basura', 'fecha_poda', 'fecha_impermeabilizacion'];
        foreach ($fechas as $fecha) {
            if (empty($input[$fecha])) {
                $input[$fecha] = null;
            }
        }

        // 3. Subida de Imagen Principal
        if ($request->hasFile('imagen_principal')) {
            $input['imagen_principal'] = $request->file('imagen_principal')->store('inmuebles', 'public');
        }

        // 4. Subida de Archivos de Servicios
        $servicios = ['file_luz', 'file_predio', 'file_agua'];
        foreach ($servicios as $archivo) {
            if ($request->hasFile($archivo)) {
                $input[$archivo] = $request->file($archivo)->store('servicios', 'public');
            }
        }

        // 5. Crear Registro
        Property::create($input);

        return redirect()->route('dashboard')->with('success', 'Inmueble registrado correctamente.');
    }

    /**
     * Muestra el formulario para editar un inmueble existente.
     */
    public function edit($id)
    {
        $property = Property::findOrFail($id);
        return view('properties.edit', compact('property'));
    }

    /**
     * Actualiza el inmueble en la base de datos.
     */
    public function update(Request $request, $id)
    {
        // 1. Validación
        $request->validate([
            'denominacion' => 'required',
            'ubicacion' => 'required',
        ]);

        $property = Property::findOrFail($id);
        $input = $request->all();

        // 2. Manejo de Fechas Vacías
        $fechas = ['fecha_contrato', 'fecha_pintura', 'fecha_recoleccion_basura', 'fecha_poda', 'fecha_impermeabilizacion'];
        foreach ($fechas as $fecha) {
            if (empty($input[$fecha])) {
                $input[$fecha] = null;
            }
        }

        // 3. Manejo de Imagen Principal (Reemplazo)
        if ($request->hasFile('imagen_principal')) {
            // Opcional: Borrar la imagen anterior para no llenar el servidor
            if ($property->imagen_principal && Storage::disk('public')->exists($property->imagen_principal)) {
                Storage::disk('public')->delete($property->imagen_principal);
            }
            $input['imagen_principal'] = $request->file('imagen_principal')->store('inmuebles', 'public');
        } else {
            // Si no suben nueva imagen, quitamos el campo del input para no sobreescribir con null
            unset($input['imagen_principal']);
        }

        // 4. Manejo de Archivos de Servicios
        $servicios = ['file_luz', 'file_predio', 'file_agua'];
        foreach ($servicios as $archivo) {
            if ($request->hasFile($archivo)) {
                $input[$archivo] = $request->file($archivo)->store('servicios', 'public');
            } else {
                unset($input[$archivo]);
            }
        }

        // 5. Actualizar Registro
        $property->update($input);

        return redirect()->route('dashboard')->with('success', 'Inmueble actualizado correctamente.');
    }
}