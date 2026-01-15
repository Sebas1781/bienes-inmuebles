@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 flex flex-col">
    <!-- Header -->
    <header class="bg-header text-white py-6 px-8 flex items-center justify-between shadow">
        <div class="flex items-center gap-4">
            <img src="{{ asset('images/Recurso 8.png') }}" alt="Logo" class="h-10">
            <span class="text-3xl font-bold">Bienes Inmuebles</span>
        </div>
        <h1 class="text-2xl font-semibold">Agregar Inmueble</h1>
        <form action="{{ route('logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="text-red-400 hover:text-red-600 flex items-center gap-2">
                <i class="fas fa-sign-out-alt"></i> Cerrar sesión
            </button>
        </form>
    </header>

    <div class="flex flex-1">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r flex flex-col py-8 px-4 gap-2">
            <a href="{{ route('properties.create') }}" class="flex items-center gap-3 py-3 px-4 rounded-lg bg-maroon-700 text-white font-semibold"><i class="fas fa-plus-square"></i> Agregar inmueble</a>
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-maroon-100 transition text-maroon-700 font-semibold"><i class="fas fa-warehouse"></i> Administrador de inmuebles</a>
            @if(auth()->user()->isSuperAdmin())
            <a href="{{ route('users.index') }}" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-maroon-100 transition text-maroon-700 font-semibold"><i class="fas fa-users"></i> Administrador de usuarios</a>
            @endif
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-bold mb-6 text-maroon-700">Registrar Nuevo Inmueble</h2>

                    @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('properties.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Información Básica -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">Información Básica</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del Inmueble *</label>
                                    <input type="text" name="nombre" value="{{ old('nombre') }}" required
                                           class="w-full border rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-maroon-700"
                                           placeholder="Ej: Casa en el Centro">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Inmueble *</label>
                                    <select name="tipo" required
                                            class="w-full border rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-maroon-700">
                                        <option value="">Seleccione un tipo</option>
                                        @foreach($tipos as $tipo)
                                        <option value="{{ $tipo }}" {{ old('tipo') == $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Área (m²)</label>
                                    <input type="number" name="area" value="{{ old('area') }}" step="0.01"
                                           class="w-full border rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-maroon-700"
                                           placeholder="Ej: 120.50">
                                </div>

                                <div class="col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                                    <textarea name="direccion" rows="2"
                                              class="w-full border rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-maroon-700"
                                              placeholder="Dirección completa del inmueble">{{ old('direccion') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Características -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">Características</h3>
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Habitaciones</label>
                                    <input type="number" name="numero_habitaciones" value="{{ old('numero_habitaciones') }}" min="0"
                                           class="w-full border rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-maroon-700"
                                           placeholder="0">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Baños</label>
                                    <input type="number" name="numero_banos" value="{{ old('numero_banos') }}" min="0"
                                           class="w-full border rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-maroon-700"
                                           placeholder="0">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Precio</label>
                                    <input type="number" name="precio" value="{{ old('precio') }}" step="0.01" min="0"
                                           class="w-full border rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-maroon-700"
                                           placeholder="0.00">
                                </div>
                            </div>
                        </div>

                        <!-- Estados -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">Estados</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Estado de Ocupación *</label>
                                    <select name="estado_ocupacion" required
                                            class="w-full border rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-maroon-700">
                                        @foreach($estadosOcupacion as $estado)
                                        <option value="{{ $estado }}" {{ old('estado_ocupacion', 'Disponible') == $estado ? 'selected' : '' }}>{{ $estado }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Estado de Mantenimiento *</label>
                                    <select name="estado_mantenimiento" required
                                            class="w-full border rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-maroon-700">
                                        @foreach($estadosMantenimiento as $estado)
                                        <option value="{{ $estado }}" {{ old('estado_mantenimiento', 'Bueno') == $estado ? 'selected' : '' }}>{{ $estado }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Información de Contacto -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">Información de Contacto</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Propietario</label>
                                    <input type="text" name="propietario" value="{{ old('propietario') }}"
                                           class="w-full border rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-maroon-700"
                                           placeholder="Nombre del propietario">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                                    <input type="tel" name="telefono_contacto" value="{{ old('telefono_contacto') }}"
                                           class="w-full border rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-maroon-700"
                                           placeholder="Ej: 555-1234">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                    <input type="email" name="email_contacto" value="{{ old('email_contacto') }}"
                                           class="w-full border rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-maroon-700"
                                           placeholder="ejemplo@correo.com">
                                </div>
                            </div>
                        </div>

                        <!-- Descripción -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                            <textarea name="descripcion" rows="4"
                                      class="w-full border rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-maroon-700"
                                      placeholder="Descripción detallada del inmueble...">{{ old('descripcion') }}</textarea>
                        </div>

                        <!-- Botones -->
                        <div class="flex gap-4 pt-4">
                            <button type="submit" class="flex-1 bg-maroon-700 text-white py-3 px-6 rounded-lg font-semibold hover:bg-maroon-800 transition flex items-center justify-center gap-2">
                                <i class="fas fa-save"></i> Guardar Inmueble
                            </button>
                            <a href="{{ route('dashboard') }}" class="flex-1 bg-gray-500 text-white py-3 px-6 rounded-lg font-semibold hover:bg-gray-600 transition flex items-center justify-center gap-2">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<style>
    .bg-header { background-color: #9b4d5c; }
    .bg-maroon-700 { background-color: #7c2a38; }
    .bg-maroon-800 { background-color: #651f2e; }
    .text-maroon-700 { color: #7c2a38; }
    .bg-maroon-100 { background-color: #f8e4ea; }
    .focus\:ring-maroon-700:focus { --tw-ring-color: #7c2a38; }
</style>
@endsection
