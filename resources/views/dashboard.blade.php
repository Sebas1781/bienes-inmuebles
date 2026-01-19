@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 flex flex-col relative">

    <header class="bg-header text-white py-4 px-4 md:px-8 flex items-center justify-between shadow sticky top-0 z-30 transition-all duration-300">
        
        <div class="flex items-center gap-4">
            <button id="mobile-menu-btn" class="md:hidden text-white hover:text-gray-200 focus:outline-none p-2">
                <i class="fas fa-bars text-2xl"></i>
            </button>

            <div class="flex items-center gap-2 md:gap-4">
                <img src="{{ asset('images/Recurso 8.png') }}" alt="Logo" class="h-8 md:h-10">
                <span class="text-lg md:text-3xl font-bold truncate">Bienes Inmuebles</span>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <h1 class="text-xl font-semibold hidden lg:block">Dashboard</h1>
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
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 py-3 px-4 rounded-lg bg-maroon-700 text-white font-semibold shadow-md">
                <i class="fas fa-warehouse"></i> Admin. Inmuebles
            </a>
            @if(auth()->user()->isSuperAdmin())
            <a href="{{ route('users.index') }}" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-maroon-100 transition text-maroon-700 font-semibold group">
                <i class="fas fa-users group-hover:scale-110 transition-transform"></i> Admin. Usuarios
            </a>
            @endif
        </aside>

        <main class="flex-1 p-4 md:p-8 overflow-y-auto w-full">
            
            @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm animate-fade-in-down">
                <p class="font-bold">Éxito</p>
                <p>{{ session('success') }}</p>
            </div>
            @endif

            <h2 class="text-xl md:text-2xl font-bold mb-6 text-gray-800">Resumen General</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">
                
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-6 flex flex-col items-center border-t-4 border-maroon-700">
                    <i class="fas fa-home text-maroon-700 text-3xl mb-2"></i>
                    <span class="text-3xl font-bold text-gray-800">{{ $totalInmuebles }}</span>
                    <span class="text-sm text-gray-500 font-medium uppercase tracking-wide">Total Inmuebles</span>
                </div>

                <div class="bg-white rounded-lg shadow hover:shadow-lg transition cursor-pointer p-6 flex flex-col items-center transform hover:-translate-y-1 duration-200"
                     onclick="toggleModal('modalTipos')">
                    <i class="fas fa-clipboard-list text-blue-600 text-3xl mb-2"></i>
                    <span class="text-3xl font-bold text-gray-800">{{ $tiposInmuebles->count() }}</span>
                    <span class="text-sm text-gray-500 font-medium uppercase tracking-wide">Categorías</span>
                    <p class="text-xs text-blue-500 mt-2">Ver detalles <i class="fas fa-arrow-right ml-1"></i></p>
                </div>

                <div class="bg-white rounded-lg shadow hover:shadow-lg transition cursor-pointer p-6 flex flex-col items-center transform hover:-translate-y-1 duration-200"
                     onclick="toggleModal('modalOcupacion')">
                    <i class="fas fa-user-check text-green-600 text-3xl mb-2"></i>
                    <span class="text-3xl font-bold text-gray-800">{{ $estadosOcupacion->sum('total') }}</span>
                    <span class="text-sm text-gray-500 font-medium uppercase tracking-wide">Estatus Ocupación</span>
                    <p class="text-xs text-green-500 mt-2">Ver estatus <i class="fas fa-arrow-right ml-1"></i></p>
                </div>

                <div class="bg-white rounded-lg shadow hover:shadow-lg transition cursor-pointer p-6 flex flex-col items-center transform hover:-translate-y-1 duration-200"
                     onclick="toggleModal('modalMantenimiento')">
                    <i class="fas fa-tools text-orange-500 text-3xl mb-2"></i>
                    <span class="text-3xl font-bold text-gray-800">{{ $estadosMantenimiento->sum('total') }}</span>
                    <span class="text-sm text-gray-500 font-medium uppercase tracking-wide">Mantenimiento</span>
                    <p class="text-xs text-orange-500 mt-2">Ver alertas <i class="fas fa-arrow-right ml-1"></i></p>
                </div>
            </div>

            <div class="bg-white p-4 rounded-lg shadow mb-6 flex flex-col md:flex-row gap-4 items-center justify-between">
                <div class="w-full md:flex-1 space-y-4 md:space-y-0 md:flex md:gap-4">
                    
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Buscar por nombre</label>
                        <div class="relative">
                            <input type="text" class="w-full border border-gray-300 rounded-lg py-2 px-4 pl-10 focus:outline-none focus:ring-2 focus:ring-maroon-700 transition-shadow" placeholder="Ej: Palacio Municipal...">
                            <span class="absolute left-3 top-2.5 text-gray-400"><i class="fas fa-search"></i></span>
                        </div>
                    </div>

                    <div class="flex-1">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Filtrar por tipo</label>
                        <select class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-maroon-700 bg-white">
                            <option value="">Todos los tipos</option>
                            @foreach($tiposInmuebles as $tipo)
                                <option value="{{ $tipo->tipo }}">{{ $tipo->tipo }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex gap-2 w-full md:w-auto mt-2 md:mt-6">
                    <button class="bg-gray-800 text-white px-4 py-2 rounded-lg font-semibold hover:bg-black transition flex-1 md:flex-none flex justify-center gap-2 items-center">
                        <i class="fas fa-filter"></i> <span class="md:hidden lg:inline">Filtrar</span>
                    </button>
                    <a href="{{ route('properties.create') }}" class="bg-maroon-700 text-white px-4 py-2 rounded-lg font-semibold hover:bg-red-900 transition shadow flex-1 md:flex-none flex justify-center gap-2 items-center">
                        <i class="fas fa-plus"></i> <span class="md:hidden lg:inline">Nuevo</span>
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <thead class="bg-maroon-700 text-white uppercase text-xs tracking-wider">
                            <tr>
                                <th class="py-3 px-4 font-semibold">Denominación</th>
                                <th class="py-3 px-4 font-semibold">Ubicación</th>
                                <th class="py-3 px-4 font-semibold">Comunidad</th>
                                <th class="py-3 px-4 font-semibold">Superficie Total</th>
                                <th class="py-3 px-4 font-semibold">Uso y Destino</th>
                                <th class="py-3 px-4 text-center font-semibold">Habitado</th>
                                <th class="py-3 px-4 text-center font-semibold">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($properties as $property)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="py-3 px-4 font-medium text-gray-900">{{ $property->denominacion ?? 'Sin nombre' }}</td>
                                <td class="py-3 px-4 text-gray-600 truncate max-w-xs" title="{{ $property->ubicacion }}">{{ Str::limit($property->ubicacion, 25) }}</td>
                                <td class="py-3 px-4 text-gray-600">{{ $property->comunidad }}</td>
                                <td class="py-3 px-4 text-gray-600">{{ $property->superficie_total }}</td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs font-semibold border">{{ $property->uso_destino ?? 'N/A' }}</span>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    @if($property->habitado)
                                        <span class="text-green-700 font-bold text-xs bg-green-100 px-2 py-1 rounded-full border border-green-200">SÍ</span>
                                    @else
                                        <span class="text-red-700 font-bold text-xs bg-red-100 px-2 py-1 rounded-full border border-red-200">NO</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <a href="{{ route('properties.edit', $property->id) }}" class="text-gray-400 hover:text-maroon-700 transition text-lg" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-10 text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-folder-open text-4xl mb-2 text-gray-300"></i>
                                        <p>No se encontraron registros.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($properties->hasPages())
                <div class="px-4 py-3 border-t bg-gray-50">
                    {{ $properties->links() }}
                </div>
                @endif
            </div>

        </main>
    </div>
</div>

<div id="modalTipos" class="modal-overlay fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4" onclick="closeModalOnBackdrop(event, 'modalTipos')">
    <div class="modal-content bg-white rounded-xl shadow-2xl p-6 max-w-md w-full mx-auto transform transition-all relative">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-maroon-700"><i class="fas fa-clipboard-list mr-2"></i>Tipos de Inmuebles</h3>
            <button onclick="closeModal('modalTipos')" class="text-gray-400 hover:text-red-500 transition"><i class="fas fa-times text-2xl"></i></button>
        </div>
        <div class="space-y-3 max-h-96 overflow-y-auto custom-scrollbar pr-2">
            @foreach($tiposInmuebles as $tipo)
            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg hover:bg-maroon-50 transition border border-gray-100">
                <span class="font-semibold text-gray-700">{{ $tipo->tipo ?? 'Sin definir' }}</span>
                <span class="bg-maroon-700 text-white px-3 py-1 rounded-full text-sm font-bold shadow">{{ $tipo->total }}</span>
            </div>
            @endforeach
            @if($tiposInmuebles->isEmpty())
                <p class="text-center text-gray-500 py-4">No hay datos disponibles.</p>
            @endif
        </div>
    </div>
</div>

<div id="modalOcupacion" class="modal-overlay fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4" onclick="closeModalOnBackdrop(event, 'modalOcupacion')">
    <div class="modal-content bg-white rounded-xl shadow-2xl p-6 max-w-md w-full mx-auto transform transition-all relative">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-maroon-700"><i class="fas fa-user-check mr-2"></i>Estatus Ocupación</h3>
            <button onclick="closeModal('modalOcupacion')" class="text-gray-400 hover:text-red-500 transition"><i class="fas fa-times text-2xl"></i></button>
        </div>
        <div class="space-y-3 max-h-96 overflow-y-auto custom-scrollbar pr-2">
            @foreach($estadosOcupacion as $estado)
            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg hover:bg-green-50 transition border border-gray-100">
                <span class="font-semibold text-gray-700">{{ $estado->estado_ocupacion }}</span>
                <span class="bg-maroon-700 text-white px-3 py-1 rounded-full text-sm font-bold shadow">{{ $estado->total }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div id="modalMantenimiento" class="modal-overlay fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4" onclick="closeModalOnBackdrop(event, 'modalMantenimiento')">
    <div class="modal-content bg-white rounded-xl shadow-2xl p-6 max-w-md w-full mx-auto transform transition-all relative">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-maroon-700"><i class="fas fa-tools mr-2"></i>Mantenimiento</h3>
            <button onclick="closeModal('modalMantenimiento')" class="text-gray-400 hover:text-red-500 transition"><i class="fas fa-times text-2xl"></i></button>
        </div>
        <div class="space-y-3 max-h-96 overflow-y-auto custom-scrollbar pr-2">
            @foreach($estadosMantenimiento as $estado)
            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg hover:bg-orange-50 transition border border-gray-100">
                <span class="font-semibold text-gray-700">{{ $estado->estado_mantenimiento }}</span>
                <span class="bg-maroon-700 text-white px-3 py-1 rounded-full text-sm font-bold shadow">{{ $estado->total }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    // --- LÓGICA DEL SIDEBAR MÓVIL ---
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
    
    // Abrir menú al hacer click en botón hamburguesa
    if(btn) btn.addEventListener('click', toggleSidebar);


    // --- LÓGICA DE MODALES ---
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        const modalContent = modal.querySelector('.modal-content');

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        // Animación suave de entrada
        setTimeout(() => {
            modalContent.style.transform = 'scale(1)';
            modalContent.style.opacity = '1';
        }, 10);
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        const modalContent = modal.querySelector('.modal-content');

        // Animación suave de salida
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

    // Cerrar con ESC
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            ['modalTipos', 'modalOcupacion', 'modalMantenimiento'].forEach(id => {
                const m = document.getElementById(id);
                if (m && !m.classList.contains('hidden')) closeModal(id);
            });
        }
    });
</script>

<style>
    /* Colores Personalizados */
    .bg-header { background-color: #9b4d5c; }
    .bg-maroon-700 { background-color: #7c2a38; }
    .text-maroon-700 { color: #7c2a38; }
    .bg-maroon-100 { background-color: #f8e4ea; }
    .bg-maroon-50 { background-color: #fef2f5; }

    /* Animaciones Modales */
    .modal-content {
        transform: scale(0.95);
        opacity: 0;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Scrollbar Personalizado */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cdcdcd;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #7c2a38;
    }

    /* Animación Fade In (Opcional) */
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-down {
        animation: fadeInDown 0.5s ease-out;
    }
</style>
@endsection