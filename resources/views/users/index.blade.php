@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 flex flex-col relative">
    
    <header class="bg-header text-white py-4 px-4 md:px-8 flex items-center justify-between shadow sticky top-0 z-30 transition-all duration-300" style="background-color: #9b4d5c;">
        <div class="flex items-center gap-4">
            <button id="mobile-menu-btn" class="md:hidden text-white hover:text-gray-200 focus:outline-none p-1">
                <i class="fas fa-bars text-2xl"></i>
            </button>

            <div class="flex items-center gap-2 md:gap-4">
                <img src="{{ asset('images/Recurso 8.png') }}" alt="Logo" class="h-8 md:h-10">
                <span class="text-lg md:text-3xl font-bold truncate">Bienes Inmuebles</span>
            </div>
        </div>
        
        <div class="flex items-center gap-4">
            <h1 class="text-lg md:text-2xl font-semibold hidden sm:block">Admin. Usuarios</h1>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="text-red-200 hover:text-white flex items-center gap-2 transition">
                    <i class="fas fa-sign-out-alt"></i> 
                    <span class="hidden md:inline">Cerrar sesión</span>
                </button>
            </form>
        </div>
    </header>

    <div class="flex flex-1 relative overflow-hidden">
        
        <div id="sidebar-overlay" onclick="toggleSidebar()" 
             class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden md:hidden transition-opacity backdrop-blur-sm">
        </div>

        <aside id="sidebar" 
               class="bg-white border-r w-64 py-6 px-4 gap-2 flex flex-col shadow-2xl md:shadow-inner
                      fixed inset-y-0 left-0 z-50 h-full transition-transform duration-300 ease-in-out transform -translate-x-full
                      md:relative md:translate-x-0 md:inset-auto">
            
            <div class="flex justify-end md:hidden mb-2">
                <button onclick="toggleSidebar()" class="text-gray-400 hover:text-maroon-700 p-2">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>

            <a href="{{ route('properties.create') }}" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-maroon-100 transition text-maroon-700 font-semibold group">
                <i class="fas fa-plus-square group-hover:scale-110 transition-transform"></i> Agregar inmueble
            </a>
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-maroon-100 transition text-maroon-700 font-semibold">
                <i class="fas fa-warehouse"></i> Admin. inmuebles
            </a>
            <a href="{{ route('users.index') }}" class="flex items-center gap-3 py-3 px-4 rounded-lg bg-maroon-700 text-white font-semibold shadow-md" style="background-color: #741728;">
                <i class="fas fa-users"></i> Admin. usuarios
            </a>
        </aside>

        <main class="flex-1 p-4 md:p-8 overflow-y-auto w-full">
            
            @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
                <p class="font-bold">Éxito</p>
                <p>{{ session('success') }}</p>
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
                <p class="font-bold">Error</p>
                <p>{{ session('error') }}</p>
            </div>
            @endif

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Gestión de Usuarios</h2>
                <a href="{{ route('users.create') }}" class="bg-maroon-700 text-white px-6 py-3 rounded-lg font-semibold hover:bg-maroon-800 transition flex items-center gap-2 w-full md:w-auto justify-center shadow" style="background-color: #741728;">
                    <i class="fas fa-user-plus"></i> Crear Usuario
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 mb-8">
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-6 border-t-4 border-maroon-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-bold uppercase">Total Usuarios</p>
                            <p class="text-3xl font-bold text-maroon-700">{{ $users->total() }}</p>
                        </div>
                        <i class="fas fa-users text-4xl text-maroon-700 opacity-20"></i>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-6 border-t-4 border-blue-600">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-bold uppercase">Administradores</p>
                            <p class="text-3xl font-bold text-blue-600">{{ $users->where('role', 'administrador')->count() }}</p>
                        </div>
                        <i class="fas fa-user-shield text-4xl text-blue-600 opacity-20"></i>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-6 border-t-4 border-purple-600">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-bold uppercase">Super Admins</p>
                            <p class="text-3xl font-bold text-purple-600">{{ $users->where('role', 'super_administrador')->count() }}</p>
                        </div>
                        <i class="fas fa-crown text-4xl text-purple-600 opacity-20"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-maroon-700 text-white text-sm uppercase" style="background-color: #7c2a38;">
                            <tr>
                                <th class="py-3 px-6 text-left whitespace-nowrap">ID</th>
                                <th class="py-3 px-6 text-left whitespace-nowrap">Nombre</th>
                                <th class="py-3 px-6 text-left whitespace-nowrap">Email</th>
                                <th class="py-3 px-6 text-left whitespace-nowrap">Rol</th>
                                <th class="py-3 px-6 text-left whitespace-nowrap">Fecha Registro</th>
                                <th class="py-3 px-6 text-center whitespace-nowrap">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($users as $user)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="py-4 px-6 text-gray-600">{{ $user->id }}</td>
                                <td class="py-4 px-6 font-semibold text-gray-800">{{ $user->name }}</td>
                                <td class="py-4 px-6 text-gray-600">{{ $user->email }}</td>
                                <td class="py-4 px-6 whitespace-nowrap">
                                    @if($user->role === 'super_administrador')
                                    <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-xs font-bold border border-purple-200">
                                        <i class="fas fa-crown mr-1"></i> Super Admin
                                    </span>
                                    @elseif($user->role === 'administrador')
                                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-bold border border-blue-200">
                                        <i class="fas fa-user-shield mr-1"></i> Administrador
                                    </span>
                                    @else
                                    <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-xs font-bold border border-gray-200">
                                        <i class="fas fa-user mr-1"></i> Usuario
                                    </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-gray-600 whitespace-nowrap">{{ $user->created_at->format('d/m/Y') }}</td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('users.edit', $user) }}" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600 transition" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($user->id !== auth()->id())
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline"
                                              onsubmit="return confirm('¿Estás seguro de eliminar este usuario?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 text-white p-2 rounded hover:bg-red-600 transition" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="py-10 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-users-slash text-4xl mb-2 text-gray-300"></i>
                                        <p>No hay usuarios registrados</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($users->hasPages())
            <div class="mt-6 px-4">
                {{ $users->links() }}
            </div>
            @endif
        </main>
    </div>
</div>

<script>
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    const btn = document.getElementById('mobile-menu-btn');

    function toggleSidebar() {
        if (sidebar.classList.contains('-translate-x-full')) {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        } else {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }
    }
    
    if(btn) btn.addEventListener('click', toggleSidebar);
</script>

<style>
    .bg-header { background-color: #9b4d5c; }
    .bg-maroon-700 { background-color: #7c2a38; }
    .bg-maroon-800 { background-color: #651f2e; }
    .text-maroon-700 { color: #7c2a38; }
    .bg-maroon-100 { background-color: #f8e4ea; }
</style>
@endsection