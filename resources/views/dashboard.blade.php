@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-gray-100 to-gray-200 flex flex-col relative">

    <x-header title="Dashboard" />

    <div class="flex flex-1 relative">

        <x-sidebar active="dashboard" />

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
                        <i class="fas fa-home text-maroon-700 text-2xl"></i>
                    </div>
                    <span class="text-3xl font-extrabold text-gray-800 counter" data-target="{{ $totalInmuebles }}">0</span>
                    <span class="text-xs text-gray-400 font-semibold uppercase tracking-widest mt-1">Total Inmuebles</span>
                    <div class="w-full h-1 bg-gradient-to-r from-transparent via-maroon-700 to-transparent rounded-full mt-3 opacity-30"></div>
                </div>

                <div class="stat-card stat-card-delay-2 bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-500 cursor-pointer p-6 flex flex-col items-center border border-gray-100 group"
                     onclick="toggleModal('modalTipos')">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-500">
                        <i class="fas fa-clipboard-list text-blue-600 text-2xl"></i>
                    </div>
                    <span class="text-3xl font-extrabold text-gray-800 counter" data-target="{{ $tiposInmuebles->count() }}">0</span>
                    <span class="text-xs text-gray-400 font-semibold uppercase tracking-widest mt-1">Categorías</span>
                    <p class="text-xs text-blue-500 mt-2 font-medium group-hover:translate-x-1 transition-transform duration-300">Ver detalles <i class="fas fa-arrow-right ml-1"></i></p>
                </div>

                <div class="stat-card stat-card-delay-3 bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-500 cursor-pointer p-6 flex flex-col items-center border border-gray-100 group"
                     onclick="toggleModal('modalOcupacion')">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-green-50 to-emerald-100 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-500">
                        <i class="fas fa-user-check text-green-600 text-2xl"></i>
                    </div>
                    <span class="text-3xl font-extrabold text-gray-800 counter" data-target="{{ $estadosOcupacion->sum('total') }}">0</span>
                    <span class="text-xs text-gray-400 font-semibold uppercase tracking-widest mt-1">Estatus Ocupación</span>
                    <p class="text-xs text-green-500 mt-2 font-medium group-hover:translate-x-1 transition-transform duration-300">Ver estatus <i class="fas fa-arrow-right ml-1"></i></p>
                </div>

                <div class="stat-card stat-card-delay-4 bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-500 cursor-pointer p-6 flex flex-col items-center border border-gray-100 group"
                     onclick="toggleModal('modalMantenimiento')">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-orange-50 to-amber-100 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-500">
                        <i class="fas fa-tools text-orange-500 text-2xl"></i>
                    </div>
                    <span class="text-3xl font-extrabold text-gray-800 counter" data-target="{{ $estadosMantenimiento->sum('total') }}">0</span>
                    <span class="text-xs text-gray-400 font-semibold uppercase tracking-widest mt-1">Mantenimiento</span>
                    <p class="text-xs text-orange-500 mt-2 font-medium group-hover:translate-x-1 transition-transform duration-300">Ver alertas <i class="fas fa-arrow-right ml-1"></i></p>
                </div>
            </div>

            <div class="bg-white/80 backdrop-blur-sm p-5 rounded-2xl shadow-sm mb-6 flex flex-col md:flex-row gap-4 items-center justify-between border border-gray-100 animate-fade-in-up">
                <div class="w-full md:flex-1 space-y-4 md:space-y-0 md:flex md:gap-4">

                    <div class="flex-1">
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1.5 tracking-wider">Buscar por nombre</label>
                        <div class="relative">
                            <input type="text" class="w-full border border-gray-200 rounded-xl py-2.5 px-4 pl-10 focus:outline-none focus:ring-2 focus:ring-maroon-700/30 focus:border-maroon-700 transition-all duration-300 bg-white/70" placeholder="Ej: Palacio Municipal...">
                            <span class="absolute left-3.5 top-3 text-gray-300"><i class="fas fa-search"></i></span>
                        </div>
                    </div>

                    <div class="flex-1">
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1.5 tracking-wider">Filtrar por tipo</label>
                        <select class="w-full border border-gray-200 rounded-xl py-2.5 px-4 focus:outline-none focus:ring-2 focus:ring-maroon-700/30 focus:border-maroon-700 bg-white/70 transition-all duration-300">
                            <option value="">Todos los tipos</option>
                            @foreach($tiposInmuebles as $tipo)
                                <option value="{{ $tipo->tipo }}">{{ $tipo->tipo }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex gap-2 w-full md:w-auto mt-2 md:mt-6">
                    <button class="bg-gray-800 text-white px-5 py-2.5 rounded-xl font-semibold hover:bg-gray-900 transition-all duration-300 flex-1 md:flex-none flex justify-center gap-2 items-center hover:shadow-lg hover:-translate-y-0.5">
                        <i class="fas fa-filter"></i> <span class="md:hidden lg:inline">Filtrar</span>
                    </button>
                    <a href="{{ route('properties.create') }}" class="btn-maroon-gradient text-white px-5 py-2.5 rounded-xl font-semibold transition-all duration-300 flex-1 md:flex-none flex justify-center gap-2 items-center hover:shadow-lg hover:-translate-y-0.5">
                        <i class="fas fa-plus"></i> <span class="md:hidden lg:inline">Nuevo</span>
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100 animate-fade-in-up">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <thead>
                            <tr class="table-header-gradient text-white text-xs uppercase tracking-wider">
                                <th class="py-4 px-5 font-semibold">Denominación</th>
                                <th class="py-4 px-5 font-semibold">Ubicación</th>
                                <th class="py-4 px-5 font-semibold">Comunidad</th>
                                <th class="py-4 px-5 font-semibold">Superficie Total</th>
                                <th class="py-4 px-5 font-semibold">Uso y Destino</th>
                                <th class="py-4 px-5 text-center font-semibold">Habitado</th>
                                <th class="py-4 px-5 text-center font-semibold">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($properties as $index => $property)
                            <tr class="table-row-animate hover:bg-gradient-to-r hover:from-rose-50/50 hover:to-transparent transition-all duration-300" style="animation-delay: {{ $index * 80 }}ms">
                                <td class="py-4 px-5 font-semibold text-gray-800">{{ $property->denominacion ?? 'Sin nombre' }}</td>
                                <td class="py-4 px-5 text-gray-500 truncate max-w-xs" title="{{ $property->ubicacion }}">{{ Str::limit($property->ubicacion, 25) }}</td>
                                <td class="py-4 px-5 text-gray-500">{{ $property->comunidad }}</td>
                                <td class="py-4 px-5 text-gray-500 font-medium">{{ number_format($property->superficie_total, 2) }} m²</td>
                                <td class="py-4 px-5">
                                    <span class="px-3 py-1 bg-gradient-to-r from-gray-50 to-gray-100 text-gray-600 rounded-lg text-xs font-semibold border border-gray-200">{{ $property->uso_destino ?? 'N/A' }}</span>
                                </td>
                                <td class="py-4 px-5 text-center">
                                    @if($property->habitado)
                                        <span class="inline-flex items-center gap-1 text-green-700 font-bold text-xs bg-green-50 px-3 py-1.5 rounded-full border border-green-200">
                                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span> SÍ
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-red-700 font-bold text-xs bg-red-50 px-3 py-1.5 rounded-full border border-red-200">
                                            <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> NO
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-5 text-center">
                                    <a href="{{ route('properties.edit', $property->id) }}" class="inline-flex items-center justify-center w-9 h-9 rounded-xl text-gray-400 hover:text-maroon-700 hover:bg-maroon-100/50 transition-all duration-300 hover:scale-110" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-16 text-gray-400">
                                    <div class="flex flex-col items-center animate-fade-in">
                                        <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                                            <i class="fas fa-folder-open text-3xl text-gray-300"></i>
                                        </div>
                                        <p class="font-medium text-lg">No se encontraron registros</p>
                                        <p class="text-sm mt-1">Agrega un nuevo inmueble para comenzar</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($properties->hasPages())
                <div class="px-5 py-4 border-t border-gray-100 bg-gray-50/50">
                    {{ $properties->links() }}
                </div>
                @endif
            </div>

        </main>
    </div>
</div>

{{-- Modales --}}
<div id="modalTipos" class="modal-overlay fixed inset-0 bg-black/20 backdrop-blur-sm hidden items-center justify-center z-50 p-4" onclick="closeModalOnBackdrop(event, 'modalTipos')">
    <div class="modal-content bg-white rounded-2xl shadow-2xl p-6 max-w-md w-full mx-auto transform transition-all relative border border-gray-100">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-maroon-700 flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center"><i class="fas fa-clipboard-list text-blue-600 text-sm"></i></div>
                Tipos de Inmuebles
            </h3>
            <button onclick="closeModal('modalTipos')" class="w-8 h-8 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition-all flex items-center justify-center"><i class="fas fa-times"></i></button>
        </div>
        <div class="space-y-2 max-h-96 overflow-y-auto custom-scrollbar pr-2">
            @foreach($tiposInmuebles as $tipo)
            <div class="flex justify-between items-center p-3.5 bg-gray-50/80 rounded-xl hover:bg-blue-50/50 transition-all duration-300 border border-transparent hover:border-blue-100">
                <span class="font-semibold text-gray-700">{{ $tipo->tipo ?? 'Sin definir' }}</span>
                <span class="bg-gradient-to-r from-maroon-700 to-red-500 text-white px-3 py-1 rounded-full text-sm font-bold shadow-sm">{{ $tipo->total }}</span>
            </div>
            @endforeach
            @if($tiposInmuebles->isEmpty())
                <p class="text-center text-gray-500 py-4">No hay datos disponibles.</p>
            @endif
        </div>
    </div>
</div>

<div id="modalOcupacion" class="modal-overlay fixed inset-0 bg-black/20 backdrop-blur-sm hidden items-center justify-center z-50 p-4" onclick="closeModalOnBackdrop(event, 'modalOcupacion')">
    <div class="modal-content bg-white rounded-2xl shadow-2xl p-6 max-w-md w-full mx-auto transform transition-all relative border border-gray-100">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-maroon-700 flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center"><i class="fas fa-user-check text-green-600 text-sm"></i></div>
                Estatus Ocupación
            </h3>
            <button onclick="closeModal('modalOcupacion')" class="w-8 h-8 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition-all flex items-center justify-center"><i class="fas fa-times"></i></button>
        </div>
        <div class="space-y-2 max-h-96 overflow-y-auto custom-scrollbar pr-2">
            @foreach($estadosOcupacion as $estado)
            <div class="flex justify-between items-center p-3.5 bg-gray-50/80 rounded-xl hover:bg-green-50/50 transition-all duration-300 border border-transparent hover:border-green-100">
                <span class="font-semibold text-gray-700">{{ $estado->estado_ocupacion }}</span>
                <span class="bg-gradient-to-r from-maroon-700 to-red-500 text-white px-3 py-1 rounded-full text-sm font-bold shadow-sm">{{ $estado->total }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div id="modalMantenimiento" class="modal-overlay fixed inset-0 bg-black/20 backdrop-blur-sm hidden items-center justify-center z-50 p-4" onclick="closeModalOnBackdrop(event, 'modalMantenimiento')">
    <div class="modal-content bg-white rounded-2xl shadow-2xl p-6 max-w-md w-full mx-auto transform transition-all relative border border-gray-100">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-maroon-700 flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-orange-50 flex items-center justify-center"><i class="fas fa-tools text-orange-500 text-sm"></i></div>
                Mantenimiento
            </h3>
            <button onclick="closeModal('modalMantenimiento')" class="w-8 h-8 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition-all flex items-center justify-center"><i class="fas fa-times"></i></button>
        </div>
        <div class="space-y-2 max-h-96 overflow-y-auto custom-scrollbar pr-2">
            @foreach($estadosMantenimiento as $estado)
            <div class="flex justify-between items-center p-3.5 bg-gray-50/80 rounded-xl hover:bg-orange-50/50 transition-all duration-300 border border-transparent hover:border-orange-100">
                <span class="font-semibold text-gray-700">{{ $estado->estado_mantenimiento }}</span>
                <span class="bg-gradient-to-r from-maroon-700 to-red-500 text-white px-3 py-1 rounded-full text-sm font-bold shadow-sm">{{ $estado->total }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    // --- LÓGICA DE MODALES ---
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        const modalContent = modal.querySelector('.modal-content');

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        setTimeout(() => {
            modalContent.style.transform = 'scale(1) translateY(0)';
            modalContent.style.opacity = '1';
        }, 10);
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        const modalContent = modal.querySelector('.modal-content');

        modalContent.style.transform = 'scale(0.95) translateY(10px)';
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
            ['modalTipos', 'modalOcupacion', 'modalMantenimiento'].forEach(id => {
                const m = document.getElementById(id);
                if (m && !m.classList.contains('hidden')) closeModal(id);
            });
        }
    });

    // --- ANIMACIÓN DE CONTADORES ---
    function animateCounters() {
        const counters = document.querySelectorAll('.counter');
        counters.forEach(counter => {
            const target = +counter.getAttribute('data-target');
            const duration = 1200;
            const start = performance.now();

            function update(currentTime) {
                const elapsed = currentTime - start;
                const progress = Math.min(elapsed / duration, 1);
                const eased = 1 - Math.pow(1 - progress, 4);
                counter.textContent = Math.floor(eased * target);

                if (progress < 1) {
                    requestAnimationFrame(update);
                } else {
                    counter.textContent = target;
                }
            }
            requestAnimationFrame(update);
        });
    }

    // Observar cuando las cards entren al viewport
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounters();
                observer.disconnect();
            }
        });
    }, { threshold: 0.3 });

    const statsGrid = document.querySelector('.grid');
    if (statsGrid) observer.observe(statsGrid);
