@extends('layouts.app')

@section('content')
<style>
    .input-modern {
        @apply w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-700 bg-white focus:ring-2 focus:ring-[#9b4d5c] focus:border-transparent transition duration-200 outline-none shadow-sm appearance-none;
    }
    .label-modern {
        @apply block text-sm font-bold text-gray-700 mb-1.5;
    }
    .fade-in { animation: fadeIn 0.4s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>

<div class="min-h-screen bg-gray-50 flex flex-col relative font-sans">
    
    <x-header title="Editar Inmueble" />

    <div class="flex flex-1 relative overflow-hidden">
        
        <x-sidebar active="dashboard" />
        <main class="flex-1 bg-[#f8f9fa] p-3 md:p-8 overflow-y-auto w-full scroll-smooth pb-24 md:pb-8">
            <div class="max-w-6xl mx-auto">
                
                <div class="mb-6 md:mb-10 bg-white p-4 md:p-6 rounded-2xl shadow-sm border border-gray-100 sticky top-0 z-10 md:static">
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

                <form id="propertyForm" action="{{ route('properties.update', $property->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT') <div id="step-1" class="form-step fade-in">
                        <div class="bg-white p-5 md:p-8 rounded-2xl shadow-sm border border-gray-200/60">
                            <h2 class="text-lg md:text-xl font-bold text-gray-800 mb-6 border-b pb-2">Datos Generales</h2>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-6">
                                <div>
                                    <label class="label-modern">Denominación</label>
                                    <input type="text" name="denominacion" class="input-modern" value="{{ old('denominacion', $property->denominacion) }}" required>
                                </div>
                                <div>
                                    <label class="label-modern">Ubicación</label>
                                    <input type="text" name="ubicacion" class="input-modern" value="{{ old('ubicacion', $property->ubicacion) }}" required>
                                </div>
                                <div>
                                    <label class="label-modern">Comunidad</label>
                                    <input type="text" name="comunidad" class="input-modern" value="{{ old('comunidad', $property->comunidad) }}">
                                </div>
                                <div>
                                    <label class="label-modern">Clave Catastral</label>
                                    <input type="text" name="clave_catastral" class="input-modern" value="{{ old('clave_catastral', $property->clave_catastral) }}">
                                </div>
                                <div>
                                    <label class="label-modern">Coordenadas</label>
                                    <input type="text" name="coordenadas" class="input-modern" value="{{ old('coordenadas', $property->coordenadas) }}">
                                </div>
                                <div>
                                    <label class="label-modern">Superficie Total (m²)</label>
                                    <input type="number" name="superficie_total" class="input-modern" min="0" step="0.01" value="{{ old('superficie_total', $property->superficie_total) }}">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="label-modern">Uso y destino</label>
                                    <input type="text" name="uso_destino" class="input-modern" value="{{ old('uso_destino', $property->uso_destino) }}">
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-8 bg-gray-50 p-4 rounded-xl border border-gray-100">
                                <div>
                                    <label class="label-modern">¿Habitado?</label>
                                    <div class="relative">
                                        <select name="habitado" class="input-modern pr-8 cursor-pointer">
                                            <option value="0" {{ $property->habitado == 0 ? 'selected' : '' }}>No</option>
                                            <option value="1" {{ $property->habitado == 1 ? 'selected' : '' }}>Sí</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <label class="label-modern">¿Propio?</label>
                                    <div class="relative">
                                        <select name="propio" class="input-modern pr-8 cursor-pointer">
                                            <option value="0" {{ $property->propio == 0 ? 'selected' : '' }}>No</option>
                                            <option value="1" {{ $property->propio == 1 ? 'selected' : '' }}>Sí</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <label class="label-modern">¿Comodato?</label>
                                    <div class="relative">
                                        <select name="comodato" class="input-modern pr-8 cursor-pointer">
                                            <option value="0" {{ $property->comodato == 0 ? 'selected' : '' }}>No</option>
                                            <option value="1" {{ $property->comodato == 1 ? 'selected' : '' }}>Sí</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-6">
                                <div>
                                    <label class="label-modern">Adscrito a</label>
                                    <input type="text" name="adscrito_a" class="input-modern" value="{{ old('adscrito_a', $property->adscrito_a) }}">
                                </div>
                                <div>
                                    <label class="label-modern">A resguardo de</label>
                                    <input type="text" name="resguardo_servidor" class="input-modern" value="{{ old('resguardo_servidor', $property->resguardo_servidor) }}">
                                </div>
                                <div>
                                    <label class="label-modern">Fecha Contrato</label>
                                    <input type="date" name="fecha_contrato" class="input-modern" value="{{ old('fecha_contrato', $property->fecha_contrato) }}">
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-5 md:p-8 rounded-2xl shadow-sm border border-gray-200/60 mt-6">
                            <h2 class="text-lg md:text-xl font-bold text-gray-800 mb-6 border-b pb-2">Multimedia</h2>

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                <div>
                                    <label class="label-modern mb-2">Fotografía Principal</label>
                                    <div class="relative h-48 md:h-56 w-full rounded-xl border-2 border-dashed border-gray-300 hover:border-[#9b4d5c] bg-gray-50 flex flex-col items-center justify-center transition group overflow-hidden">
                                        <img id="preview-image" src="{{ $property->imagen_principal ? asset('storage/'.$property->imagen_principal) : '#' }}" 
                                             class="{{ $property->imagen_principal ? '' : 'hidden' }} w-full h-full object-cover absolute inset-0 z-10">
                                        
                                        <div id="upload-placeholder" class="text-center p-4 {{ $property->imagen_principal ? 'opacity-0' : '' }}">
                                            <div class="bg-white p-3 rounded-full shadow-sm inline-block mb-3">
                                                <i class="fas fa-cloud-upload-alt text-2xl text-[#9b4d5c]"></i>
                                            </div>
                                            <p class="text-sm font-medium text-gray-600">Click para cambiar imagen</p>
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
                                                <option value="0" {{ $property->$key == 0 ? 'selected' : '' }}>No</option>
                                                <option value="1" {{ $property->$key == 1 ? 'selected' : '' }}>Sí</option>
                                            </select>
                                        </div>
                                        <div id="file-{{ $key }}" class="{{ $property->$key == 1 ? '' : 'hidden' }} w-full sm:w-auto mt-2 sm:mt-0">
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
                            <h2 class="text-lg md:text-xl font-bold text-gray-800 mb-6 border-b pb-2">Inventario</h2>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 md:gap-6">
                                @foreach([
                                    'oficinas_admin' => 'Oficinas', 'modulos_sanitarios' => 'Sanitarios', 
                                    'bodega' => 'Bodegas', 'num_ventana' => 'Ventanas', 
                                    'tienda' => 'Locales', 'porton' => 'Portones'
                                ] as $name => $label)
                                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                    <label class="label-modern text-xs uppercase tracking-wide text-gray-500 text-center block mb-2">{{ $label }}</label>
                                    <input type="number" name="{{ $name }}" class="input-modern font-bold text-lg text-center p-2" min="0" step="1" value="{{ old($name, $property->$name) }}">
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div id="step-3" class="form-step hidden fade-in">
                        <div class="bg-white p-5 md:p-8 rounded-2xl shadow-sm border border-gray-200/60">
                            <h2 class="text-lg md:text-xl font-bold text-gray-800 mb-6 border-b pb-2">Mantenimiento</h2>

                            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                                <div class="lg:col-span-8 space-y-6">
                                    
                                    @php
                                        $mantenimientos = [
                                            ['key' => 'pintura', 'label' => 'Pintura', 'icon' => 'fa-paint-roller', 'color' => 'purple'],
                                            ['key' => 'recoleccion_basura', 'label' => 'Recolección Basura', 'icon' => 'fa-trash-alt', 'color' => 'orange'],
                                            ['key' => 'poda', 'label' => 'Poda / Jardín', 'icon' => 'fa-leaf', 'color' => 'green'],
                                            ['key' => 'impermeabilizacion', 'label' => 'Impermeabilización', 'icon' => 'fa-water', 'color' => 'blue'],
                                        ];
                                    @endphp

                                    @foreach($mantenimientos as $m)
                                    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
                                        <div class="flex items-center gap-3 mb-4">
                                            <div class="w-8 h-8 rounded-full bg-{{ $m['color'] }}-100 text-{{ $m['color'] }}-600 flex items-center justify-center"><i class="fas {{ $m['icon'] }}"></i></div>
                                            <h3 class="font-bold text-gray-800">{{ $m['label'] }}</h3>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                                            <div class="md:col-span-3">
                                                <label class="text-xs font-bold text-gray-500 uppercase mb-1 block">¿Requiere?</label>
                                                <select name="{{ $m['key'] }}" class="input-modern py-2">
                                                    <option value="0" {{ $property->{$m['key']} == 0 ? 'selected' : '' }}>No</option>
                                                    <option value="1" {{ $property->{$m['key']} == 1 ? 'selected' : '' }}>Sí</option>
                                                </select>
                                            </div>
                                            <div class="md:col-span-4">
                                                <label class="text-xs font-bold text-gray-500 uppercase mb-1 block">Última Fecha</label>
                                                <input type="date" name="fecha_{{ $m['key'] }}" class="input-modern py-2" value="{{ old('fecha_'.$m['key'], $property->{'fecha_'.$m['key']}) }}">
                                            </div>
                                            <div class="md:col-span-5">
                                                <label class="text-xs font-bold text-gray-500 uppercase mb-1 block">Requerimiento</label>
                                                <input type="text" name="req_{{ $m['key'] }}" class="input-modern py-2" value="{{ old('req_'.$m['key'], $property->{'req_'.$m['key']}) }}">
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach

                                </div>
                                
                                <div class="lg:col-span-4 mt-6 lg:mt-0">
                                    <div class="bg-gray-50 p-5 rounded-2xl border border-gray-200">
                                        <h3 class="text-sm font-bold text-gray-800 mb-4 uppercase tracking-wide">Estructuras</h3>
                                        <div class="space-y-3">
                                            @foreach(['retiro_estructuras' => 'Retiro Estructuras', 'malla' => 'Malla Ciclónica', 'sombra' => 'Malla Sombra', 'barda' => 'Barda Perimetral'] as $key => $label)
                                            <div class="flex justify-between items-center bg-white p-3 rounded-lg shadow-sm border border-gray-100">
                                                <label class="text-sm font-medium text-gray-600">{{ $label }}</label>
                                                <select name="{{ $key }}" class="bg-transparent font-bold text-gray-800 focus:outline-none cursor-pointer">
                                                    <option value="0" {{ $property->$key == 0 ? 'selected' : '' }}>No</option>
                                                    <option value="1" {{ $property->$key == 1 ? 'selected' : '' }}>Sí</option>
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
                            <h2 class="text-lg md:text-xl font-bold text-gray-800 mb-6 border-b pb-2">Comentarios Finales</h2>
                            <div class="w-full">
                                <label class="label-modern mb-3">Observaciones Generales</label>
                                <textarea name="actividades" rows="8" class="input-modern resize-none h-52 rounded-xl w-full">{{ old('actividades', $property->actividades) }}</textarea>
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
                                    <i class="fas fa-save"></i> Actualizar
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
    // Preview de imagen
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

    // Toggle inputs de archivos
    function toggleFileInput(selectElement, key) {
        const fileInput = document.getElementById(`file-${key}`);
        selectElement.value === "1" ? fileInput.classList.remove('hidden') : fileInput.classList.add('hidden');
    }

    // Wizard Logic
    document.addEventListener('DOMContentLoaded', () => {
        let currentStep = 1; 
        const totalSteps = 4;
        const nextBtn = document.getElementById('nextBtn');
        const prevBtn = document.getElementById('prevBtn');
        const submitBtn = document.getElementById('submitBtn');

        function updateUI() {
            document.querySelectorAll('.form-step').forEach(el => el.classList.add('hidden'));
            document.getElementById(`step-${currentStep}`).classList.remove('hidden');

            prevBtn.classList.toggle('hidden', currentStep === 1);
            
            if (currentStep === totalSteps) {
                nextBtn.classList.add('hidden');
                submitBtn.classList.remove('hidden');
            } else {
                nextBtn.classList.remove('hidden');
                submitBtn.classList.add('hidden');
            }

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

        nextBtn.addEventListener('click', () => { if (currentStep < totalSteps) { currentStep++; updateUI(); } });
        prevBtn.addEventListener('click', () => { if (currentStep > 1) { currentStep--; updateUI(); } });
        updateUI();
    });
</script>
@endsection