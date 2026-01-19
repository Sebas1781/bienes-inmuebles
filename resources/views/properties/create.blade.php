@extends('layouts.app')

@section('content')
<style>
    /* Input base style */
    .input-modern {
        @apply w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-700 bg-white focus:ring-2 focus:ring-[#9b4d5c] focus:border-transparent transition duration-200 outline-none shadow-sm appearance-none;
    }
    .label-modern {
        @apply block text-sm font-bold text-gray-700 mb-1.5;
    }
    /* Animación suave para cambios de paso */
    .fade-in {
        animation: fadeIn 0.4s ease-in-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="min-h-screen bg-gray-50 flex flex-col relative font-sans">
    
    <header class="text-white py-3 px-4 md:px-8 flex items-center justify-between shadow-lg sticky top-0 z-40" style="background-color: #9b4d5c;">
        <div class="flex items-center gap-3">
            <button id="mobile-menu-btn" class="lg:hidden text-white hover:bg-white/20 p-2 rounded-lg transition focus:outline-none">
                <i class="fas fa-bars text-xl"></i>
            </button>

            <div class="flex items-center gap-3">
                <img src="{{ asset('images/Recurso 8.png') }}" alt="Logo" class="h-8 md:h-10 drop-shadow-md">
                <div class="flex flex-col leading-tight">
                    <span class="text-base md:text-2xl font-bold tracking-wide">Bienes Inmuebles</span>
                    <span class="text-[10px] md:text-xs text-white/80 font-light uppercase tracking-wider hidden sm:block">Gestión de Activos</span>
                </div>
            </div>
        </div>
        
        <div class="flex items-center gap-4">
            <h1 class="text-sm font-medium hidden lg:block opacity-90 border-l border-white/30 pl-4 ml-4">Nueva Ficha Técnica</h1>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="text-white/90 hover:text-white flex items-center gap-2 transition px-3 py-1.5 rounded-lg hover:bg-white/10 text-sm font-medium">
                    <i class="fas fa-sign-out-alt"></i> 
                    <span class="hidden md:inline">Salir</span>
                </button>
            </form>
        </div>
    </header>

    <div class="flex flex-1 relative overflow-hidden">
        
        <div id="sidebar-overlay" onclick="toggleSidebar()" 
             class="fixed inset-0 bg-gray-900/60 z-40 hidden lg:hidden transition-opacity backdrop-blur-sm">
        </div>

        <aside id="sidebar" 
               class="bg-white border-r w-72 py-6 px-4 gap-3 flex flex-col shadow-2xl lg:shadow-none
                      fixed inset-y-0 left-0 z-50 h-full transition-transform duration-300 ease-in-out transform -translate-x-full
                      lg:relative lg:translate-x-0 lg:inset-auto">
            
            <div class="flex justify-between items-center lg:hidden mb-6 border-b pb-4">
                <span class="font-bold text-gray-700 text-lg">Menú</span>
                <button onclick="toggleSidebar()" class="text-gray-400 hover:text-[#9b4d5c] p-2 transition">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <a href="{{ route('properties.create') }}" class="flex items-center gap-3 py-3.5 px-4 rounded-xl text-white font-semibold shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5 active:scale-95" style="background-color: #9b4d5c;">
                <i class="fas fa-plus-circle text-lg"></i> Agregar Inmueble
            </a>
            
            <nav class="space-y-1 mt-2">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 py-3 px-4 rounded-xl text-gray-600 hover:bg-red-50 hover:text-[#9b4d5c] font-medium transition-colors">
                    <i class="fas fa-warehouse w-6 text-center"></i> Admin. Inmuebles
                </a>
                
                @if(auth()->user()->isSuperAdmin())
                <a href="{{ route('users.index') }}" class="flex items-center gap-3 py-3 px-4 rounded-xl text-gray-600 hover:bg-red-50 hover:text-[#9b4d5c] font-medium transition-colors">
                    <i class="fas fa-users w-6 text-center"></i> Admin. Usuarios
                </a>
                @endif
            </nav>

            <div class="mt-auto p-4 bg-gray-50 rounded-xl border border-gray-100 text-center">
                <p class="text-xs text-gray-400">Versión 2.1.0</p>
            </div>
        </aside>

        <main class="flex-1 bg-[#f8f9fa] p-3 md:p-8 overflow-y-auto w-full scroll-smooth pb-24 md:pb-8">
            <div class="max-w-6xl mx-auto">
                
                <div class="mb-6 md:mb-10 bg-white p-4 md:p-6 rounded-2xl shadow-sm border border-gray-100 sticky top-0 z-30 md:static">
                    <div class="flex items-center justify-between px-2 relative">
                        <div class="absolute left-4 right-4 top-1/2 transform -translate-y-1/2 h-1 bg-gray-100 -z-0 rounded-full"></div>
                        
                        @foreach(['General', 'Equip.', 'Mant.', 'Fin'] as $index => $label)
                        @php $stepNum = $index + 1; @endphp
                        <div class="flex flex-col items-center step-indicator relative z-10" id="ind-{{ $stepNum }}">
                            <div class="w-8 h-8 md:w-12 md:h-12 rounded-full bg-white border-2 border-gray-300 text-gray-400 flex items-center justify-center font-bold text-xs md:text-lg ring-4 ring-white transition-all duration-300 shadow-sm">
                                {{ $stepNum }}
                            </div>
                            <span class="mt-2 text-[10px] md:text-sm font-bold text-gray-400 transition-colors duration-300">{{ $label }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <form id="propertyForm" action="{{ route('properties.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div id="step-1" class="form-step fade-in">
                        <div class="bg-white p-5 md:p-8 rounded-2xl shadow-sm border border-gray-200/60">
                            <div class="flex items-center gap-3 mb-6 border-b border-gray-100 pb-4">
                                <div class="bg-red-50 p-2 rounded-lg text-[#9b4d5c]"><i class="fas fa-info-circle text-lg md:text-xl"></i></div>
                                <h2 class="text-lg md:text-xl font-bold text-gray-800">Datos Generales</h2>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-6">
                                <div>
                                    <label class="label-modern">Denominación</label>
                                    <input type="text" name="denominacion" class="input-modern" placeholder="Ej: Casa de Cultura Norte">
                                </div>
                                <div>
                                    <label class="label-modern">Ubicación</label>
                                    <input type="text" name="ubicacion" class="input-modern" placeholder="Ej: Av. Principal #123">
                                </div>
                                <div>
                                    <label class="label-modern">Comunidad</label>
                                    <input type="text" name="comunidad" class="input-modern" placeholder="Ej: San Pedro">
                                </div>
                                <div>
                                    <label class="label-modern">Clave Catastral</label>
                                    <input type="text" name="clave_catastral" class="input-modern" placeholder="Ej: 123-ABC-456">
                                </div>
                                <div>
                                    <label class="label-modern">Coordenadas</label>
                                    <input type="text" name="coordenadas" class="input-modern" placeholder="Ej: 19.4326, -99.1332">
                                </div>
                                <div>
                                    <label class="label-modern">Superficie Total (m²)</label>
                                    <input type="number" name="superficie_total" class="input-modern" min="0" step="0.01" placeholder="0.00">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="label-modern">Uso y destino</label>
                                    <input type="text" name="uso_destino" class="input-modern" placeholder="Ej: Oficinas administrativas">
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-8 bg-gray-50 p-4 rounded-xl border border-gray-100">
                                <div>
                                    <label class="label-modern">¿Habitado?</label>
                                    <div class="relative">
                                        <select name="habitado" class="input-modern pr-8 cursor-pointer">
                                            <option value="0">No</option>
                                            <option value="1">Sí</option>
                                        </select>
                                        <i class="fas fa-chevron-down absolute right-4 top-4 text-gray-400 pointer-events-none text-xs"></i>
                                    </div>
                                </div>
                                <div>
                                    <label class="label-modern">¿Propio?</label>
                                    <div class="relative">
                                        <select name="propio" class="input-modern pr-8 cursor-pointer">
                                            <option value="0">No</option>
                                            <option value="1">Sí</option>
                                        </select>
                                        <i class="fas fa-chevron-down absolute right-4 top-4 text-gray-400 pointer-events-none text-xs"></i>
                                    </div>
                                </div>
                                <div>
                                    <label class="label-modern">¿Comodato?</label>
                                    <div class="relative">
                                        <select name="comodato" class="input-modern pr-8 cursor-pointer">
                                            <option value="0">No</option>
                                            <option value="1">Sí</option>
                                        </select>
                                        <i class="fas fa-chevron-down absolute right-4 top-4 text-gray-400 pointer-events-none text-xs"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-6">
                                <div>
                                    <label class="label-modern">Adscrito a</label>
                                    <input type="text" name="adscrito_a" class="input-modern">
                                </div>
                                <div>
                                    <label class="label-modern">A resguardo de</label>
                                    <input type="text" name="resguardo_servidor" class="input-modern">
                                </div>
                                <div>
                                    <label class="label-modern">Fecha Contrato</label>
                                    <input type="date" name="fecha_contrato" class="input-modern">
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-5 md:p-8 rounded-2xl shadow-sm border border-gray-200/60 mt-6">
                            <div class="flex items-center gap-3 mb-6 border-b border-gray-100 pb-4">
                                <div class="bg-blue-50 p-2 rounded-lg text-blue-600"><i class="fas fa-camera text-lg md:text-xl"></i></div>
                                <h2 class="text-lg md:text-xl font-bold text-gray-800">Multimedia</h2>
                            </div>

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                <div>
                                    <label class="label-modern mb-2">Fotografía Principal</label>
                                    <div class="relative h-48 md:h-56 w-full rounded-xl border-2 border-dashed border-gray-300 hover:border-[#9b4d5c] bg-gray-50 flex flex-col items-center justify-center transition group overflow-hidden">
                                        <img id="preview-image" src="#" alt="Previsualización" class="hidden w-full h-full object-cover absolute inset-0 z-10">
                                        
                                        <div id="upload-placeholder" class="text-center p-4">
                                            <div class="bg-white p-3 rounded-full shadow-sm inline-block mb-3">
                                                <i class="fas fa-cloud-upload-alt text-2xl text-[#9b4d5c]"></i>
                                            </div>
                                            <p class="text-sm font-medium text-gray-600">Toca para subir imagen</p>
                                        </div>
                                        <input type="file" name="imagen_principal" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20" onchange="previewImage(event)" accept="image/*">
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    <label class="label-modern">Servicios</label>
                                    @foreach(['luz' => ['Luz Eléctrica', 'fa-bolt'], 'predio' => ['Pago de Predio', 'fa-file-invoice'], 'agua' => ['Agua Potable', 'fa-tint']] as $key => $data)
                                    <div class="bg-gray-50 p-3 rounded-lg border border-gray-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center shadow-sm text-gray-600">
                                                <i class="fas {{ $data[1] }}"></i>
                                            </div>
                                            <span class="font-medium text-gray-700">{{ $data[0] }}</span>
                                            
                                            <select name="{{ $key }}" class="bg-white border border-gray-300 rounded text-sm py-1 px-2" onchange="toggleFileInput(this, '{{ $key }}')">
                                                <option value="0">No</option>
                                                <option value="1">Sí</option>
                                            </select>
                                        </div>
                                        <div id="file-{{ $key }}" class="hidden w-full sm:w-auto mt-2 sm:mt-0">
                                            <input type="file" name="file_{{ $key }}" class="block w-full text-xs text-gray-500 file:mr-2 file:py-1 file:px-2 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-[#9b4d5c] file:text-white">
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="step-2" class="form-step hidden fade-in">
                        <div class="bg-white p-5 md:p-8 rounded-2xl shadow-sm border border-gray-200/60">
                            <div class="flex items-center gap-3 mb-6 border-b border-gray-100 pb-4">
                                <div class="bg-yellow-50 p-2 rounded-lg text-yellow-600"><i class="fas fa-boxes text-lg md:text-xl"></i></div>
                                <h2 class="text-lg md:text-xl font-bold text-gray-800">Inventario</h2>
                            </div>

                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 md:gap-6">
                                @foreach([
                                    'oficinas_admin' => 'Oficinas', 
                                    'modulos_sanitarios' => 'Sanitarios', 
                                    'bodega' => 'Bodegas', 
                                    'num_ventana' => 'Ventanas', 
                                    'tienda' => 'Locales', 
                                    'porton' => 'Portones'
                                ] as $name => $label)
                                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 hover:border-[#9b4d5c]/30 transition">
                                    <label class="label-modern text-xs uppercase tracking-wide text-gray-500 text-center block mb-2">{{ $label }}</label>
                                    <input type="number" name="{{ $name }}" class="input-modern font-bold text-lg text-center p-2" min="0" step="1" placeholder="0">
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div id="step-3" class="form-step hidden fade-in">
                        <div class="bg-white p-5 md:p-8 rounded-2xl shadow-sm border border-gray-200/60">
                            <div class="flex items-center gap-3 mb-8 border-b border-gray-100 pb-4">
                                <div class="bg-green-50 p-2 rounded-lg text-green-600"><i class="fas fa-tools text-lg md:text-xl"></i></div>
                                <h2 class="text-lg md:text-xl font-bold text-gray-800">Mantenimiento</h2>
                            </div>

                            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                                
                                <div class="lg:col-span-8 space-y-6">
                                    
                                    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
                                        <div class="flex items-center gap-3 mb-4">
                                            <div class="w-8 h-8 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center"><i class="fas fa-paint-roller"></i></div>
                                            <h3 class="font-bold text-gray-800">Pintura</h3>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                                            <div class="md:col-span-3">
                                                <label class="text-xs font-bold text-gray-500 uppercase mb-1 block">¿Requiere?</label>
                                                <select name="pintura" class="input-modern py-2">
                                                    <option value="0">No</option>
                                                    <option value="1">Sí</option>
                                                </select>
                                            </div>
                                            <div class="md:col-span-4">
                                                <label class="text-xs font-bold text-gray-500 uppercase mb-1 block">Última Fecha</label>
                                                <input type="date" name="fecha_pintura" class="input-modern py-2">
                                            </div>
                                            <div class="md:col-span-5">
                                                <label class="text-xs font-bold text-gray-500 uppercase mb-1 block">Requerimiento</label>
                                                <input type="text" name="req_pintura" class="input-modern py-2" placeholder="Detalle...">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
                                        <div class="flex items-center gap-3 mb-4">
                                            <div class="w-8 h-8 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center"><i class="fas fa-trash-alt"></i></div>
                                            <h3 class="font-bold text-gray-800">Recolección Basura</h3>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                                            <div class="md:col-span-3">
                                                <label class="text-xs font-bold text-gray-500 uppercase mb-1 block">¿Requiere?</label>
                                                <select name="recoleccion_basura" class="input-modern py-2">
                                                    <option value="0">No</option>
                                                    <option value="1">Sí</option>
                                                </select>
                                            </div>
                                            <div class="md:col-span-4">
                                                <label class="text-xs font-bold text-gray-500 uppercase mb-1 block">Última Fecha</label>
                                                <input type="date" name="fecha_recoleccion_basura" class="input-modern py-2">
                                            </div>
                                            <div class="md:col-span-5">
                                                <label class="text-xs font-bold text-gray-500 uppercase mb-1 block">Requerimiento</label>
                                                <input type="text" name="req_recoleccion_basura" class="input-modern py-2" placeholder="Detalle...">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
                                        <div class="flex items-center gap-3 mb-4">
                                            <div class="w-8 h-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center"><i class="fas fa-leaf"></i></div>
                                            <h3 class="font-bold text-gray-800">Poda / Jardín</h3>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                                            <div class="md:col-span-3">
                                                <label class="text-xs font-bold text-gray-500 uppercase mb-1 block">¿Requiere?</label>
                                                <select name="poda" class="input-modern py-2">
                                                    <option value="0">No</option>
                                                    <option value="1">Sí</option>
                                                </select>
                                            </div>
                                            <div class="md:col-span-4">
                                                <label class="text-xs font-bold text-gray-500 uppercase mb-1 block">Última Fecha</label>
                                                <input type="date" name="fecha_poda" class="input-modern py-2">
                                            </div>
                                            <div class="md:col-span-5">
                                                <label class="text-xs font-bold text-gray-500 uppercase mb-1 block">Requerimiento</label>
                                                <input type="text" name="req_poda" class="input-modern py-2" placeholder="Detalle...">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
                                        <div class="flex items-center gap-3 mb-4">
                                            <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center"><i class="fas fa-water"></i></div>
                                            <h3 class="font-bold text-gray-800">Impermeabilización</h3>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                                            <div class="md:col-span-3">
                                                <label class="text-xs font-bold text-gray-500 uppercase mb-1 block">¿Requiere?</label>
                                                <select name="impermeabilizacion" class="input-modern py-2">
                                                    <option value="0">No</option>
                                                    <option value="1">Sí</option>
                                                </select>
                                            </div>
                                            <div class="md:col-span-4">
                                                <label class="text-xs font-bold text-gray-500 uppercase mb-1 block">Última Fecha</label>
                                                <input type="date" name="fecha_impermeabilizacion" class="input-modern py-2">
                                            </div>
                                            <div class="md:col-span-5">
                                                <label class="text-xs font-bold text-gray-500 uppercase mb-1 block">Requerimiento</label>
                                                <input type="text" name="req_impermeabilizacion" class="input-modern py-2" placeholder="Detalle...">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="lg:col-span-4 mt-6 lg:mt-0">
                                    <div class="bg-gray-50 p-5 rounded-2xl border border-gray-200">
                                        <h3 class="text-sm font-bold text-gray-800 mb-4 uppercase tracking-wide">Estructuras</h3>
                                        <div class="space-y-3">
                                            @foreach(['retiro_estructuras' => 'Retiro Estructuras', 'malla' => 'Malla Ciclónica', 'sombra' => 'Malla Sombra', 'barda' => 'Barda Perimetral'] as $key => $label)
                                            <div class="flex justify-between items-center bg-white p-3 rounded-lg shadow-sm border border-gray-100">
                                                <label class="text-sm font-medium text-gray-600">{{ $label }}</label>
                                                <select name="{{ $key }}" class="bg-transparent font-bold text-gray-800 focus:outline-none cursor-pointer">
                                                    <option value="0">No</option>
                                                    <option value="1">Sí</option>
                                                </select>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="step-4" class="form-step hidden fade-in">
                        <div class="bg-white p-5 md:p-8 rounded-2xl shadow-sm border border-gray-200/60">
                            <div class="flex items-center gap-3 mb-6 border-b border-gray-100 pb-4">
                                <div class="bg-gray-100 p-2 rounded-lg text-gray-600"><i class="fas fa-clipboard-list text-lg md:text-xl"></i></div>
                                <h2 class="text-lg md:text-xl font-bold text-gray-800">Comentarios Finales</h2>
                            </div>
                            
                            <div class="w-full">
                                <label class="label-modern mb-3">Observaciones Generales</label>
                                <textarea name="actividades" rows="8" placeholder="Escriba aquí cualquier detalle adicional relevante..." class="input-modern resize-none h-52 rounded-xl w-full"></textarea>
                            </div>
                            </div>
                    </div>

                    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-4 md:static md:bg-transparent md:border-none md:p-0 z-50 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)] md:shadow-none">
                        <div class="flex flex-col-reverse md:flex-row justify-between items-center gap-3 max-w-6xl mx-auto">
                            <button type="button" id="prevBtn" class="w-full md:w-auto px-6 py-3 bg-white border border-gray-300 text-gray-600 font-bold rounded-xl hover:bg-gray-50 transition hidden">
                                <i class="fas fa-arrow-left mr-2"></i> Atrás
                            </button>
                            
                            <div class="flex gap-3 w-full md:w-auto">
                                <a href="{{ route('dashboard') }}" class="flex-1 md:flex-none py-3 px-4 text-gray-500 font-bold text-center hover:text-red-500 transition text-sm flex items-center justify-center">
                                    Cancelar
                                </a>
                                
                                <button type="button" id="nextBtn" class="flex-1 md:flex-none px-8 py-3 bg-[#9b4d5c] text-white font-bold rounded-xl hover:bg-[#7a3b47] transition shadow-lg active:scale-95 flex items-center justify-center gap-2">
                                    Siguiente <i class="fas fa-chevron-right text-xs"></i>
                                </button>
                                
                                <button type="submit" id="submitBtn" class="flex-1 md:flex-none px-8 py-3 bg-green-600 text-white font-bold rounded-xl hover:bg-green-700 transition shadow-lg active:scale-95 hidden flex items-center justify-center gap-2">
                                    <i class="fas fa-check"></i> Guardar
                                </button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </main>
    </div>
</div>

<script>
    // 1. Lógica de Archivos (PDF ELIMINADO) - Solo Imágenes de servicios
    function previewImage(event) {
        const file = event.target.files[0];
        const previewImage = document.getElementById('preview-image');
        const placeholder = document.getElementById('upload-placeholder');
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewImage.classList.remove('hidden');
                placeholder.classList.add('opacity-0');
            };
            reader.readAsDataURL(file);
        }
    }

    function toggleFileInput(selectElement, key) {
        const fileInput = document.getElementById(`file-${key}`);
        selectElement.value === "1" ? fileInput.classList.remove('hidden') : fileInput.classList.add('hidden');
    }

    // 2. Sidebar Móvil
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    function toggleSidebar() {
        const isClosed = sidebar.classList.contains('-translate-x-full');
        if (isClosed) {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        } else {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }
    }
    document.getElementById('mobile-menu-btn').addEventListener('click', toggleSidebar);

    // 3. WIZARD
    document.addEventListener('DOMContentLoaded', () => {
        let currentStep = 1; 
        const totalSteps = 4;
        const nextBtn = document.getElementById('nextBtn');
        const prevBtn = document.getElementById('prevBtn');
        const submitBtn = document.getElementById('submitBtn');

        function updateUI() {
            // Ocultar todos los pasos
            document.querySelectorAll('.form-step').forEach(el => el.classList.add('hidden'));
            // Mostrar paso actual
            document.getElementById(`step-${currentStep}`).classList.remove('hidden');

            // Botones
            prevBtn.classList.toggle('hidden', currentStep === 1);
            
            if (currentStep === totalSteps) {
                nextBtn.classList.add('hidden');
                submitBtn.classList.remove('hidden');
            } else {
                nextBtn.classList.remove('hidden');
                submitBtn.classList.add('hidden');
            }

            // Indicadores
            for (let i = 1; i <= totalSteps; i++) {
                const ind = document.getElementById(`ind-${i}`);
                const circle = ind.querySelector('div');
                const text = ind.querySelector('span');
                
                circle.className = "w-8 h-8 md:w-12 md:h-12 rounded-full flex items-center justify-center font-bold text-xs md:text-lg ring-4 ring-white transition-all duration-300 shadow-sm";
                text.className = "mt-2 text-[10px] md:text-sm font-bold transition-colors duration-300";

                if (i < currentStep) { 
                    circle.classList.add('bg-green-500', 'text-white');
                    circle.innerHTML = '<i class="fas fa-check"></i>';
                    text.classList.add('text-green-600');
                } else if (i === currentStep) {
                    circle.classList.add('bg-[#9b4d5c]', 'text-white', 'scale-110');
                    circle.innerHTML = i;
                    text.classList.add('text-[#9b4d5c]');
                } else {
                    circle.classList.add('bg-white', 'border-2', 'border-gray-300', 'text-gray-400');
                    circle.innerHTML = i;
                    text.classList.add('text-gray-400');
                }
            }
            
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        nextBtn.addEventListener('click', () => {
            if (currentStep < totalSteps) {
                currentStep++;
                updateUI();
            }
        });

        prevBtn.addEventListener('click', () => {
            if (currentStep > 1) {
                currentStep--;
                updateUI();
            }
        });

        updateUI();
    });
</script>
@endsection