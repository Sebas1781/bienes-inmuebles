@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 flex flex-col">
    <!-- Header -->
    <header class="bg-header text-white py-6 px-8 flex items-center justify-between shadow">
        <div class="flex items-center gap-4">
            <img src="{{ asset('images/Recurso 8.png') }}" alt="Logo" class="h-10">
            <span class="text-3xl font-bold">Bienes Inmuebles</span>
        </div>
        <h1 class="text-2xl font-semibold">Editar Usuario</h1>
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
            <div class="max-w-2xl mx-auto">
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-bold mb-6 text-maroon-700">Editar Usuario</h2>

                    @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nombre Completo *</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                   class="w-full border rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-maroon-700"
                                   placeholder="Nombre del usuario">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico *</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                   class="w-full border rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-maroon-700"
                                   placeholder="correo@ejemplo.com">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Rol *</label>
                            <select name="role" required
                                    class="w-full border rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-maroon-700">
                                <option value="usuario" {{ old('role', $user->role) == 'usuario' ? 'selected' : '' }}>Usuario</option>
                                <option value="administrador" {{ old('role', $user->role) == 'administrador' ? 'selected' : '' }}>Administrador</option>
                                <option value="super_administrador" {{ old('role', $user->role) == 'super_administrador' ? 'selected' : '' }}>Super Administrador</option>
                            </select>
                        </div>

                        <div class="border-t pt-4">
                            <p class="text-sm text-gray-600 mb-4"><i class="fas fa-info-circle"></i> Deja los campos de contraseña en blanco si no deseas cambiarla</p>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nueva Contraseña</label>
                                    <input type="password" name="password"
                                           class="w-full border rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-maroon-700"
                                           placeholder="Mínimo 8 caracteres (opcional)">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Confirmar Nueva Contraseña</label>
                                    <input type="password" name="password_confirmation"
                                           class="w-full border rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-maroon-700"
                                           placeholder="Repite la contraseña (opcional)">
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-4 pt-4">
                            <button type="submit" class="flex-1 bg-maroon-700 text-white py-3 px-6 rounded-lg font-semibold hover:bg-maroon-800 transition flex items-center justify-center gap-2">
                                <i class="fas fa-save"></i> Actualizar Usuario
                            </button>
                            <a href="{{ route('users.index') }}" class="flex-1 bg-gray-500 text-white py-3 px-6 rounded-lg font-semibold hover:bg-gray-600 transition flex items-center justify-center gap-2">
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
