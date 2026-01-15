@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 flex flex-col">
    <header class="bg-header text-white py-6 px-8 flex items-center justify-between shadow">
        <div class="flex items-center gap-4">
            <img src="{{ asset('images/Recurso 8.png') }}" alt="Logo" class="h-10">
            <span class="text-3xl font-bold">Bienes Inmuebles</span>
        </div>
        <h1 class="text-2xl font-semibold">Dashboard</h1>
        <form action="{{ route('logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="text-red-400 hover:text-red-600 flex items-center gap-2">
                <i class="fas fa-sign-out-alt"></i> Cerrar sesión
            </button>
        </form>
    </header>

    <div class="flex flex-1">
        <aside class="w-64 bg-white border-r flex flex-col py-8 px-4 gap-2">
            <a href="{{ route('properties.create') }}" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-maroon-100 transition text-maroon-700 font-semibold"><i class="fas fa-plus-square"></i> Agregar inmueble</a>
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 py-3 px-4 rounded-lg bg-maroon-700 text-white font-semibold"><i class="fas fa-warehouse"></i> Administrador de inmuebles</a>
            @if(auth()->user()->isSuperAdmin())
            <a href="{{ route('users.index') }}" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-maroon-100 transition text-maroon-700 font-semibold"><i class="fas fa-users"></i> Administrador de usuarios</a>
            @endif
        </aside>

        <main class="flex-1 p-8">
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
            @endif

            <h2 class="text-xl font-bold mb-6">Administrador de Inmuebles</h2>
            
            <div class="grid grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
                    <i class="fas fa-home text-maroon-700 text-3xl mb-2"></i>
                    <span class="text-2xl font-bold">{{ $totalInmuebles }}</span>
                    <span class="text-gray-500">Total Inmuebles</span>
                </div>

                <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center cursor-pointer hover:shadow-lg transition"
                     onclick="toggleModal('modalTipos')">
                    <i class="fas fa-clipboard-list text-maroon-700 text-3xl mb-2"></i>
                    <span class="text-2xl font-bold">{{ $tiposInmuebles->count() }}</span>
                    <span class="text-gray-500">Uso de Inmuebles</span>
                </div>

                <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center cursor-pointer hover:shadow-lg transition"
                     onclick="toggleModal('modalOcupacion')">
                    <i class="fas fa-user-check text-maroon-700 text-3xl mb-2"></i>
                    <span class="text-2xl font-bold">{{ $estadosOcupacion->sum('total') }}</span>
                    <span class="text-gray-500">Estatus Ocupación</span>
                </div>

                <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center cursor-pointer hover:shadow-lg transition"
                     onclick="toggleModal('modalMantenimiento')">
                    <i class="fas fa-tools text-maroon-700 text-3xl mb-2"></i>
                    <span class="text-2xl font-bold">{{ $estadosMantenimiento->sum('total') }}</span>
                    <span class="text-gray-500">Alertas Mantenimiento</span>
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
                        <option>Apartamento</option>
                        <option>Local Comercial</option>
                        <option>Oficina</option>
                    </select>
                </div>
                <button class="bg-gray-800 text-white px-6 py-2 rounded-lg font-semibold mt-6 h-10 flex items-center gap-2"><i class="fas fa-filter"></i> Filtrar</button>
                <a href="{{ route('properties.create') }}" class="bg-maroon-700 text-white px-6 py-2 rounded-lg font-semibold mt-6 h-10 flex items-center gap-2"><i class="fas fa-plus"></i> Crear inmueble</a>
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
                            <th class="py-3 px-4 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($properties as $property)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-3 px-4">{{ $property->denominacion ?? 'N/A' }}</td>
                            <td class="py-3 px-4 text-sm text-gray-600">{{ Str::limit($property->ubicacion, 20) }}</td>
                            <td class="py-3 px-4">{{ $property->comunidad }}</td>
                            <td class="py-3 px-4 text-xs font-mono">{{ $property->coordenadas }}</td>
                            <td class="py-3 px-4">{{ $property->superficie_total }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 bg-gray-100 rounded text-xs font-semibold">{{ $property->uso_destino ?? 'Sin definir' }}</span>
                            </td>
                            <td class="py-3 px-4">
                                @if($property->habitado)
                                    <span class="text-green-600 font-bold text-xs bg-green-100 px-2 py-1 rounded-full">SÍ</span>
                                @else
                                    <span class="text-red-600 font-bold text-xs bg-red-100 px-2 py-1 rounded-full">NO</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-center">
                                <a href="#" class="text-gray-500 hover:text-maroon-700"><i class="fas fa-eye"></i></a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-8 text-gray-500">No hay inmuebles registrados.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $properties->links() }}
                </div>
            </div>
        </main>
    </div>
</div>

<div id="modalTipos" class="modal-overlay fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" onclick="closeModalOnBackdrop(event, 'modalTipos')">
    <div class="modal-content bg-white rounded-xl shadow-2xl p-6 max-w-md w-full mx-4 transform transition-all">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-maroon-700"><i class="fas fa-clipboard-list mr-2"></i>Tipos de Inmuebles</h3>
            <button onclick="closeModal('modalTipos')" class="text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>
        <div class="space-y-3 max-h-96 overflow-y-auto">
            @foreach($tiposInmuebles as $tipo)
            <div class="flex justify-between items-center p-4 bg-gradient-to-r from-gray-50 to-gray-100 rounded-lg hover:from-maroon-50 hover:to-maroon-100 transition-all duration-200 transform hover:scale-102">
                <span class="font-semibold text-gray-700 text-lg">{{ $tipo->tipo }}</span>
                <span class="bg-maroon-700 text-white px-4 py-2 rounded-full text-sm font-bold shadow-md">{{ $tipo->total }}</span>
            </div>
            @endforeach
            @if($tiposInmuebles->count() === 0)
            <p class="text-gray-500 text-center py-8 text-lg">No hay tipos de inmuebles registrados</p>
            @endif
        </div>
    </div>
</div>

<div id="modalOcupacion" class="modal-overlay fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" onclick="closeModalOnBackdrop(event, 'modalOcupacion')">
    <div class="modal-content bg-white rounded-xl shadow-2xl p-6 max-w-md w-full mx-4 transform transition-all">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-maroon-700"><i class="fas fa-user-check mr-2"></i>Estado de Ocupación</h3>
            <button onclick="closeModal('modalOcupacion')" class="text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>
        <div class="space-y-3 max-h-96 overflow-y-auto">
            @foreach($estadosOcupacion as $estado)
            <div class="flex justify-between items-center p-4 bg-gradient-to-r from-gray-50 to-gray-100 rounded-lg hover:from-maroon-50 hover:to-maroon-100 transition-all duration-200 transform hover:scale-102">
                <span class="font-semibold text-gray-700 text-lg">{{ $estado->estado_ocupacion }}</span>
                <span class="bg-maroon-700 text-white px-4 py-2 rounded-full text-sm font-bold shadow-md">{{ $estado->total }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div id="modalMantenimiento" class="modal-overlay fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" onclick="closeModalOnBackdrop(event, 'modalMantenimiento')">
    <div class="modal-content bg-white rounded-xl shadow-2xl p-6 max-w-md w-full mx-4 transform transition-all">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-maroon-700"><i class="fas fa-tools mr-2"></i>Estado de Mantenimiento</h3>
            <button onclick="closeModal('modalMantenimiento')" class="text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>
        <div class="space-y-3 max-h-96 overflow-y-auto">
            @foreach($estadosMantenimiento as $estado)
            <div class="flex justify-between items-center p-4 bg-gradient-to-r from-gray-50 to-gray-100 rounded-lg hover:from-maroon-50 hover:to-maroon-100 transition-all duration-200 transform hover:scale-102">
                <span class="font-semibold text-gray-700 text-lg">{{ $estado->estado_mantenimiento }}</span>
                <span class="bg-maroon-700 text-white px-4 py-2 rounded-full text-sm font-bold shadow-md">{{ $estado->total }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>

<script>
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    const modalContent = modal.querySelector('.modal-content');

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    // Animación de entrada
    setTimeout(() => {
        modal.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
        modalContent.style.transform = 'scale(1)';
        modalContent.style.opacity = '1';
    }, 10);
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    const modalContent = modal.querySelector('.modal-content');

    // Animación de salida
    modal.style.backgroundColor = 'rgba(0, 0, 0, 0)';
    modalContent.style.transform = 'scale(0.95)';
    modalContent.style.opacity = '0';

    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 300);
}

function closeModalOnBackdrop(event, modalId) {
    if (event.target.classList.contains('modal-overlay')) {
        closeModal(modalId);
    }
}

function toggleModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal.classList.contains('hidden')) {
        openModal(modalId);
    } else {
        closeModal(modalId);
    }
}

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        ['modalTipos', 'modalOcupacion', 'modalMantenimiento'].forEach(modalId => {
            const modal = document.getElementById(modalId);
            if (modal && !modal.classList.contains('hidden')) {
                closeModal(modalId);
            }
        });
    }
});
</script>

<style>
    .bg-header { background-color: #9b4d5c; }
    .bg-maroon-700 { background-color: #7c2a38; }
    .text-maroon-700 { color: #7c2a38; }
    .bg-maroon-100 { background-color: #f8e4ea; }
    .bg-maroon-50 { background-color: #fef2f5; }

    .modal-overlay {
        transition: background-color 0.3s ease;
        background-color: rgba(0, 0, 0, 0);
    }

    .modal-content {
        transform: scale(0.95);
        opacity: 0;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .hover\:scale-102:hover {
        transform: scale(1.02);
    }

    .max-h-96::-webkit-scrollbar {
        width: 8px;
    }

    .max-h-96::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .max-h-96::-webkit-scrollbar-thumb {
        background: #7c2a38;
        border-radius: 10px;
    }

    .max-h-96::-webkit-scrollbar-thumb:hover {
        background: #651f2e;
    }
</style>
@endsection