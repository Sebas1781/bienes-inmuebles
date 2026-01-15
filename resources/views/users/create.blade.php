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
            <h1 class="text-lg md:text-2xl font-semibold hidden sm:block">Crear Usuario</h1>
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
            <div class="max-w-2xl mx-auto">
                <div class="bg-white rounded-lg shadow-lg p-6 md:p-8">
                    <div class="flex items-center gap-3 mb-6 border-b pb-4">
                        <i class="fas fa-user-plus text-maroon-700 text-2xl"></i>
                        <h2 class="text-2xl font-bold text-gray-800">Registrar Nuevo Usuario</h2>
                    </div>

                    @if ($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
                        <p class="font-bold mb-1">Por favor corrige los siguientes errores:</p>
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Nombre Completo *</label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                   class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-maroon-700 transition"
                                   placeholder="Ej: Juan Pérez">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Correo Electrónico *</label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                   class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-maroon-700 transition"
                                   placeholder="correo@ejemplo.com">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Rol de Usuario *</label>
                            <div class="relative">
                                <select name="role" required
                                        class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-maroon-700 appearance-none bg-white transition">
                                    <option value="">Seleccione un rol...</option>
                                    <option value="usuario" {{ old('role') == 'usuario' ? 'selected' : '' }}>Usuario (Solo lectura)</option>
                                    <option value="administrador" {{ old('role') == 'administrador' ? 'selected' : '' }}>Administrador (Gestión)</option>
                                    <option value="super_administrador" {{ old('role') == 'super_administrador' ? 'selected' : '' }}>Super Administrador (Total)</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-700">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                            
                            <div class="mt-2 bg-blue-50 text-blue-800 text-xs p-3 rounded border border-blue-100">
                                <p class="font-bold flex items-center gap-1"><i class="fas fa-info-circle"></i> Permisos:</p>
                                <ul class="list-disc list-inside mt-1 space-y-1 ml-1">
                                    <li><strong>Usuario:</strong> Solo puede ver el listado de inmuebles.</li>
                                    <li><strong>Administrador:</strong> Puede crear, editar y eliminar inmuebles.</li>
                                    <li><strong>Super Admin:</strong> Control total de usuarios y sistema.</li>
                                </ul>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Contraseña *</label>
                                <input type="password" name="password" required
                                       class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-maroon-700 transition"
                                       placeholder="Mínimo 8 caracteres">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Confirmar Contraseña *</label>
                                <input type="password" name="password_confirmation" required
                                       class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-maroon-700 transition"
                                       placeholder="Repita la contraseña">
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row gap-4 pt-6 border-t mt-6">
                            <a href="{{ route('users.index') }}" class="flex-1 bg-gray-500 text-white py-3 px-6 rounded-lg font-semibold hover:bg-gray-600 transition flex items-center justify-center gap-2 shadow order-2 md:order-1">
                                <i class="fas fa-arrow-left"></i> Cancelar
                            </a>
                            <button type="submit" class="flex-1 bg-maroon-700 text-white py-3 px-6 rounded-lg font-semibold hover:bg-maroon-800 transition flex items-center justify-center gap-2 shadow order-1 md:order-2">
                                <i class="fas fa-save"></i> Guardar Usuario
                            </button>
                        </div>
                    </form>
                </div>
            </div>
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
    .focus\:ring-maroon-700:focus { --tw-ring-color: #7c2a38; }
</style>
@endsection