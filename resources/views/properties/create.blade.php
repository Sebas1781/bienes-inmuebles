@extends('layouts.app')

@section('content')
<style>
    /* Input base style */
    .input-modern {
        width: 100%;
        border: 2px solid #d1d5db;
        border-radius: 0.75rem;
        padding: 0.75rem 1rem;
        color: #1f2937;
        background-color: #ffffff;
        font-size: 0.95rem;
        font-weight: 500;
        transition: all 0.3s ease;
        outline: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }
    .input-modern:hover {
        border-color: #9b4d5c;
    }
    .input-modern:focus {
        background-color: #ffffff;
        border-color: #9b4d5c;
        box-shadow: 0 0 0 4px rgba(155, 77, 92, 0.1);
    }
    .input-modern::placeholder {
        color: #9ca3af;
        font-weight: 400;
    }
    .label-modern {
        display: block;
        font-size: 0.875rem;
        font-weight: 700;
        color: #374151;
        margin-bottom: 0.5rem;
        letter-spacing: 0.01em;
    }
    /* Animación suave para cambios de paso */
    .fade-in {
        animation: fadeIn 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(16px); }
        to { opacity: 1; transform: translateY(0); }
    }
    /* Card sections */
    .form-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05), 0 4px 16px rgba(0, 0, 0, 0.04);
        transition: box-shadow 0.3s ease;
    }
    .form-card:hover {
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08), 0 8px 24px rgba(0, 0, 0, 0.06);
    }
    .section-title-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }
    /* Progress line animation */
    .progress-line {
        transition: width 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    /* Select styling - Fix double arrow issue */
    select.input-modern {
        cursor: pointer;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-color: #ffffff;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 20 20'%3E%3Cpath fill='%239b4d5c' d='M10 12L5 7h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 16px;
        padding-right: 44px;
    }
    select.input-modern::-ms-expand {
        display: none;
    }
    /* Textarea */
    textarea.input-modern {
        resize: none;
        font-family: inherit;
    }
</style>

<div class="min-h-screen bg-gradient-to-br from-gray-50 via-rose-50/20 to-gray-100 flex flex-col relative font-sans">

    <x-header title="Nueva Ficha Técnica" />

    <div class="flex flex-1 relative overflow-hidden">

        <x-sidebar active="create" />

        <main class="flex-1 p-3 md:p-8 overflow-y-auto w-full scroll-smooth pb-24 md:pb-8">
            <div class="max-w-6xl mx-auto">

                <div class="mb-6 md:mb-10 form-card p-4 md:p-6 rounded-2xl sticky top-0 z-10 md:static">
                    <div class="flex items-center justify-between px-4 md:px-8 relative">
                        {{-- Background line --}}
                        <div class="absolute left-8 right-8 md:left-12 md:right-12 top-1/2 transform -translate-y-1/2 h-1 bg-gray-100 rounded-full"></div>
                        {{-- Progress fill line --}}
                        <div id="progress-fill" class="absolute left-8 md:left-12 top-1/2 transform -translate-y-1/2 h-1 bg-gradient-to-r from-[#7c2a38] to-[#c4596d] rounded-full progress-line" style="width: 0%"></div>

                        @foreach(['General', 'Equip.', 'Mant.', 'Fin'] as $index => $label)
                        @php $stepNum = $index + 1; @endphp
                        <div class="flex flex-col items-center step-indicator relative z-10" id="ind-{{ $stepNum }}">
                            <div class="w-9 h-9 md:w-12 md:h-12 rounded-full bg-white border-2 border-gray-200 text-gray-400 flex items-center justify-center font-bold text-xs md:text-lg ring-4 ring-white transition-all duration-500 shadow-sm">
                                {{ $stepNum }}
                            </div>
                            <span class="mt-2 text-[10px] md:text-xs font-bold text-gray-400 transition-colors duration-300 uppercase tracking-wider">{{ $label }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <form id="propertyForm" action="{{ route('properties.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div id="step-1" class="form-step fade-in space-y-6">
                        <div class="form-card p-5 md:p-8 rounded-2xl">
                            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100/80">
                                <div class="section-title-icon bg-gradient-to-br from-rose-50 to-red-100 text-[#9b4d5c]"><i class="fas fa-info-circle"></i></div>
                                <div>
                                    <h2 class="text-lg md:text-xl font-bold text-gray-800">Datos Generales</h2>
                                    <p class="text-xs text-gray-400 mt-0.5">Información principal del inmueble</p>
                                </div>
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

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-8 bg-gradient-to-br from-gray-50 to-rose-50/30 p-5 rounded-2xl border border-gray-100">
                                @foreach(['habitado' => ['¿Habitado?', 'fa-house-user', 'rose'], 'propio' => ['¿Propio?', 'fa-key', 'blue'], 'comodato' => ['¿Comodato?', 'fa-handshake', 'amber']] as $key => $data)
                                <div class="bg-white/80 p-4 rounded-xl border border-gray-100 hover:border-gray-200 transition-all duration-300 hover:shadow-sm">
                                    <div class="flex items-center gap-2 mb-2">
                                        <i class="fas {{ $data[1] }} text-[#9b4d5c] text-xs"></i>
                                        <label class="text-sm font-semibold text-gray-600">{{ $data[0] }}</label>
                                    </div>
                                    <select name="{{ $key }}" class="input-modern py-2.5">
                                        <option value="0">No</option>
                                        <option value="1">Sí</option>
                                    </select>
                                </div>
                                @endforeach
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-6">
                                <div>
                                    <label class="label-modern"><i class="fas fa-building text-[#9b4d5c]/50 mr-1 text-xs"></i> Adscrito a</label>
                                    <input type="text" name="adscrito_a" class="input-modern">
                                </div>
                                <div>
                                    <label class="label-modern"><i class="fas fa-user-shield text-[#9b4d5c]/50 mr-1 text-xs"></i> A resguardo de</label>
                                    <input type="text" name="resguardo_servidor" class="input-modern">
                                </div>
                                <div>
                                    <label class="label-modern"><i class="fas fa-calendar-alt text-[#9b4d5c]/50 mr-1 text-xs"></i> Fecha Contrato</label>
                                    <input type="date" name="fecha_contrato" class="input-modern">
                                </div>
                            </div>
                        </div>

                        <div class="form-card p-5 md:p-8 rounded-2xl">
                            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100/80">
                                <div class="section-title-icon bg-gradient-to-br from-blue-50 to-indigo-100 text-blue-600"><i class="fas fa-camera"></i></div>
                                <div>
                                    <h2 class="text-lg md:text-xl font-bold text-gray-800">Multimedia</h2>
                                    <p class="text-xs text-gray-400 mt-0.5">Fotografías y servicios del inmueble</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                <div>
                                    <label class="label-modern mb-2"><i class="fas fa-image text-blue-400 mr-1 text-xs"></i> Fotografía Principal</label>
                                    <div class="relative h-48 md:h-56 w-full rounded-2xl border-2 border-dashed border-gray-200 hover:border-[#9b4d5c] bg-gradient-to-br from-gray-50 to-rose-50/30 flex flex-col items-center justify-center transition-all duration-300 group overflow-hidden hover:shadow-md">
                                        <img id="preview-image" src="#" alt="Previsualización" class="hidden w-full h-full object-cover absolute inset-0 z-10">

                                        <div id="upload-placeholder" class="text-center p-4 transition-all duration-300">
                                            <div class="bg-white p-4 rounded-2xl shadow-sm inline-block mb-3 group-hover:shadow-md group-hover:scale-105 transition-all duration-300">
                                                <i class="fas fa-cloud-upload-alt text-2xl text-[#9b4d5c]"></i>
                                            </div>
                                            <p class="text-sm font-medium text-gray-500">Toca para subir imagen</p>
                                            <p class="text-xs text-gray-400 mt-1">JPG, PNG hasta 5MB</p>
                                        </div>
                                        <input type="file" name="imagen_principal" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20" onchange="previewImage(event)" accept="image/*">
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <label class="label-modern"><i class="fas fa-concierge-bell text-blue-400 mr-1 text-xs"></i> Servicios</label>
                                    @php $serviceColors = ['luz' => ['Luz Eléctrica', 'fa-bolt', 'from-yellow-50 to-amber-50', 'text-yellow-600'], 'predio' => ['Pago de Predio', 'fa-file-invoice', 'from-emerald-50 to-green-50', 'text-emerald-600'], 'agua' => ['Agua Potable', 'fa-tint', 'from-blue-50 to-cyan-50', 'text-blue-600']]; @endphp
                                    @foreach($serviceColors as $key => $data)
                                    <div class="bg-gradient-to-r {{ $data[2] }} p-4 rounded-xl border border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:shadow-sm transition-all duration-300">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl bg-white flex items-center justify-center shadow-sm {{ $data[3] }}">
                                                <i class="fas {{ $data[1] }}"></i>
                                            </div>
                                            <span class="font-semibold text-gray-700 text-sm">{{ $data[0] }}</span>

                                            <select name="{{ $key }}" class="bg-white border border-gray-200 rounded-lg text-sm py-1.5 px-3 focus:ring-2 focus:ring-[#9b4d5c]/20 focus:border-[#9b4d5c] transition-all" onchange="toggleFileInput(this, '{{ $key }}')">
                                                <option value="0">No</option>
                                                <option value="1">Sí</option>
                                            </select>
                                        </div>
                                        <div id="file-{{ $key }}" class="hidden w-full sm:w-auto mt-2 sm:mt-0">
                                            <input type="file" name="file_{{ $key }}" class="block w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#9b4d5c] file:text-white file:cursor-pointer file:transition file:hover:bg-[#7a3b47]">
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="step-2" class="form-step hidden fade-in">
                        <div class="form-card p-5 md:p-8 rounded-2xl">
                            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100/80">
                                <div class="section-title-icon bg-gradient-to-br from-yellow-50 to-amber-100 text-amber-600"><i class="fas fa-boxes"></i></div>
                                <div>
                                    <h2 class="text-lg md:text-xl font-bold text-gray-800">Inventario</h2>
                                    <p class="text-xs text-gray-400 mt-0.5">Cantidad de espacios y equipamiento</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 md:gap-5">
                                @php $equipIcons = ['oficinas_admin' => ['Oficinas', 'fa-door-open', 'from-blue-50 to-indigo-50'], 'modulos_sanitarios' => ['Sanitarios', 'fa-restroom', 'from-cyan-50 to-teal-50'], 'bodega' => ['Bodegas', 'fa-warehouse', 'from-amber-50 to-yellow-50'], 'num_ventana' => ['Ventanas', 'fa-window-maximize', 'from-sky-50 to-blue-50'], 'tienda' => ['Locales', 'fa-store', 'from-emerald-50 to-green-50'], 'porton' => ['Portones', 'fa-dungeon', 'from-purple-50 to-violet-50']]; @endphp
                                @foreach($equipIcons as $name => $data)
                                <div class="bg-gradient-to-br {{ $data[2] }} p-5 rounded-2xl border border-gray-100 hover:border-[#9b4d5c]/20 transition-all duration-300 hover:shadow-md group">
                                    <div class="flex items-center gap-2 mb-3">
                                        <i class="fas {{ $data[1] }} text-gray-400 group-hover:text-[#9b4d5c] transition-colors duration-300 text-sm"></i>
                                        <label class="text-xs font-bold uppercase tracking-wider text-gray-500">{{ $data[0] }}</label>
                                    </div>
                                    <input type="number" name="{{ $name }}" class="input-modern font-bold text-xl text-center py-3 bg-white/80" min="0" step="1" placeholder="0">
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div id="step-3" class="form-step hidden fade-in">
                        <div class="form-card p-5 md:p-8 rounded-2xl">
                            <div class="flex items-center gap-3 mb-8 pb-4 border-b border-gray-100/80">
                                <div class="section-title-icon bg-gradient-to-br from-green-50 to-emerald-100 text-green-600"><i class="fas fa-tools"></i></div>
                                <div>
                                    <h2 class="text-lg md:text-xl font-bold text-gray-800">Mantenimiento</h2>
                                    <p class="text-xs text-gray-400 mt-0.5">Estado y requerimientos de mantenimiento</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                                <div class="lg:col-span-8 space-y-6">

                                    <div class="bg-gradient-to-br from-white to-purple-50/30 p-5 rounded-2xl border border-gray-100 hover:shadow-md transition-all duration-300">
                                        <div class="flex items-center gap-3 mb-4">
                                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-purple-100 to-purple-50 text-purple-600 flex items-center justify-center shadow-sm"><i class="fas fa-paint-roller"></i></div>
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

                                    <div class="bg-gradient-to-br from-white to-orange-50/30 p-5 rounded-2xl border border-gray-100 hover:shadow-md transition-all duration-300">
                                        <div class="flex items-center gap-3 mb-4">
                                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-orange-100 to-orange-50 text-orange-600 flex items-center justify-center shadow-sm"><i class="fas fa-trash-alt"></i></div>
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

                                    <div class="bg-gradient-to-br from-white to-green-50/30 p-5 rounded-2xl border border-gray-100 hover:shadow-md transition-all duration-300">
                                        <div class="flex items-center gap-3 mb-4">
                                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-green-100 to-green-50 text-green-600 flex items-center justify-center shadow-sm"><i class="fas fa-leaf"></i></div>
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

                                    <div class="bg-gradient-to-br from-white to-blue-50/30 p-5 rounded-2xl border border-gray-100 hover:shadow-md transition-all duration-300">
                                        <div class="flex items-center gap-3 mb-4">
                                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-blue-100 to-blue-50 text-blue-600 flex items-center justify-center shadow-sm"><i class="fas fa-water"></i></div>
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
                                    <div class="bg-gradient-to-br from-gray-50 to-slate-50 p-5 rounded-2xl border border-gray-100 sticky top-4">
                                        <div class="flex items-center gap-2 mb-4">
                                            <i class="fas fa-cubes text-gray-400 text-sm"></i>
                                            <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wide">Estructuras</h3>
                                        </div>
                                        <div class="space-y-2.5">
                                            @php $structIcons = ['retiro_estructuras' => ['Retiro Estructuras', 'fa-dolly'], 'malla' => ['Malla Ciclónica', 'fa-border-all'], 'sombra' => ['Malla Sombra', 'fa-cloud-sun'], 'barda' => ['Barda Perimetral', 'fa-archway']]; @endphp
                                            @foreach($structIcons as $key => $data)
                                            <div class="flex justify-between items-center bg-white/80 p-3.5 rounded-xl border border-gray-100 hover:border-gray-200 hover:shadow-sm transition-all duration-300">
                                                <div class="flex items-center gap-2.5">
                                                    <i class="fas {{ $data[1] }} text-gray-400 text-xs"></i>
                                                    <label class="text-sm font-medium text-gray-600">{{ $data[0] }}</label>
                                                </div>
                                                <select name="{{ $key }}" class="bg-transparent font-bold text-gray-800 focus:outline-none cursor-pointer text-sm">
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
                        <div class="form-card p-5 md:p-8 rounded-2xl">
                            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100/80">
                                <div class="section-title-icon bg-gradient-to-br from-gray-50 to-slate-100 text-gray-600"><i class="fas fa-clipboard-list"></i></div>
                                <div>
                                    <h2 class="text-lg md:text-xl font-bold text-gray-800">Comentarios Finales</h2>
                                    <p class="text-xs text-gray-400 mt-0.5">Observaciones adicionales sobre el inmueble</p>
                                </div>
                            </div>

                            <div class="w-full">
                                <label class="label-modern mb-3"><i class="fas fa-pen text-gray-400 mr-1 text-xs"></i> Observaciones Generales</label>
                                <textarea name="actividades" rows="8" placeholder="Escriba aquí cualquier detalle adicional relevante sobre el inmueble..." class="input-modern resize-none h-52 rounded-xl w-full"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="fixed bottom-0 left-0 right-0 bg-white/90 backdrop-blur-lg border-t border-gray-100 p-4 md:static md:bg-transparent md:backdrop-blur-none md:border-none md:p-0 z-40 shadow-[0_-4px_20px_-4px_rgba(0,0,0,0.08)] md:shadow-none">
                        <div class="flex flex-col-reverse md:flex-row justify-between items-center gap-3 max-w-6xl mx-auto">
                            <button type="button" id="prevBtn" class="w-full md:w-auto px-6 py-3 bg-white border border-gray-200 text-gray-600 font-bold rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-all duration-300 hidden hover:shadow-sm">
                                <i class="fas fa-arrow-left mr-2"></i> Atrás
                            </button>

                            <div class="flex gap-3 w-full md:w-auto">
                                <a href="{{ route('dashboard') }}" class="flex-1 md:flex-none py-3 px-4 text-gray-400 font-semibold text-center hover:text-red-500 transition-all duration-300 text-sm flex items-center justify-center">
                                    Cancelar
                                </a>

                                <button type="button" id="nextBtn" class="flex-1 md:flex-none px-8 py-3 bg-gradient-to-r from-[#7c2a38] to-[#9b4d5c] text-white font-bold rounded-xl hover:from-[#651f2e] hover:to-[#7a3b47] transition-all duration-300 shadow-lg shadow-[#9b4d5c]/25 active:scale-95 flex items-center justify-center gap-2 hover:-translate-y-0.5">
                                    Siguiente <i class="fas fa-chevron-right text-xs"></i>
                                </button>

                                <button type="submit" id="submitBtn" class="flex-1 md:flex-none px-8 py-3 bg-gradient-to-r from-green-600 to-emerald-500 text-white font-bold rounded-xl hover:from-green-700 hover:to-emerald-600 transition-all duration-300 shadow-lg shadow-green-500/25 active:scale-95 hidden flex items-center justify-center gap-2 hover:-translate-y-0.5">
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

    // 2. WIZARD
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

            // Progress fill line
            const progressFill = document.getElementById('progress-fill');
            const progressPercent = ((currentStep - 1) / (totalSteps - 1)) * 100;
            if (progressFill) {
                progressFill.style.width = `calc(${progressPercent}% - 2rem)`;
            }

            // Indicadores
            for (let i = 1; i <= totalSteps; i++) {
                const ind = document.getElementById(`ind-${i}`);
                const circle = ind.querySelector('div');
                const text = ind.querySelector('span');

                circle.className = "w-9 h-9 md:w-12 md:h-12 rounded-full flex items-center justify-center font-bold text-xs md:text-lg ring-4 ring-white transition-all duration-500 shadow-sm";
                text.className = "mt-2 text-[10px] md:text-xs font-bold transition-colors duration-300 uppercase tracking-wider";

                if (i < currentStep) {
                    circle.classList.add('bg-gradient-to-br', 'from-green-400', 'to-emerald-500', 'text-white', 'shadow-green-200');
                    circle.innerHTML = '<i class="fas fa-check text-xs"></i>';
                    text.classList.add('text-green-600');
                } else if (i === currentStep) {
                    circle.classList.add('bg-gradient-to-br', 'from-[#7c2a38]', 'to-[#b0616f]', 'text-white', 'scale-110', 'shadow-md', 'shadow-[#9b4d5c]/30');
                    circle.innerHTML = i;
                    text.classList.add('text-[#9b4d5c]', 'font-extrabold');
                } else {
                    circle.classList.add('bg-white', 'border-2', 'border-gray-200', 'text-gray-400');
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
