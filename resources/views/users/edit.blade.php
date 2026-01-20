@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 flex flex-col relative">

    <x-header title="Editar Usuario" />

    <div class="flex flex-1 relative overflow-hidden">

        <x-sidebar active="users" />

        <main class="flex-1 p-4 md:p-8 overflow-y-auto w-full">
            <div class="max-w-2xl mx-auto">
                <div class="bg-white rounded-lg shadow-lg p-6 md:p-8">

                    <div class="flex items-center gap-3 mb-6 border-b pb-4">
                        <i class="fas fa-user-edit text-maroon-700 text-2xl"></i>
                        <h2 class="text-2xl font-bold text-gray-800">Editar Usuario</h2>
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

                    <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Nombre Completo *</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                   class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-maroon-700 transition"
                                   placeholder="Nombre del usuario">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Correo Electrónico *</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                   class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-maroon-700 transition"
                                   placeholder="correo@ejemplo.com">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Rol de Usuario *</label>
                            <div class="relative">
                                <select name="role" required
                                        class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-maroon-700 appearance-none bg-white transition">
                                    <option value="usuario" {{ old('role', $user->role) == 'usuario' ? 'selected' : '' }}>Usuario</option>
                                    <option value="administrador" {{ old('role', $user->role) == 'administrador' ? 'selected' : '' }}>Administrador</option>
                                    <option value="super_administrador" {{ old('role', $user->role) == 'super_administrador' ? 'selected' : '' }}>Super Administrador</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-700">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <div class="border-t pt-6 mt-2 bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-bold text-gray-800 mb-2 flex items-center gap-2">
                                <i class="fas fa-lock text-maroon-700"></i> Cambio de Contraseña
                            </h3>
                            <p class="text-sm text-gray-600 mb-4 ml-6">Deja estos campos en blanco si no deseas cambiar la contraseña actual.</p>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Nueva Contraseña</label>
                                    <input type="password" name="password"
                                           class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-maroon-700 transition"
                                           placeholder="Mínimo 8 caracteres">
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Confirmar Nueva Contraseña</label>
                                    <input type="password" name="password_confirmation"
                                           class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-maroon-700 transition"
                                           placeholder="Repite la contraseña">
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row gap-4 pt-6 border-t">
                            <a href="{{ route('users.index') }}" class="flex-1 bg-gray-500 text-white py-3 px-6 rounded-lg font-semibold hover:bg-gray-600 transition flex items-center justify-center gap-2 shadow order-2 md:order-1">
                                <i class="fas fa-arrow-left"></i> Cancelar
                            </a>
                            <button type="submit" class="flex-1 bg-maroon-700 text-white py-3 px-6 rounded-lg font-semibold hover:bg-maroon-800 transition flex items-center justify-center gap-2 shadow order-1 md:order-2">
                                <i class="fas fa-save"></i> Actualizar Usuario
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