</script>

<style>
    /* Colores Personalizados */
    .bg-maroon-700 { background-color: #7c2a38; }
    .text-maroon-700 { color: #7c2a38; }
    .bg-maroon-100 { background-color: #f8e4ea; }
    .bg-maroon-50 { background-color: #fef2f5; }

    .btn-maroon-gradient {
        background: linear-gradient(135deg, #7c2a38, #a0374a);
        box-shadow: 0 2px 10px -2px rgba(124, 42, 56, 0.4);
    }
    .btn-maroon-gradient:hover {
        background: linear-gradient(135deg, #651f2e, #8c2e3f);
    }

    .table-header-gradient {
        background: linear-gradient(135deg, #651f2e 0%, #7c2a38 50%, #8c3548 100%);
    }

    /* Animaciones Modales */
    .modal-content {
        transform: scale(0.95) translateY(10px);
        opacity: 0;
        transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    /* Scrollbar Personalizado */
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e0d0d4; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #7c2a38; }

    /* === ANIMACIONES === */

    /* Stat Cards - Stagger Entrance */
    .stat-card {
        opacity: 0;
        transform: translateY(30px);
        animation: slideUpFade 0.6s ease forwards;
    }
    .stat-card-delay-1 { animation-delay: 0.1s; }
    .stat-card-delay-2 { animation-delay: 0.2s; }
    .stat-card-delay-3 { animation-delay: 0.3s; }
    .stat-card-delay-4 { animation-delay: 0.4s; }

    .stat-card:hover {
        transform: translateY(-6px);
    }

    @keyframes slideUpFade {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Rows stagger */
    .table-row-animate {
        opacity: 0;
        animation: fadeInRow 0.4s ease forwards;
    }

    @keyframes fadeInRow {
        from {
            opacity: 0;
            transform: translateX(-10px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Fade In */
    .animate-fade-in {
        animation: fadeIn 0.5s ease forwards;
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    /* Fade In Up */
    .animate-fade-in-up {
        opacity: 0;
        animation: fadeInUp 0.6s ease 0.3s forwards;
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Slide In Right */
    .animate-slide-in-right {
        animation: slideInRight 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(-30px); }
        to { opacity: 1; transform: translateX(0); }
    }

    /* Bounce In */
    .animate-bounce-in {
        animation: bounceIn 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    @keyframes bounceIn {
        0% { transform: scale(0); }
        50% { transform: scale(1.15); }
        100% { transform: scale(1); }
    }

    /* Fade In Down */
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-down {
        animation: fadeInDown 0.5s ease-out;
    }
</style>
@endsection
