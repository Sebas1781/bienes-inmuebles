@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 flex flex-col">
    <!-- Header -->
    <header class="bg-maroon-700 text-white py-6 px-8 flex items-center justify-between shadow">
        <div class="flex items-center gap-4">
            <span class="text-3xl font-bold"><i class="fas fa-building"></i> Bienes Inmuebles</span>
        </div>
        <h1 class="text-2xl font-semibold">Dashboard</h1>
        <a href="#" class="text-red-400 hover:text-red-600 flex items-center gap-2"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
    </header>

    <div class="flex flex-1">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r flex flex-col py-8 px-4 gap-2">
            <a href="#" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-maroon-100 transition text-maroon-700 font-semibold"><i class="fas fa-plus-square"></i> Agregar inmueble</a>
            <a href="#" class="flex items-center gap-3 py-3 px-4 rounded-lg bg-maroon-700 text-white font-semibold"><i class="fas fa-warehouse"></i> Administrador de inmuebles</a>
            <a href="#" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-maroon-100 transition text-maroon-700 font-semibold"><i class="fas fa-users"></i> Administrador de usuarios</a>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <h2 class="text-xl font-bold mb-6">Administrador de Inmuebles</h2>
            <div class="grid grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
                    <i class="fas fa-home text-maroon-700 text-3xl mb-2"></i>
                    <span class="text-2xl font-bold">43</span>
                    <span class="text-gray-500">Total Inmuebles</span>
                </div>
                <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
                    <i class="fas fa-clipboard-list text-maroon-700 text-3xl mb-2"></i>
                    <span class="text-2xl font-bold">4</span>
                    <span class="text-gray-500">Tipos Inmuebles</span>
                </div>
                <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
                    <i class="fas fa-user-check text-maroon-700 text-3xl mb-2"></i>
                    <span class="text-2xl font-bold">100</span>
                    <span class="text-gray-500">Estatus Ocupación</span>
                </div>
                <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
                    <i class="fas fa-tools text-maroon-700 text-3xl mb-2"></i>
                    <span class="text-2xl font-bold">100</span>
                    <span class="text-gray-500">Estado Mantenimiento</span>
                </div>
            </div>
            <div class="flex gap-4 mb-6">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Buscar por nombre</label>
                    <div class="relative">
                        <input type="text" class="w-full border rounded-lg py-2 px-4 pl-10 focus:outline-none focus:ring-2 focus:ring-maroon-700" placeholder="Nombre de inmueble">
                        <span class="absolute left-3 top-2.5 text-maroon-700"><i class="fas fa-search"></i></span>
                    </div>
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Buscar por tipo</label>
                    <select class="w-full border rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-maroon-700">
                        <option>Tipo de inmueble</option>
                        <option>Casa</option>
                        <option>Departamento</option>
                        <option>Local</option>
                        <option>Bodega</option>
                    </select>
                </div>
                <button class="bg-gray-800 text-white px-6 py-2 rounded-lg font-semibold mt-6 h-10 flex items-center gap-2"><i class="fas fa-filter"></i> Filtrar</button>
                <button class="bg-maroon-700 text-white px-6 py-2 rounded-lg font-semibold mt-6 h-10 flex items-center gap-2"><i class="fas fa-plus"></i> Crear inmueble</button>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded-lg shadow">
                    <thead class="bg-maroon-700 text-white">
                        <tr>
                            <th class="py-3 px-4 text-left">Nombre</th>
                            <th class="py-3 px-4 text-left">Ubicación</th>
                            <th class="py-3 px-4 text-left">Comunidad</th>
                            <th class="py-3 px-4 text-left">Coordenadas</th>
                            <th class="py-3 px-4 text-left">Superficie</th>
                            <th class="py-3 px-4 text-left">Uso</th>
                            <th class="py-3 px-4 text-left">Habitado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Aquí van los registros de inmuebles -->
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>



<!-- Colores personalizados -->
<style>
    .bg-maroon-700 { background-color: #7c2a38; }
    .text-maroon-700 { color: #7c2a38; }
    .bg-maroon-100 { background-color: #f8e4ea; }
</style>
@endsection
