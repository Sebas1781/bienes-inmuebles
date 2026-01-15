<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Bienes Inmuebles</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-gray-100 to-gray-200 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full mx-4">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="bg-header text-white py-8 px-6 text-center">
                <img src="{{ asset('images/Recurso 8.png') }}" alt="Logo" class="h-16 mx-auto mb-4">
                <h1 class="text-3xl font-bold">Bienes Inmuebles</h1>
                <p class="text-maroon-200 mt-2">Sistema de Gestión</p>
            </div>

            <!-- Form -->
            <div class="p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Iniciar Sesión</h2>

                @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-envelope text-maroon-700 mr-2"></i>Correo Electrónico
                        </label>
                        <input 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required
                            class="w-full border-2 border-gray-300 rounded-lg py-3 px-4 focus:outline-none focus:ring-2 focus:ring-maroon-700 focus:border-transparent transition"
                            placeholder="tu@correo.com"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-lock text-maroon-700 mr-2"></i>Contraseña
                        </label>
                        <input 
                            type="password" 
                            name="password" 
                            required
                            class="w-full border-2 border-gray-300 rounded-lg py-3 px-4 focus:outline-none focus:ring-2 focus:ring-maroon-700 focus:border-transparent transition"
                            placeholder="••••••••"
                        >
                    </div>

                    <div class="flex items-center">
                        <input 
                            type="checkbox" 
                            name="remember" 
                            id="remember"
                            class="h-4 w-4 text-maroon-700 focus:ring-maroon-700 border-gray-300 rounded"
                        >
                        <label for="remember" class="ml-2 block text-sm text-gray-700">
                            Recordarme
                        </label>
                    </div>

                    <button 
                        type="submit"
                        class="w-full bg-maroon-700 text-white py-3 px-6 rounded-lg font-semibold hover:bg-maroon-800 transition flex items-center justify-center gap-2 shadow-lg"
                    >
                        <i class="fas fa-sign-in-alt"></i>
                        Ingresar
                    </button>
                </form>

                <!-- Credenciales de prueba -->
                <div class="mt-8 p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <p class="text-sm font-semibold text-blue-800 mb-2">
                        <i class="fas fa-info-circle"></i> Usuarios de prueba:
                    </p>
                    <div class="text-xs text-blue-700 space-y-1">
                        <p><strong>Super Admin:</strong> superadmin@example.com</p>
                        <p><strong>Admin:</strong> admin@example.com</p>
                        <p><strong>Usuario:</strong> usuario@example.com</p>
                        <p class="mt-2"><strong>Contraseña:</strong> password</p>
                    </div>
                </div>
            </div>
        </div>

        <p class="text-center text-gray-600 text-sm mt-6">
            © {{ date('Y') }} Sistema de Bienes Inmuebles
        </p>
    </div>

    <style>
        .bg-header { background-color: #9b4d5c; }
        .bg-maroon-700 { background-color: #7c2a38; }
        .bg-maroon-800 { background-color: #651f2e; }
        .text-maroon-700 { color: #7c2a38; }
        .text-maroon-200 { color: #e8b4c0; }
        .focus\:ring-maroon-700:focus { --tw-ring-color: #7c2a38; }
    </style>
</body>
</html>
