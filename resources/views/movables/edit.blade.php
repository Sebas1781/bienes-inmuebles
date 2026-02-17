@extends('layouts.app')

@section('content')
<style>
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
</style>

<div class="min-h-screen bg-gradient-to-br from-gray-50 via-rose-50/20 to-gray-100 flex flex-col relative font-sans">

    <x-header title="Editar Bien Mueble" />

    <div class="flex flex-1 relative">

        <x-sidebar active="movables" />

        <main class="flex-1 p-3 md:p-8 overflow-y-auto w-full scroll-smooth pb-24 md:pb-8 md:ml-64">
            <div class="max-w-6xl mx-auto">

                <form action="{{ route('movables.update', $movable->numero_consecutivo) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Tipo de Costo y Es Auto --}}
                    <div class="form-card p-5 md:p-8 rounded-2xl">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-6">
                            <div>
                                <label class="label-modern">Tipo de Costo <span class="text-red-500">*</span></label>
                                <select name="tipo_costo" class="input-modern" required>
                                    <option value="">Seleccione una opción</option>
                                    <option value="Alto costo" {{ old('tipo_costo', $movable->tipo_costo ?? '') == 'Alto costo' ? 'selected' : '' }}>Alto costo</option>
                                    <option value="Bajo Costo" {{ old('tipo_costo', $movable->tipo_costo ?? '') == 'Bajo Costo' ? 'selected' : '' }}>Bajo Costo</option>
                                </select>
                            </div>
                            <div class="flex items-end">
                                <label class="flex items-center gap-3 cursor-pointer p-4 bg-gradient-to-br from-purple-50 to-violet-50 rounded-xl border-2 border-purple-200 hover:border-purple-400 transition-all duration-300 w-full">
                                    <input type="checkbox" id="es_auto" name="es_auto" value="1" {{ old('es_auto', $movable->es_auto ?? false) ? 'checked' : '' }} class="w-5 h-5 text-purple-600 rounded focus:ring-2 focus:ring-purple-500" onchange="togglePolizaSection()">
                                    <span class="font-bold text-gray-700"><i class="fas fa-car text-purple-600 mr-2"></i>Es auto</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Datos Generales --}}
                    <div class="form-card p-5 md:p-8 rounded-2xl">
                        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100/80">
                            <div class="section-title-icon bg-gradient-to-br from-rose-50 to-red-100 text-[#9b4d5c]">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <div>
                                <h2 class="text-lg md:text-xl font-bold text-gray-800">Datos Generales</h2>
                                <p class="text-xs text-gray-400 mt-0.5">Información principal del bien mueble</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 md:gap-6">
                            <div>
                                <label class="label-modern">Cuenta <span class="text-red-500">*</span></label>
                                <input type="number" name="cuenta" value="{{ $movable->cuenta }}" class="input-modern" required placeholder="Ej: 1234">
                            </div>
                            <div>
                                <label class="label-modern">Sub-Cuenta <span class="text-red-500">*</span></label>
                                <input type="number" name="sub_cuenta" value="{{ $movable->sub_cuenta }}" class="input-modern" required placeholder="Ej: 56">
                            </div>
                            <div>
                                <label class="label-modern">Nombre de la Cuenta</label>
                                <input type="text" name="nombre_cuenta" value="{{ $movable->nombre_cuenta }}" class="input-modern" placeholder="Ej: Mobiliario y Equipo">
                            </div>
                            <div>
                                <label class="label-modern">Número de Inventario</label>
                                <input type="text" name="numero_inventario" value="{{ $movable->numero_inventario }}" class="input-modern" placeholder="Ej: INV-2024-001">
                            </div>
                            <div>
                                <label class="label-modern">Nombre del Resguardatario</label>
                                <input type="text" name="nombre_resguardatario" value="{{ $movable->nombre_resguardatario }}" class="input-modern" placeholder="Ej: Juan Pérez">
                            </div>
                            <div>
                                <label class="label-modern">Área</label>
                                <input type="text" name="area" value="{{ $movable->area }}" class="input-modern" placeholder="Ej: Sistemas">
                            </div>
                        </div>
                    </div>

                    {{-- Descripción del Bien --}}
                    <div class="form-card p-5 md:p-8 rounded-2xl">
                        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100/80">
                            <div class="section-title-icon bg-gradient-to-br from-blue-50 to-indigo-100 text-blue-600">
                                <i class="fas fa-box"></i>
                            </div>
                            <div>
                                <h2 class="text-lg md:text-xl font-bold text-gray-800">Descripción del Bien</h2>
                                <p class="text-xs text-gray-400 mt-0.5">Información específica del mueble</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-6">
                            <div class="md:col-span-2">
                                <label class="label-modern">Nombre del Mueble</label>
                                <input type="text" name="nombre_mueble" value="{{ $movable->nombre_mueble }}" class="input-modern" placeholder="Ej: Escritorio ejecutivo">
                            </div>
                            <div>
                                <label class="label-modern">Marca</label>
                                <input type="text" name="marca" value="{{ $movable->marca }}" class="input-modern" placeholder="Ej: Dell">
                            </div>
                            <div>
                                <label class="label-modern">Modelo</label>
                                <input type="text" name="modelo" value="{{ $movable->modelo }}" class="input-modern" placeholder="Ej: Latitude 5420">
                            </div>
                            <div>
                                <label class="label-modern">Número de Serie</label>
                                <input type="text" name="numero_serie" value="{{ $movable->numero_serie }}" class="input-modern" placeholder="Ej: SN123456789">
                            </div>
                            <div id="campo-placa" style="display: {{ old('es_auto', $movable->es_auto ?? false) ? 'block' : 'none' }};">
                                <label class="label-modern">Número de Placa</label>
                                <input type="text" name="numero_placa" value="{{ $movable->numero_placa }}" class="input-modern" placeholder="Ej: ABC-123">
                            </div>
                            <div id="campo-motor" class="md:col-span-2" style="display: {{ old('es_auto', $movable->es_auto ?? false) ? 'block' : 'none' }};">
                                <label class="label-modern">Número de Motor</label>
                                <input type="text" name="numero_motor" value="{{ $movable->numero_motor }}" class="input-modern" placeholder="Ej: MOT123456">
                            </div>
                        </div>
                    </div>

                    {{-- Factura o CFDI --}}
                    <div class="form-card p-5 md:p-8 rounded-2xl">
                        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100/80">
                            <div class="section-title-icon bg-gradient-to-br from-green-50 to-emerald-100 text-green-600">
                                <i class="fas fa-file-invoice"></i>
                            </div>
                            <div>
                                <h2 class="text-lg md:text-xl font-bold text-gray-800">Factura o CFDI</h2>
                                <p class="text-xs text-gray-400 mt-0.5">Información de la factura de compra</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-6">
                            <div>
                                <label class="label-modern">Número de Factura <span class="text-red-500">*</span></label>
                                <input type="number" name="factura_numero" value="{{ $movable->factura_numero }}" class="input-modern" required placeholder="Ej: 12345">
                            </div>
                            <div>
                                <label class="label-modern">Fecha de Factura <span class="text-red-500">*</span></label>
                                <input type="datetime-local" name="factura_fecha" value="{{ $movable->factura_fecha ? $movable->factura_fecha->format('Y-m-d\TH:i') : '' }}" class="input-modern" required>
                            </div>
                            <div>
                                <label class="label-modern">Proveedor</label>
                                <input type="text" name="factura_proveedor" value="{{ $movable->factura_proveedor }}" class="input-modern" placeholder="Ej: Compañía XYZ S.A.">
                            </div>
                            <div>
                                <label class="label-modern">Costo</label>
                                <input type="number" name="factura_costo" value="{{ $movable->factura_costo }}" class="input-modern" placeholder="Ej: 15000">
                            </div>
                        </div>
                    </div>

                    {{-- Póliza (visible solo si es auto) --}}
                    <div id="poliza-section" class="form-card p-5 md:p-8 rounded-2xl" style="display: {{ old('es_auto', $movable->es_auto ?? false) ? 'block' : 'none' }};">
                        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100/80">
                            <div class="section-title-icon bg-gradient-to-br from-purple-50 to-violet-100 text-purple-600">
                                <i class="fas fa-file-contract"></i>
                            </div>
                            <div>
                                <h2 class="text-lg md:text-xl font-bold text-gray-800">Póliza</h2>
                                <p class="text-xs text-gray-400 mt-0.5">Información de la póliza contable</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 md:gap-6">
                            <div>
                                <label class="label-modern">Tipo de Póliza <span class="text-red-500">*</span></label>
                                <input type="text" id="poliza_tipo" name="poliza_tipo" value="{{ $movable->poliza_tipo }}" class="input-modern" maxlength="1" placeholder="Ej: I, E, D">
                            </div>
                            <div>
                                <label class="label-modern">Número de Póliza <span class="text-red-500">*</span></label>
                                <input type="number" id="poliza_numero" name="poliza_numero" value="{{ $movable->poliza_numero }}" class="input-modern" placeholder="Ej: 123">
                            </div>
                            <div>
                                <label class="label-modern">Fecha de Póliza <span class="text-red-500">*</span></label>
                                <input type="datetime-local" id="poliza_fecha" name="poliza_fecha" value="{{ $movable->poliza_fecha ? $movable->poliza_fecha->format('Y-m-d\TH:i') : '' }}" class="input-modern">
                            </div>
                        </div>
                    </div>

                    {{-- Fecha de Movimiento --}}
                    <div class="form-card p-5 md:p-8 rounded-2xl">
                        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100/80">
                            <div class="section-title-icon bg-gradient-to-br from-orange-50 to-amber-100 text-orange-600">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div>
                                <h2 class="text-lg md:text-xl font-bold text-gray-800">Información de Alta</h2>
                                <p class="text-xs text-gray-400 mt-0.5">Fecha de registro del movimiento</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-6">
                            <div>
                                <label class="label-modern">Fecha del Movimiento de Alta <span class="text-red-500">*</span></label>
                                <input type="datetime-local" name="fecha_movimiento_alta" value="{{ $movable->fecha_movimiento_alta ? $movable->fecha_movimiento_alta->format('Y-m-d\TH:i') : '' }}" class="input-modern" required>
                            </div>
                        </div>
                    </div>

                    {{-- Botones de acción --}}
                    <div class="flex flex-col md:flex-row gap-3 justify-end sticky bottom-0 bg-gradient-to-t from-gray-100 to-transparent pt-6 pb-4 -mx-3 px-3 md:static md:bg-none">
                        <a href="{{ route('movables.index') }}" class="btn-secondary px-8 py-3 rounded-xl font-bold transition-all duration-300 text-center hover:shadow-md border-2 border-gray-300 bg-white text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-times mr-2"></i> Cancelar
                        </a>
                        <button type="submit" class="bg-gradient-to-r from-green-600 to-emerald-500 text-white px-8 py-3 rounded-xl font-bold transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5 hover:from-green-700 hover:to-emerald-600">
                            <i class="fas fa-save mr-2"></i> Actualizar
                        </button>
                    </div>

                </form>

            </div>
        </main>
    </div>
