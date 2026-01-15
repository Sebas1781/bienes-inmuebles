<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::latest()->paginate(10);
        return view('properties.index', compact('properties'));
    }

    public function create()
    {
        $tipos = Property::getTipos();
        $estadosOcupacion = Property::getEstadosOcupacion();
        $estadosMantenimiento = Property::getEstadosMantenimiento();

        return view('properties.create', compact('tipos', 'estadosOcupacion', 'estadosMantenimiento'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|string',
            'direccion' => 'nullable|string',
            'area' => 'nullable|numeric|min:0',
            'numero_habitaciones' => 'nullable|integer|min:0',
            'numero_banos' => 'nullable|integer|min:0',
            'precio' => 'nullable|numeric|min:0',
            'estado_ocupacion' => 'required|string',
            'estado_mantenimiento' => 'required|string',
            'descripcion' => 'nullable|string',
            'propietario' => 'nullable|string|max:255',
            'telefono_contacto' => 'nullable|string|max:20',
            'email_contacto' => 'nullable|email|max:255',
        ]);

        Property::create($validated);

        return redirect()->route('dashboard')
            ->with('success', 'Inmueble registrado exitosamente');
    }

    public function show(Property $property)
    {
        return view('properties.show', compact('property'));
    }

    public function edit(Property $property)
    {
        $tipos = Property::getTipos();
        $estadosOcupacion = Property::getEstadosOcupacion();
        $estadosMantenimiento = Property::getEstadosMantenimiento();

        return view('properties.edit', compact('property', 'tipos', 'estadosOcupacion', 'estadosMantenimiento'));
    }

    public function update(Request $request, Property $property)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|string',
            'direccion' => 'nullable|string',
            'area' => 'nullable|numeric|min:0',
            'numero_habitaciones' => 'nullable|integer|min:0',
            'numero_banos' => 'nullable|integer|min:0',
            'precio' => 'nullable|numeric|min:0',
            'estado_ocupacion' => 'required|string',
            'estado_mantenimiento' => 'required|string',
            'descripcion' => 'nullable|string',
            'propietario' => 'nullable|string|max:255',
            'telefono_contacto' => 'nullable|string|max:20',
            'email_contacto' => 'nullable|email|max:255',
        ]);

        $property->update($validated);

        return redirect()->route('properties.index')
            ->with('success', 'Inmueble actualizado exitosamente');
    }

    public function destroy(Property $property)
    {
        $property->delete();

        return redirect()->route('properties.index')
            ->with('success', 'Inmueble eliminado exitosamente');
    }
}
