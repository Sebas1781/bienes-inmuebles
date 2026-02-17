@extends('layouts.app')

@section('content')
<style>
    .table-header-gradient {
        background: linear-gradient(135deg, #7c2d12 0%, #991b1b 100%);
    }
    .stat-card {
        opacity: 0;
        animation: fadeInUp 0.6s ease forwards;
    }
    .stat-card-delay-1 { animation-delay: 0.1s; }
    .stat-card-delay-2 { animation-delay: 0.2s; }
    .stat-card-delay-3 { animation-delay: 0.3s; }
    .stat-card-delay-4 { animation-delay: 0.4s; }
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease forwards;
    }
    .table-row-animate {
        opacity: 0;
        animation: fadeInUp 0.4s ease forwards;
    }
</style>
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-gray-100 to-gray-200 flex flex-col relative">

    <x-header title="Bienes Muebles" />

    <div class="flex flex-1 relative">

        <x-sidebar active="movables" />

        <main class="flex-1 p-4 md:p-8 overflow-y-auto w-full md:ml-64">

            @if(session('success'))
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-xl shadow-sm animate-slide-in-right">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center animate-bounce-in">
                        <i class="fas fa-check text-green-600"></i>
                    </div>
                    <div>
                        <p class="font-bold">Éxito</p>
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            </div>
            @endif

            <h2 class="text-xl md:text-2xl font-bold mb-6 text-gray-800 flex items-center gap-3 animate-fade-in">
                <div class="w-1.5 h-7 bg-gradient-to-b from-maroon-700 to-red-400 rounded-full"></div>
                Resumen General
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">

                <div class="stat-card stat-card-delay-1 bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-500 p-6 flex flex-col items-center border border-gray-100 group cursor-default">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-red-50 to-rose-100 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-500">
                        <i class="fas fa-box text-maroon-700 text-2xl"></i>
                    </div>
                    <span class="text-3xl font-extrabold text-gray-800 counter" data-target="{{ $totalMuebles }}">0</span>
                    <span class="text-xs text-gray-400 font-semibold uppercase tracking-widest mt-1">Total Muebles</span>
                    <div class="w-full h-1 bg-gradient-to-r from-transparent via-maroon-700 to-transparent rounded-full mt-3 opacity-30"></div>
                </div>

                <div class="stat-card stat-card-delay-2 bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-500 cursor-pointer p-6 flex flex-col items-center border border-gray-100 group"
                     onclick="toggleModal('modalAreas')">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-500">
                        <i class="fas fa-building text-blue-600 text-2xl"></i>
                    </div>
                    <span class="text-3xl font-extrabold text-gray-800 counter" data-target="{{ $porArea->count() }}">0</span>
                    <span class="text-xs text-gray-400 font-semibold uppercase tracking-widest mt-1">Áreas</span>
                    <p class="text-xs text-blue-500 mt-2 font-medium group-hover:translate-x-1 transition-transform duration-300">Ver detalles <i class="fas fa-arrow-right ml-1"></i></p>
                </div>

                <div class="stat-card stat-card-delay-3 bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-500 cursor-pointer p-6 flex flex-col items-center border border-gray-100 group"
                     onclick="toggleModal('modalMarcas')">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-green-50 to-emerald-100 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-500">
                        <i class="fas fa-tag text-green-600 text-2xl"></i>
                    </div>
                    <span class="text-3xl font-extrabold text-gray-800 counter" data-target="{{ $porMarca->count() }}">0</span>
                    <span class="text-xs text-gray-400 font-semibold uppercase tracking-widest mt-1">Marcas</span>
                    <p class="text-xs text-green-500 mt-2 font-medium group-hover:translate-x-1 transition-transform duration-300">Ver listado <i class="fas fa-arrow-right ml-1"></i></p>
                </div>

                <div class="stat-card stat-card-delay-4 bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-500 cursor-pointer p-6 flex flex-col items-center border border-gray-100 group"
                     onclick="toggleModal('modalResguardatarios')">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-orange-50 to-amber-100 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-500">
                        <i class="fas fa-user-shield text-orange-500 text-2xl"></i>
                    </div>
                    <span class="text-3xl font-extrabold text-gray-800 counter" data-target="{{ $porResguardatario->count() }}">0</span>
                    <span class="text-xs text-gray-400 font-semibold uppercase tracking-widest mt-1">Resguardatarios</span>
                    <p class="text-xs text-orange-500 mt-2 font-medium group-hover:translate-x-1 transition-transform duration-300">Ver responsables <i class="fas fa-arrow-right ml-1"></i></p>
                </div>
            </div>

            <form method="GET" action="{{ route('movables.index') }}" class="bg-white/80 backdrop-blur-sm p-5 rounded-2xl shadow-sm mb-6 flex flex-col md:flex-row gap-4 items-center justify-between border border-gray-100 animate-fade-in-up">
                <div class="w-full md:flex-1 space-y-4 md:space-y-0 md:flex md:gap-4">

                    <div class="flex-1">
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1.5 tracking-wider">Buscar por nombre</label>
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" class="w-full border border-gray-200 rounded-xl py-2.5 px-4 pl-10 focus:outline-none focus:ring-2 focus:ring-maroon-700/30 focus:border-maroon-700 transition-all duration-300 bg-white/70" placeholder="Ej: Escritorio, Laptop...">
                            <span class="absolute left-3.5 top-3 text-gray-300"><i class="fas fa-search"></i></span>
                        </div>
                    </div>

                    <div class="flex-1">
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1.5 tracking-wider">Filtrar por área</label>
                        <select name="area" class="w-full border border-gray-200 rounded-xl py-2.5 px-4 focus:outline-none focus:ring-2 focus:ring-maroon-700/30 focus:border-maroon-700 bg-white/70 transition-all duration-300">
                            <option value="">Todas las áreas</option>
                            @foreach($porArea as $area)
                                <option value="{{ $area->area }}" {{ request('area') == $area->area ? 'selected' : '' }}>{{ $area->area }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex-1">
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1.5 tracking-wider">Filtrar por costo</label>
                        <select name="tipo_costo" class="w-full border border-gray-200 rounded-xl py-2.5 px-4 focus:outline-none focus:ring-2 focus:ring-maroon-700/30 focus:border-maroon-700 bg-white/70 transition-all duration-300">
                            <option value="">Todos los tipos</option>
                            <option value="Alto Costo" {{ request('tipo_costo') == 'Alto Costo' ? 'selected' : '' }}>Alto Costo</option>
                            <option value="Bajo Costo" {{ request('tipo_costo') == 'Bajo Costo' ? 'selected' : '' }}>Bajo Costo</option>
                        </select>
                    </div>
                </div>

                <div class="flex gap-2 w-full md:w-auto mt-2 md:mt-6">
                    <button type="submit" class="bg-gray-800 text-white px-5 py-2.5 rounded-xl font-semibold hover:bg-gray-900 transition-all duration-300 flex-1 md:flex-none flex justify-center gap-2 items-center hover:shadow-lg hover:-translate-y-0.5">
                        <i class="fas fa-filter"></i> <span class="md:hidden lg:inline">Filtrar</span>
                    </button>
                    <a href="{{ route('movables.index') }}" class="bg-gray-500 text-white px-5 py-2.5 rounded-xl font-semibold hover:bg-gray-600 transition-all duration-300 flex-1 md:flex-none flex justify-center gap-2 items-center hover:shadow-lg hover:-translate-y-0.5">
                        <i class="fas fa-times"></i> <span class="md:hidden lg:inline">Limpiar</span>
                    </a>
                    <a href="{{ route('movables.create') }}" class="btn-maroon-gradient text-white px-5 py-2.5 rounded-xl font-semibold transition-all duration-300 flex-1 md:flex-none flex justify-center gap-2 items-center hover:shadow-lg hover:-translate-y-0.5">
                        <i class="fas fa-plus"></i> <span class="md:hidden lg:inline">Nuevo</span>
                    </a>
                </div>
            </form>

            <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100 animate-fade-in-up">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <thead>
                            <tr class="table-header-gradient text-white text-xs uppercase tracking-wider">
                                <th class="py-4 px-5 font-semibold">No. Consecutivo</th>
                                <th class="py-4 px-5 font-semibold">Cuenta</th>
                                <th class="py-4 px-5 font-semibold">Nombre del Mueble</th>
                                <th class="py-4 px-5 font-semibold">Marca</th>
                                <th class="py-4 px-5 font-semibold">Modelo</th>
                                <th class="py-4 px-5 font-semibold">Resguardatario</th>
                                <th class="py-4 px-5 font-semibold">Área</th>
                                <th class="py-4 px-5 text-center font-semibold">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($movables as $index => $movable)
                            <tr class="table-row-animate hover:bg-gradient-to-r hover:from-rose-50/50 hover:to-transparent transition-all duration-300" style="animation-delay: {{ $index * 80 }}ms">
                                <td class="py-4 px-5 font-semibold text-gray-800">{{ $movable->numero_consecutivo }}</td>
                                <td class="py-4 px-5 text-gray-500">{{ $movable->cuenta }}-{{ $movable->sub_cuenta }}</td>
                                <td class="py-4 px-5 font-medium text-gray-700">{{ $movable->nombre_mueble ?? 'Sin nombre' }}</td>
                                <td class="py-4 px-5 text-gray-500">{{ $movable->marca ?? 'N/A' }}</td>
                                <td class="py-4 px-5 text-gray-500">{{ $movable->modelo ?? 'N/A' }}</td>
                                <td class="py-4 px-5 text-gray-600">{{ $movable->nombre_resguardatario ?? 'Sin asignar' }}</td>
                                <td class="py-4 px-5 text-gray-500">{{ $movable->area ?? 'N/A' }}</td>
                                <td class="py-4 px-5 text-center">
                                    <div class="flex gap-2 justify-center">
                                        <a href="{{ route('movables.edit', $movable->numero_consecutivo) }}" class="inline-flex items-center justify-center w-9 h-9 rounded-xl text-gray-400 hover:text-maroon-700 hover:bg-maroon-100/50 transition-all duration-300 hover:scale-110" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('movables.destroy', $movable->numero_consecutivo) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Está seguro que desea eliminar este bien mueble?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center justify-center w-9 h-9 rounded-xl text-gray-400 hover:text-red-600 hover:bg-red-100/50 transition-all duration-300 hover:scale-110" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-16 text-gray-400">
                                    <div class="flex flex-col items-center animate-fade-in">
                                        <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                                            <i class="fas fa-box-open text-3xl text-gray-300"></i>
                                        </div>
                                        <p class="font-medium text-lg">No se encontraron bienes muebles</p>
                                        <p class="text-sm mt-1">Agrega un nuevo bien mueble para comenzar</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($movables->hasPages())
                <div class="px-5 py-4 border-t border-gray-100 bg-gray-50/50">
                    {{ $movables->links() }}
                </div>
                @endif
            </div>

        </main>
    </div>
</div>

{{-- Modales --}}
<div id="modalAreas" class="modal-overlay fixed inset-0 bg-black/20 backdrop-blur-sm hidden items-center justify-center z-50 p-4" onclick="closeModalOnBackdrop(event, 'modalAreas')">
    <div class="modal-content bg-white rounded-2xl shadow-2xl p-6 max-w-md w-full mx-auto transform transition-all relative border border-gray-100">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-maroon-700 flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center"><i class="fas fa-building text-blue-600 text-sm"></i></div>
                Bienes por Área
            </h3>
            <button onclick="closeModal('modalAreas')" class="w-8 h-8 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition-all flex items-center justify-center"><i class="fas fa-times"></i></button>
        </div>
        <div class="space-y-2 max-h-96 overflow-y-auto custom-scrollbar pr-2">
            @foreach($porArea as $area)
            <div class="flex justify-between items-center p-3.5 bg-gray-50/80 rounded-xl hover:bg-blue-50/50 transition-all duration-300 border border-transparent hover:border-blue-100">
                <span class="font-semibold text-gray-700">{{ $area->area ?? 'Sin definir' }}</span>
                <span class="bg-gradient-to-r from-maroon-700 to-red-500 text-white px-3 py-1 rounded-full text-sm font-bold shadow-sm">{{ $area->total }}</span>
            </div>
            @endforeach
            @if($porArea->isEmpty())
                <p class="text-center text-gray-500 py-4">No hay datos disponibles.</p>
            @endif
        </div>
    </div>
</div>

<div id="modalMarcas" class="modal-overlay fixed inset-0 bg-black/20 backdrop-blur-sm hidden items-center justify-center z-50 p-4" onclick="closeModalOnBackdrop(event, 'modalMarcas')">
    <div class="modal-content bg-white rounded-2xl shadow-2xl p-6 max-w-md w-full mx-auto transform transition-all relative border border-gray-100">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-maroon-700 flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center"><i class="fas fa-tag text-green-600 text-sm"></i></div>
                Bienes por Marca
            </h3>
            <button onclick="closeModal('modalMarcas')" class="w-8 h-8 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition-all flex items-center justify-center"><i class="fas fa-times"></i></button>
        </div>
        <div class="space-y-2 max-h-96 overflow-y-auto custom-scrollbar pr-2">
            @foreach($porMarca as $marca)
            <div class="flex justify-between items-center p-3.5 bg-gray-50/80 rounded-xl hover:bg-green-50/50 transition-all duration-300 border border-transparent hover:border-green-100">
                <span class="font-semibold text-gray-700">{{ $marca->marca ?? 'Sin definir' }}</span>
                <span class="bg-gradient-to-r from-maroon-700 to-red-500 text-white px-3 py-1 rounded-full text-sm font-bold shadow-sm">{{ $marca->total }}</span>
            </div>
            @endforeach
            @if($porMarca->isEmpty())
                <p class="text-center text-gray-500 py-4">No hay datos disponibles.</p>
            @endif
        </div>
    </div>
</div>

<div id="modalResguardatarios" class="modal-overlay fixed inset-0 bg-black/20 backdrop-blur-sm hidden items-center justify-center z-50 p-4" onclick="closeModalOnBackdrop(event, 'modalResguardatarios')">
    <div class="modal-content bg-white rounded-2xl shadow-2xl p-6 max-w-md w-full mx-auto transform transition-all relative border border-gray-100">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-maroon-700 flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-orange-50 flex items-center justify-center"><i class="fas fa-user-shield text-orange-500 text-sm"></i></div>
                Bienes por Resguardatario
            </h3>
            <button onclick="closeModal('modalResguardatarios')" class="w-8 h-8 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition-all flex items-center justify-center"><i class="fas fa-times"></i></button>
        </div>
        <div class="space-y-2 max-h-96 overflow-y-auto custom-scrollbar pr-2">
            @foreach($porResguardatario as $resguardatario)
            <div class="flex justify-between items-center p-3.5 bg-gray-50/80 rounded-xl hover:bg-orange-50/50 transition-all duration-300 border border-transparent hover:border-orange-100">
                <span class="font-semibold text-gray-700">{{ $resguardatario->nombre_resguardatario ?? 'Sin definir' }}</span>
                <span class="bg-gradient-to-r from-maroon-700 to-red-500 text-white px-3 py-1 rounded-full text-sm font-bold shadow-sm">{{ $resguardatario->total }}</span>
            </div>
            @endforeach
            @if($porResguardatario->isEmpty())
                <p class="text-center text-gray-500 py-4">No hay datos disponibles.</p>
            @endif
        </div>
    </div>
</div>

<script>
    function toggleModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal.classList.contains('hidden')) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        } else {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function closeModalOnBackdrop(event, modalId) {
        if (event.target.classList.contains('modal-overlay')) {
            closeModal(modalId);
        }
    }

    // Contador animado para las tarjetas de estadísticas
    document.addEventListener('DOMContentLoaded', function() {
        const counters = document.querySelectorAll('.counter');
        counters.forEach(counter => {
            const target = parseInt(counter.getAttribute('data-target'));
            const duration = 2000;
            const increment = target / (duration / 16);
            let current = 0;

            const updateCounter = () => {
                current += increment;
                if (current < target) {
                    counter.textContent = Math.floor(current);
                    requestAnimationFrame(updateCounter);
                } else {
                    counter.textContent = target;
                }
            };

            updateCounter();
        });
    });
</script>

@endsection
