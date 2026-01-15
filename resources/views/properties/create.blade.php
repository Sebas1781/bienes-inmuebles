@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 flex flex-col">
    
    <header class="bg-header text-white py-6 px-8 flex items-center justify-between shadow" style="background-color: #9b4d5c;">
        <div class="flex items-center gap-4">
            <img src="{{ asset('images/Recurso 8.png') }}" alt="Logo" class="h-10">
            <span class="text-3xl font-bold">Bienes Inmuebles</span>
        </div>
        <h1 class="text-2xl font-semibold">Agregar Inmueble</h1>
        <form action="{{ route('logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="text-red-200 hover:text-white flex items-center gap-2 transition">
                <i class="fas fa-sign-out-alt"></i> Cerrar sesión
            </button>
        </form>
    </header>

    <div class="flex flex-1">
        <aside class="w-64 bg-white border-r flex flex-col py-8 px-4 gap-2 shadow-inner">
            <a href="{{ route('properties.create') }}" class="flex items-center gap-3 py-3 px-4 rounded-lg bg-maroon-700 text-white font-semibold" style="background-color: #741728;">
                <i class="fas fa-plus-square"></i> Agregar inmueble
            </a>
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-gray-100 text-maroon-700 font-semibold transition">
                <i class="fas fa-warehouse"></i> Administrador de inmuebles
            </a>
            @if(auth()->user()->isSuperAdmin())
            <a href="{{ route('users.index') }}" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-gray-100 text-maroon-700 font-semibold transition">
                <i class="fas fa-users"></i> Administrador de usuarios
            </a>
            @endif
        </aside>

        <main class="flex-1 bg-gray-50 p-8 overflow-y-auto">
            <div class="max-w-5xl mx-auto">
                
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-800 mb-6">Nueva Ficha Técnica</h2>
                    
                    <div class="flex items-center justify-between mb-8 px-4">
                        <div class="flex flex-col items-center step-indicator" id="ind-1">
                            <div class="w-10 h-10 rounded-full bg-gray-900 text-white flex items-center justify-center font-bold mb-2 transition-colors duration-300">1</div>
                            <span class="text-sm font-bold text-gray-800">General</span>
                        </div>
                        <div class="flex-1 h-1 bg-gray-300 mx-4 rounded">
                            <div class="h-full bg-gray-900 transition-all duration-300 w-0" id="progress-1"></div>
                        </div>
                        
                        <div class="flex flex-col items-center step-indicator opacity-50" id="ind-2">
                            <div class="w-10 h-10 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center font-bold mb-2 transition-colors duration-300">2</div>
                            <span class="text-sm font-bold text-gray-500">Equipamiento</span>
                        </div>
                        <div class="flex-1 h-1 bg-gray-300 mx-4 rounded">
                            <div class="h-full bg-gray-900 transition-all duration-300 w-0" id="progress-2"></div>
                        </div>

                        <div class="flex flex-col items-center step-indicator opacity-50" id="ind-3">
                            <div class="w-10 h-10 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center font-bold mb-2 transition-colors duration-300">3</div>
                            <span class="text-sm font-bold text-gray-500">Mantenimiento</span>
                        </div>
                        <div class="flex-1 h-1 bg-gray-300 mx-4 rounded">
                            <div class="h-full bg-gray-900 transition-all duration-300 w-0" id="progress-3"></div>
                        </div>

                        <div class="flex flex-col items-center step-indicator opacity-50" id="ind-4">
                            <div class="w-10 h-10 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center font-bold mb-2 transition-colors duration-300">4</div>
                            <span class="text-sm font-bold text-gray-500">Finalizar</span>
                        </div>
                    </div>
                </div>

                <form id="propertyForm" action="{{ route('properties.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 pb-12">
                    @csrf

                    <div id="step-1" class="form-step">
                        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 mb-6">
                            <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Datos Generales</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div><label class="block text-sm font-bold text-gray-700 mb-1">Denominación</label><input type="text" name="denominacion" class="w-full bg-gray-200 border-none rounded-md py-2 px-4 focus:ring-2 focus:ring-gray-400"></div>
                                <div><label class="block text-sm font-bold text-gray-700 mb-1">Ubicación</label><input type="text" name="ubicacion" class="w-full bg-gray-200 border-none rounded-md py-2 px-4"></div>
                                <div><label class="block text-sm font-bold text-gray-700 mb-1">Comunidad</label><input type="text" name="comunidad" class="w-full bg-gray-200 border-none rounded-md py-2 px-4"></div>
                                <div><label class="block text-sm font-bold text-gray-700 mb-1">Clave Catastral</label><input type="text" name="clave_catastral" class="w-full bg-gray-200 border-none rounded-md py-2 px-4"></div>
                                <div><label class="block text-sm font-bold text-gray-700 mb-1">Coordenadas</label><input type="text" name="coordenadas" class="w-full bg-gray-200 border-none rounded-md py-2 px-4"></div>
                                <div><label class="block text-sm font-bold text-gray-700 mb-1">Superficie Total</label><input type="text" name="superficie_total" class="w-full bg-gray-200 border-none rounded-md py-2 px-4"></div>
                                <div class="md:col-span-2"><label class="block text-sm font-bold text-gray-700 mb-1">Uso y destino</label><input type="text" name="uso_destino" class="w-full bg-gray-200 border-none rounded-md py-2 px-4"></div>
                            </div>
                            <div class="grid grid-cols-3 gap-4 mt-6">
                                <div><label class="block text-sm font-bold text-gray-700 mb-1">¿Habitado?</label><select name="habitado" class="w-full bg-gray-200 border-none rounded-md py-2 px-3"><option value="0">No</option><option value="1">Sí</option></select></div>
                                <div><label class="block text-sm font-bold text-gray-700 mb-1">¿Propio?</label><select name="propio" class="w-full bg-gray-200 border-none rounded-md py-2 px-3"><option value="0">No</option><option value="1">Sí</option></select></div>
                                <div><label class="block text-sm font-bold text-gray-700 mb-1">¿Comodato?</label><select name="comodato" class="w-full bg-gray-200 border-none rounded-md py-2 px-3"><option value="0">No</option><option value="1">Sí</option></select></div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                                <div><label class="block text-sm font-bold text-gray-700 mb-1">Adscrito a</label><input type="text" name="adscrito_a" class="w-full bg-gray-200 border-none rounded-md py-2 px-4"></div>
                                <div><label class="block text-sm font-bold text-gray-700 mb-1">A resguardo de</label><input type="text" name="resguardo_servidor" class="w-full bg-gray-200 border-none rounded-md py-2 px-4"></div>
                                <div><label class="block text-sm font-bold text-gray-700 mb-1">Fecha Contrato</label><input type="date" name="fecha_contrato" class="w-full bg-gray-200 border-none rounded-md py-2 px-4"></div>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                            <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Multimedia y Servicios</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="flex flex-col justify-center">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Imagen Principal</label>
                                    <div class="h-48 bg-gray-300 rounded-lg flex items-center justify-center relative overflow-hidden group">
                                        <svg class="w-12 h-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <input type="file" name="imagen_principal" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                    </div>
                                    <p class="text-xs text-center text-gray-500 mt-2">Click para subir foto</p>
                                </div>
                                <div class="space-y-6">
                                    @foreach(['luz' => 'Luz', 'predio' => 'Predio', 'agua' => 'Agua'] as $key => $label)
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <label class="w-20 font-bold text-gray-700">{{ $label }}</label>
                                            <select name="{{ $key }}" class="bg-gray-200 border-none rounded py-1 px-2 text-sm"><option value="0">No</option><option value="1">Sí</option></select>
                                        </div>
                                        <button type="button" class="bg-gray-800 text-white text-sm py-1 px-4 rounded hover:bg-black transition">Anexar PDF</button>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="step-2" class="form-step hidden">
                        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                            <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Equipamiento</h2>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div><label class="block text-sm font-bold text-gray-700 mb-1">Oficinas Admin.</label><input type="text" name="oficinas_admin" class="w-full bg-gray-200 border-none rounded-md py-2 px-4"></div>
                                <div><label class="block text-sm font-bold text-gray-700 mb-1">Módulos Sanitarios</label><input type="text" name="modulos_sanitarios" class="w-full bg-gray-200 border-none rounded-md py-2 px-4"></div>
                                <div><label class="block text-sm font-bold text-gray-700 mb-1">Bodega</label><input type="text" name="bodega" class="w-full bg-gray-200 border-none rounded-md py-2 px-4"></div>
                                <div><label class="block text-sm font-bold text-gray-700 mb-1">Núm. ventana</label><input type="text" name="num_ventana" class="w-full bg-gray-200 border-none rounded-md py-2 px-4"></div>
                                <div><label class="block text-sm font-bold text-gray-700 mb-1">Tienda</label><input type="text" name="tienda" class="w-full bg-gray-200 border-none rounded-md py-2 px-4"></div>
                                <div><label class="block text-sm font-bold text-gray-700 mb-1">Portón</label><input type="text" name="porton" class="w-full bg-gray-200 border-none rounded-md py-2 px-4"></div>
                            </div>
                        </div>
                    </div>

                    <div id="step-3" class="form-step hidden">
                        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                            <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Mantenimiento</h2>
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                                <div class="lg:col-span-2 space-y-4">
                                    @foreach([
                                        'pintura' => 'Pintura', 
                                        'recoleccion_basura' => 'Recolección', 
                                        'poda' => 'Poda', 
                                        'impermeabilizacion' => 'Impermeab.'
                                    ] as $key => $label)
                                    <div class="grid grid-cols-12 gap-2 items-end border-b pb-4 lg:border-none lg:pb-0">
                                        <div class="col-span-12 lg:col-span-2 font-bold text-gray-700 text-sm">{{ $label }}</div>
                                        <div class="col-span-4 lg:col-span-2"><select name="{{ $key }}" class="w-full bg-gray-200 border-none rounded py-1 px-2 text-sm"><option value="0">No</option><option value="1">Sí</option></select></div>
                                        <div class="col-span-4 lg:col-span-4"><label class="text-xs text-gray-500 block">Fecha</label><input type="date" name="fecha_{{ explode('_',$key)[0] }}" class="w-full bg-gray-200 border-none rounded py-1 px-2 text-sm"></div>
                                        <div class="col-span-4 lg:col-span-4"><label class="text-xs text-gray-500 block">Req.</label><input type="text" name="req_{{ explode('_',$key)[0] }}" class="w-full bg-gray-200 border-none rounded py-1 px-2 text-sm"></div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="lg:col-span-1 space-y-4 bg-gray-50 p-4 rounded-lg">
                                    @foreach(['retiro_estructuras' => 'Retiro Estructuras', 'malla' => 'Malla', 'sombra' => 'Sombra', 'barda' => 'Barda Perimetral'] as $key => $label)
                                    <div class="flex justify-between items-center">
                                        <label class="text-sm font-bold text-gray-700">{{ $label }}</label>
                                        <select name="{{ $key }}" class="bg-gray-200 border-none rounded py-1 px-2"><option value="0">No</option><option value="1">Sí</option></select>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="step-4" class="form-step hidden">
                        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                            <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Actividades Realizadas</h2>
                            <textarea name="actividades" rows="6" placeholder="Detalle aquí las actividades, observaciones o comentarios finales..." class="w-full bg-gray-200 border-none rounded-lg p-4 focus:ring-2 focus:ring-gray-400"></textarea>
                        </div>
                    </div>

                    <div class="flex justify-between items-center pt-6 border-t mt-4">
                        <button type="button" id="prevBtn" class="px-6 py-2 bg-gray-300 text-gray-700 font-bold rounded-lg hover:bg-gray-400 transition hidden">
                            Anterior
                        </button>
                        
                        <div class="flex gap-4">
                            <a href="{{ route('dashboard') }}" class="px-6 py-2 text-gray-500 font-semibold hover:underline">Cancelar</a>
                            <button type="button" id="nextBtn" class="px-8 py-2 bg-gray-900 text-white font-bold rounded-lg hover:bg-black transition shadow-lg">
                                Siguiente
                            </button>
                            <button type="submit" id="submitBtn" class="px-8 py-2 bg-green-700 text-white font-bold rounded-lg hover:bg-green-800 transition shadow-lg hidden">
                                Guardar Todo
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </main>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let currentStep = 1;
        const totalSteps = 4;

        const nextBtn = document.getElementById('nextBtn');
        const prevBtn = document.getElementById('prevBtn');
        const submitBtn = document.getElementById('submitBtn');

        function updateStep() {
            // Ocultar todos los pasos
            document.querySelectorAll('.form-step').forEach(el => el.classList.add('hidden'));
            // Mostrar paso actual
            document.getElementById(`step-${currentStep}`).classList.remove('hidden');

            // Actualizar botones
            prevBtn.classList.toggle('hidden', currentStep === 1);
            
            if (currentStep === totalSteps) {
                nextBtn.classList.add('hidden');
                submitBtn.classList.remove('hidden');
            } else {
                nextBtn.classList.remove('hidden');
                submitBtn.classList.add('hidden');
            }

            // Actualizar Barra de Progreso e Indicadores
            for (let i = 1; i <= totalSteps; i++) {
                const ind = document.getElementById(`ind-${i}`);
                const circle = ind.querySelector('div');
                const text = ind.querySelector('span');
                const bar = document.getElementById(`progress-${i-1}`); // Barra anterior

                if (i <= currentStep) {
                    ind.classList.remove('opacity-50');
                    circle.classList.remove('bg-gray-300', 'text-gray-600');
                    circle.classList.add('bg-gray-900', 'text-white');
                    text.classList.remove('text-gray-500');
                    text.classList.add('text-gray-800');
                    
                    if(bar) bar.style.width = "100%";
                } else {
                    ind.classList.add('opacity-50');
                    circle.classList.add('bg-gray-300', 'text-gray-600');
                    circle.classList.remove('bg-gray-900', 'text-white');
                    text.classList.add('text-gray-500');
                    text.classList.remove('text-gray-800');

                    if(bar) bar.style.width = "0%";
                }
            }
        }

        nextBtn.addEventListener('click', () => {
            if (currentStep < totalSteps) {
                currentStep++;
                updateStep();
                // Scroll arriba suave
                document.querySelector('main').scrollTo({ top: 0, behavior: 'smooth' });
            }
        });

        prevBtn.addEventListener('click', () => {
            if (currentStep > 1) {
                currentStep--;
                updateStep();
                document.querySelector('main').scrollTo({ top: 0, behavior: 'smooth' });
            }
        });

        // Inicializar
        updateStep();
    });
</script>
@endsection