</div>

<script>
    function togglePolizaSection() {
        const checkbox = document.getElementById('es_auto');
        const polizaSection = document.getElementById('poliza-section');
        const polizaTipo = document.getElementById('poliza_tipo');
        const polizaNumero = document.getElementById('poliza_numero');
        const polizaFecha = document.getElementById('poliza_fecha');
        
        // Campos de auto (placa y motor)
        const campoPlaca = document.getElementById('campo-placa');
        const campoMotor = document.getElementById('campo-motor');
        
        if (checkbox.checked) {
            polizaSection.style.display = 'block';
            // Hacer campos requeridos cuando es auto
            polizaTipo.setAttribute('required', 'required');
            polizaNumero.setAttribute('required', 'required');
            polizaFecha.setAttribute('required', 'required');
            
            // Mostrar campos de auto
            campoPlaca.style.display = 'block';
            campoMotor.style.display = 'block';
        } else {
            polizaSection.style.display = 'none';
            // Quitar requerido cuando no es auto
            polizaTipo.removeAttribute('required');
            polizaNumero.removeAttribute('required');
            polizaFecha.removeAttribute('required');
            
            // Ocultar campos de auto
            campoPlaca.style.display = 'none';
            campoMotor.style.display = 'none';
        }
    }
</script>

@endsection
