@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 flex flex-col">
    <!-- Header -->
    <header class="bg-header text-white py-6 px-8 flex items-center justify-between shadow">
        <div class="flex items-center gap-4">
            <img src="{{ asset('images/Recurso 8.png') }}" alt="Logo" class="h-10">
            <span class="text-3xl font-bold">Bienes Inmuebles</span>
        </div>
        <h1 class="text-2xl font-semibold">Administrador de Usuarios</h1>
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
            <a href="{{ route('properties.create') }}" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-maroon-100 transition text-maroon-700 font-semibold"><i class="fas fa-plus-square"></i> Agregar inmueble</a>
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-maroon-100 transition text-maroon-700 font-semibold"><i class="fas fa-warehouse"></i> Administrador de inmuebles</a>
            <a href="{{ route('users.index') }}" class="flex items-center gap-3 py-3 px-4 rounded-lg bg-maroon-700 text-white font-semibold"><i class="fas fa-users"></i> Administrador de usuarios</a>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
            @endif

            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Gestión de Usuarios</h2>
                <a href="{{ route('users.create') }}" class="bg-maroon-700 text-white px-6 py-3 rounded-lg font-semibold hover:bg-maroon-800 transition flex items-center gap-2">
                    <i class="fas fa-user-plus"></i> Crear Usuario
                </a>
            </div>

            <!-- Estadísticas de Usuarios -->
            <div class="grid grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Total Usuarios</p>
                            <p class="text-3xl font-bold text-maroon-700">{{ $users->total() }}</p>
                        </div>
                        <i class="fas fa-users text-4xl text-maroon-700 opacity-20"></i>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Administradores</p>
                            <p class="text-3xl font-bold text-blue-600">{{ $users->where('role', 'administrador')->count() }}</p>
                        </div>
                        <i class="fas fa-user-shield text-4xl text-blue-600 opacity-20"></i>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Super Administradores</p>
                            <p class="text-3xl font-bold text-purple-600">{{ $users->where('role', 'super_administrador')->count() }}</p>
                        </div>
                        <i class="fas fa-crown text-4xl text-purple-600 opacity-20"></i>
                    </div>
                </div>
            </div>

            <!-- Tabla de Usuarios -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full">
                    <thead class="bg-maroon-700 text-white">
                        <tr>
                            <th class="py-3 px-6 text-left">ID</th>
                            <th class="py-3 px-6 text-left">Nombre</th>
                            <th class="py-3 px-6 text-left">Email</th>
                            <th class="py-3 px-6 text-left">Rol</th>
                            <th class="py-3 px-6 text-left">Fecha de Registro</th>
                            <th class="py-3 px-6 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="py-4 px-6">{{ $user->id }}</td>
                            <td class="py-4 px-6 font-semibold">{{ $user->name }}</td>
                            <td class="py-4 px-6 text-gray-600">{{ $user->email }}</td>
                            <td class="py-4 px-6">
                                @if($user->role === 'super_administrador')
                                <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-semibold">
                                    <i class="fas fa-crown"></i> Super Admin
                                </span>
                                @elseif($user->role === 'administrador')
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                                    <i class="fas fa-user-shield"></i> Administrador
                                </span>
                                @else
                                <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm font-semibold">
                                    <i class="fas fa-user"></i> Usuario
                                </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-gray-600">{{ $user->created_at->format('d/m/Y') }}</td>
                            <td class="py-4 px-6">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('users.edit', $user) }}" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($user->id !== auth()->id())
                                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline"
                                          onsubmit="return confirm('¿Estás seguro de eliminar este usuario?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-gray-500">
                                No hay usuarios registrados
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            @if($users->hasPages())
            <div class="mt-6">
                {{ $users->links() }}
            </div>
            @endif
        </main>
    </div>
</div>

<style>
    .bg-header { background-color: #9b4d5c; }
    .bg-maroon-700 { background-color: #7c2a38; }
    .bg-maroon-800 { background-color: #651f2e; }
    .text-maroon-700 { color: #7c2a38; }
    .bg-maroon-100 { background-color: #f8e4ea; }
</style>
@endsection
