<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($cotizacion) ? 'Editar Cotización' : 'Nueva Cotización' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* Transición de entrada/salida del overlay */
        #modal-material, #modal-servicio {
            transition: opacity 0.2s ease;
        }
        #modal-material.hidden, #modal-servicio.hidden {
            pointer-events: none;
        }
        /* Animación del panel del modal */
        #modal-material .modal-panel, #modal-servicio .modal-panel {
            transition: transform 0.2s ease, opacity 0.2s ease;
        }
        #modal-material.hidden .modal-panel, #modal-servicio.hidden .modal-panel {
            transform: scale(0.95);
            opacity: 0;
        }
    </style>
</head>
<body class="bg-slate-50">

{{-- ================================================================
     MODAL — EDITAR MATERIAL EXISTENTE
     Se abre al hacer clic en "Editar" de cualquier fila de la tabla.
================================================================= --}}
<div id="modal-material"
     class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4">
    <div class="modal-panel bg-white rounded-2xl shadow-2xl w-full max-w-md p-6">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-lg font-bold text-slate-800">Editar material</h3>
            <button type="button" id="modal-material-cerrar"
                    class="text-slate-400 hover:text-slate-600 transition-colors">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        {{-- Nombre del material (solo lectura) --}}
        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1">Material</p>
        <p id="modal-mat-nombre" class="text-sm font-medium text-slate-800 mb-4 bg-slate-50 rounded-lg px-3 py-2"></p>

        {{-- Proveedor --}}
        <div class="mb-4">
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1">
                Proveedor
            </label>
            <div id="modal-mat-prov-loading" class="text-sm text-slate-400 hidden">
                <i data-lucide="loader-2" class="w-4 h-4 inline animate-spin mr-1"></i> Cargando proveedores…
            </div>
            <select id="modal-mat-proveedor"
                    class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-slate-400 focus:outline-none">
                <option value="">Seleccione proveedor</option>
            </select>
        </div>

        {{-- Cantidad --}}
        <div class="mb-6">
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1">
                Cantidad <span id="modal-mat-unidad" class="normal-case font-normal text-slate-400"></span>
            </label>
            <input type="number" id="modal-mat-cantidad" min="0.01" step="0.01"
                   class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-slate-400 focus:outline-none">
        </div>

        {{-- Acciones --}}
        <div class="flex items-center justify-between gap-3">
            <button type="button" id="modal-mat-eliminar"
                    class="flex items-center gap-2 text-sm text-red-600 hover:text-red-700 border border-red-200 hover:border-red-400 px-4 py-2 rounded-lg transition-colors">
                <i data-lucide="trash-2" class="w-4 h-4"></i> Eliminar
            </button>
            <div class="flex gap-2">
                <button type="button" id="modal-mat-cancelar"
                        class="text-sm border border-slate-300 px-4 py-2 rounded-lg hover:bg-slate-50 transition-colors">
                    Cancelar
                </button>
                <button type="button" id="modal-mat-guardar"
                        class="text-sm bg-slate-800 text-white px-4 py-2 rounded-lg hover:bg-slate-700 transition-colors">
                    Guardar cambios
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ================================================================
     MODAL — EDITAR SERVICIO EXISTENTE
================================================================= --}}
<div id="modal-servicio"
     class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4">
    <div class="modal-panel bg-white rounded-2xl shadow-2xl w-full max-w-md p-6">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-lg font-bold text-slate-800">Editar servicio</h3>
            <button type="button" id="modal-servicio-cerrar"
                    class="text-slate-400 hover:text-slate-600 transition-colors">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        {{-- Nombre del servicio (solo lectura) --}}
        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1">Servicio</p>
        <p id="modal-serv-nombre" class="text-sm font-medium text-slate-800 mb-4 bg-slate-50 rounded-lg px-3 py-2"></p>

        {{-- Proveedor --}}
        <div class="mb-4">
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1">
                Proveedor
            </label>
            <div id="modal-serv-prov-loading" class="text-sm text-slate-400 hidden">
                <i data-lucide="loader-2" class="w-4 h-4 inline animate-spin mr-1"></i> Cargando proveedores…
            </div>
            <select id="modal-serv-proveedor"
                    class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-slate-400 focus:outline-none">
                <option value="">Seleccione proveedor</option>
            </select>
        </div>

        {{-- Cantidad --}}
        <div class="mb-6">
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1">
                Cantidad <span id="modal-serv-unidad" class="normal-case font-normal text-slate-400"></span>
            </label>
            <input type="number" id="modal-serv-cantidad" min="0.01" step="0.01"
                   class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-slate-400 focus:outline-none">
        </div>

        {{-- Acciones --}}
        <div class="flex items-center justify-between gap-3">
            <button type="button" id="modal-serv-eliminar"
                    class="flex items-center gap-2 text-sm text-red-600 hover:text-red-700 border border-red-200 hover:border-red-400 px-4 py-2 rounded-lg transition-colors">
                <i data-lucide="trash-2" class="w-4 h-4"></i> Eliminar
            </button>
            <div class="flex gap-2">
                <button type="button" id="modal-serv-cancelar"
                        class="text-sm border border-slate-300 px-4 py-2 rounded-lg hover:bg-slate-50 transition-colors">
                    Cancelar
                </button>
                <button type="button" id="modal-serv-guardar"
                        class="text-sm bg-slate-800 text-white px-4 py-2 rounded-lg hover:bg-slate-700 transition-colors">
                    Guardar cambios
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ================================================================
     CABECERA
================================================================= --}}
<div class="bg-gradient-to-r from-slate-700 to-slate-800 text-white py-12">
    <div class="container mx-auto px-4">
        <a href="{{ route('cotizaciones') }}" class="inline-flex items-center text-white hover:text-slate-200 mb-4">
            <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i> Volver
        </a>
        <div class="flex items-center gap-4">
            <i data-lucide="file-text" class="w-12 h-12"></i>
            <div>
                <h1 class="text-4xl font-bold">{{ isset($cotizacion) ? 'Editar Cotización' : 'Nueva Cotización' }}</h1>
                <p class="text-slate-300">Selecciona cliente, materiales y servicios</p>
            </div>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 py-8">
    <form id="cotizacionForm" method="POST"
          action="{{ isset($cotizacion) ? route('cotizaciones.actualizar', $cotizacion->ID_cotizacion) : route('cotizaciones.guardar') }}">
        @csrf
        @if(isset($cotizacion)) @method('PUT') @endif

        <input type="hidden" name="materiales_json" id="materiales_json">
        <input type="hidden" name="servicios_json"  id="servicios_json">

        {{-- ============================================================
             1. Datos del proyecto y cliente
        =============================================================== --}}
        <div class="bg-white rounded-2xl p-8 shadow-lg mb-6">
            <h2 class="text-2xl font-bold mb-4">Proyecto y Cliente</h2>

            {{-- Checkbox --}}
            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" id="usarProyectoExistente" class="rounded border-slate-300 text-slate-600 shadow-sm focus:ring-slate-500">
                    <input type="hidden" name="proyecto_id" id="proyecto_id">
                    <span class="ml-2 text-sm text-slate-700">Usar proyecto existente</span>
                </label>
            </div>
            <div>
                <label class="block font-semibold mb-2">Estado de la Cotización</label>
                <select name="estado" id="estado" class="w-full border rounded-lg px-4 py-2">
                    <option value="0" {{ (old('estado', $cotizacion->estado ?? 0) == 0) ? 'selected' : '' }}>Borrador</option>
                    <option value="1" {{ (old('estado', $cotizacion->estado ?? 0) == 1) ? 'selected' : '' }}>Enviada</option>
                    <option value="2" {{ (old('estado', $cotizacion->estado ?? 0) == 2) ? 'selected' : '' }}>Aprobada</option>
                    <option value="3" {{ (old('estado', $cotizacion->estado ?? 0) == 3) ? 'selected' : '' }}>Rechazada</option>
                </select>
            </div>

            {{-- Select de proyectos (oculto inicialmente) --}}
            <div id="proyectoSelectContainer" class="mb-4 hidden">
                <label class="block font-semibold mb-2">Selecciona un proyecto</label>
                <select id="proyectoSelect" class="w-full border rounded-lg px-4 py-2">
                    <option value="">-- Seleccione un proyecto --</option>
                    @foreach($proyectos as $proyecto)
                        <option value="{{ $proyecto->ID_proyecto }}"
                                data-cliente-id="{{ $proyecto->fk_id_cliente }}"
                                data-cliente-nombre="{{ $proyecto->cliente->nombre ?? '' }}"
                                data-cliente-telefono="{{ $proyecto->cliente->telefono ?? '' }}"
                                data-cliente-email="{{ $proyecto->cliente->email ?? '' }}">
                            {{ $proyecto->nombre }} ({{ $proyecto->cliente->nombre ?? 'Sin cliente' }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Campos del proyecto/cliente --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block font-semibold mb-2">Nombre del Proyecto *</label>
                    <input type="text" name="nombre_proyecto" id="nombre_proyecto" required
                        class="w-full border rounded-lg px-4 py-2"
                        value="{{ old('nombre_proyecto', $cotizacion->proyecto->nombre ?? '') }}">
                </div>
                <div>
                    <label class="block font-semibold mb-2">Cliente *</label>
                    <select name="cliente_id" id="cliente_id" required class="w-full border rounded-lg px-4 py-2">
                        <option value="">Seleccione cliente</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->ID_cliente }}"
                                {{ (old('cliente_id', $cotizacion->proyecto->fk_id_cliente ?? '') == $cliente->ID_cliente) ? 'selected' : '' }}>
                                {{ $cliente->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block font-semibold mb-2">Teléfono</label>
                    <input type="text" id="telefono" readonly class="w-full border rounded-lg bg-gray-100 px-4 py-2">
                </div>
                <div>
                    <label class="block font-semibold mb-2">Correo electrónico</label>
                    <input type="email" id="email" readonly class="w-full border rounded-lg bg-gray-100 px-4 py-2">
                </div>
            </div>
        </div>  
    </div>
</div>

        {{-- ============================================================
             2. MATERIALES
        =============================================================== --}}
        <div class="bg-white rounded-2xl p-8 shadow-lg mb-6">
            <h2 class="text-2xl font-bold mb-4 flex justify-between items-center">
                Materiales
                <button type="button" id="btnAgregarMaterial"
                        class="bg-slate-700 text-white px-4 py-2 rounded-lg text-sm flex items-center gap-2">
                    <i data-lucide="plus" class="w-4 h-4"></i> Agregar material
                </button>
            </h2>

            @if(isset($materialesExistentes) && count($materialesExistentes) > 0)
            <div class="mb-6">
                <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wide mb-2">Materiales guardados</h3>
                <div class="overflow-x-auto rounded-lg border border-slate-200">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-100 text-slate-600">
                            <tr>
                                <th class="px-4 py-2 text-left">Material</th>
                                <th class="px-4 py-2 text-left">Proveedor</th>
                                <th class="px-4 py-2 text-right">Cant.</th>
                                <th class="px-4 py-2 text-right">P. Unit.</th>
                                <th class="px-4 py-2 text-right">Subtotal</th>
                                <th class="px-4 py-2 text-center w-24">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100" id="tbody-materiales-existentes">
                            @foreach($materialesExistentes as $mat)
                            <tr class="existing-material-row"
                                data-abastecimiento-id="{{ $mat['abastecimiento_id'] }}"
                                data-material-id="{{ $mat['material_id'] }}"
                                data-cantidad="{{ $mat['cantidad'] }}"
                                data-precio="{{ $mat['precio_unitario'] }}"
                                data-material-text="{{ $mat['material_text'] }}"
                                data-proveedor-text="{{ $mat['proveedor_text'] }}"
                                data-unidad="{{ $mat['unidad'] }}">
                                <td class="px-4 py-2 cell-material-text">{{ $mat['material_text'] }}</td>
                                <td class="px-4 py-2 text-slate-600 cell-proveedor-text">{{ $mat['proveedor_text'] }}</td>
                                <td class="px-4 py-2 text-right cell-cantidad">{{ $mat['cantidad'] }} <span class="text-slate-400 text-xs">{{ $mat['unidad'] }}</span></td>
                                <td class="px-4 py-2 text-right cell-precio">${{ number_format($mat['precio_unitario'], 2) }}</td>
                                <td class="px-4 py-2 text-right font-semibold text-emerald-700 cell-subtotal">
                                    ${{ number_format($mat['cantidad'] * $mat['precio_unitario'], 2) }}
                                </td>
                                <td class="px-4 py-2 text-center">
                                    <button type="button"
                                            class="btn-editar-material inline-flex items-center gap-1 text-xs bg-slate-100 hover:bg-slate-200 text-slate-700 px-2 py-1.5 rounded-md transition-colors">
                                        <i data-lucide="pencil" class="w-3 h-3"></i> Editar
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <p class="text-xs text-slate-400 mt-1">
                    Usa el botón <strong>Editar</strong> para modificar cantidad, cambiar proveedor o eliminar un material.
                </p>
            </div>
            @endif

            <div id="materiales-wrapper">
                <div class="grid grid-cols-1 gap-4" id="materiales-list"></div>
            </div>
        </div>

        {{-- ============================================================
             3. SERVICIOS
        =============================================================== --}}
        <div class="bg-white rounded-2xl p-8 shadow-lg mb-6">
            <h2 class="text-2xl font-bold mb-4 flex justify-between items-center">
                Servicios (Mano de obra)
                <button type="button" id="btnAgregarServicio"
                        class="bg-slate-700 text-white px-4 py-2 rounded-lg text-sm flex items-center gap-2">
                    <i data-lucide="plus" class="w-4 h-4"></i> Agregar servicio
                </button>
            </h2>

            @if(isset($serviciosExistentes) && count($serviciosExistentes) > 0)
            <div class="mb-6">
                <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wide mb-2">Servicios guardados</h3>
                <div class="overflow-x-auto rounded-lg border border-slate-200">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-100 text-slate-600">
                            <tr>
                                <th class="px-4 py-2 text-left">Servicio</th>
                                <th class="px-4 py-2 text-left">Proveedor</th>
                                <th class="px-4 py-2 text-right">Cant.</th>
                                <th class="px-4 py-2 text-right">P. Unit.</th>
                                <th class="px-4 py-2 text-right">Subtotal</th>
                                <th class="px-4 py-2 text-center w-24">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100" id="tbody-servicios-existentes">
                            @foreach($serviciosExistentes as $serv)
                            <tr class="existing-servicio-row"
                                data-mano-obra-id="{{ $serv['mano_obra_id'] }}"
                                data-servicio-id="{{ $serv['servicio_id'] ?? $serv['mano_obra_id'] }}"
                                data-cantidad="{{ $serv['cantidad'] }}"
                                data-precio="{{ $serv['precio_unitario'] }}"
                                data-servicio-text="{{ $serv['servicio_text'] }}"
                                data-proveedor-text="{{ $serv['proveedor_text'] }}"
                                data-unidad="{{ $serv['unidad'] }}">
                                <td class="px-4 py-2 cell-servicio-text">{{ $serv['servicio_text'] }}</td>
                                <td class="px-4 py-2 text-slate-600 cell-proveedor-text">{{ $serv['proveedor_text'] }}</td>
                                <td class="px-4 py-2 text-right cell-cantidad">{{ $serv['cantidad'] }} <span class="text-slate-400 text-xs">{{ $serv['unidad'] }}</span></td>
                                <td class="px-4 py-2 text-right cell-precio">${{ number_format($serv['precio_unitario'], 2) }}</td>
                                <td class="px-4 py-2 text-right font-semibold text-emerald-700 cell-subtotal">
                                    ${{ number_format($serv['cantidad'] * $serv['precio_unitario'], 2) }}
                                </td>
                                <td class="px-4 py-2 text-center">
                                    <button type="button"
                                            class="btn-editar-servicio inline-flex items-center gap-1 text-xs bg-slate-100 hover:bg-slate-200 text-slate-700 px-2 py-1.5 rounded-md transition-colors">
                                        <i data-lucide="pencil" class="w-3 h-3"></i> Editar
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <p class="text-xs text-slate-400 mt-1">
                    Usa el botón <strong>Editar</strong> para modificar cantidad, cambiar proveedor o eliminar un servicio.
                </p>
            </div>
            @endif

            <div id="servicios-wrapper">
                <div class="grid grid-cols-1 gap-4" id="servicios-list"></div>
            </div>
        </div>

        {{-- ============================================================
             4. Gastos generales y márgenes
        =============================================================== --}}
        <div class="bg-white rounded-2xl p-8 shadow-lg mb-6">
            <h2 class="text-2xl font-bold mb-4">Costos Adicionales</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block font-semibold mb-2">Costo de Equipo ($)</label>
                    <input type="number" name="costo_equipo" id="costo_equipo"
                           value="{{ old('costo_equipo', $cotizacion->costo_equipo ?? 0) }}"
                           step="0.01" class="w-full border rounded-lg px-4 py-2">
                </div>
                <div>
                    <label class="block font-semibold mb-2">Gastos Generales (%)</label>
                    <input type="number" name="gastos_generales" id="gastos_generales"
                           value="{{ old('gastos_generales', $cotizacion->gastos_generales ?? 10) }}"
                           step="0.1" class="w-full border rounded-lg px-4 py-2">
                </div>
                <div>
                    <label class="block font-semibold mb-2">Margen de Ganancia (%)</label>
                    <input type="number" name="margen_ganancia" id="margen_ganancia"
                           value="{{ old('margen_ganancia', $cotizacion->margen_ganancia ?? 15) }}"
                           step="0.1" class="w-full border rounded-lg px-4 py-2">
                </div>
            </div>
        </div>

        {{-- ============================================================
             5. Resumen
        =============================================================== --}}
        <div class="bg-gradient-to-br from-slate-100 to-slate-200 rounded-2xl p-8 shadow-lg">
            <h2 class="text-2xl font-bold mb-4">Resumen</h2>
            <div class="space-y-2 text-lg">
                <div class="flex justify-between"><span>Subtotal Materiales:</span><span id="sumMateriales">$0.00</span></div>
                <div class="flex justify-between"><span>Subtotal Servicios:</span><span id="sumServicios">$0.00</span></div>
                <div class="flex justify-between font-semibold"><span>Subtotal General:</span><span id="subtotalGeneral">$0.00</span></div>
                <div class="flex justify-between"><span>+ Gastos Generales:</span><span id="montoGastos">$0.00</span></div>
                <div class="flex justify-between"><span>+ Margen de Ganancia:</span><span id="montoMargen">$0.00</span></div>
                <div class="flex justify-between text-2xl font-bold pt-2 border-t">
                    <span>Total Cotización:</span><span id="totalFinal">$0.00</span>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-4 mt-8">
            <a href="{{ route('cotizaciones') }}" class="border border-slate-300 px-6 py-2 rounded-lg">Cancelar</a>
            <button type="submit" class="bg-slate-800 text-white px-6 py-2 rounded-lg">Guardar</button>
        </div>
    </form>
</div>

<script>
    lucide.createIcons();
    //============================================================
    //                  Variables globales
    //=============================================================
    const clienteSelect = document.getElementById('cliente_id');
    const telefonoInput = document.getElementById('telefono');
    const emailInput   = document.getElementById('email');
    const chkUsarProyecto = document.getElementById('usarProyectoExistente');
    const proyectoSelectContainer = document.getElementById('proyectoSelectContainer');
    const proyectoSelect = document.getElementById('proyectoSelect');
    const nombreProyectoInput = document.getElementById('nombre_proyecto');
    
    const clientesData = {!! json_encode($clientes->map(fn($c) => [
        'id'       => $c->ID_cliente,
        'telefono' => $c->telefono,
        'email'   => $c->email ?? ''
    ])->values()) !!};
    
    const categoriasMateriales = {!! json_encode($categoriasMateriales) !!};
    const categoriasServicios  = {!! json_encode($categoriasServicios) !!};

//=================================================================
//                      EVENTOS
//=================================================================
// ================================================================
//  PRECARGA EN MODO EDICIÓN (si existe cotización con proyecto)
// ================================================================
@if(isset($cotizacion) && $cotizacion->proyecto)
    const proyectoActualId = {{ $cotizacion->proyecto->ID_proyecto }};
    // Marcar checkbox
    chkUsarProyecto.checked = true;
    // Mostrar contenedor del select
    proyectoSelectContainer.classList.remove('hidden');
    // Seleccionar la opción correspondiente
    proyectoSelect.value = proyectoActualId;
    // Forzar el evento change para llenar los campos
    proyectoSelect.dispatchEvent(new Event('change'));
    // Deshabilitar campos de proyecto y cliente como si se hubiera marcado el checkbox
    nombreProyectoInput.disabled = true;
    clienteSelect.disabled = true;
@endif
// ================================================================
//  CLIENTE — autocompletar teléfono / correo
// ================================================================
if (clienteSelect) {
    clienteSelect.addEventListener('change', function () {
        const sel = clientesData.find(c => c.id == this.value);
        telefonoInput.value = sel?.telefono || '';
        emailInput.value   = sel?.email   || '';
    });
    if (clienteSelect.value) clienteSelect.dispatchEvent(new Event('change'));
}

// ================================================================
//  PROYECTO EXISTENTE
// ================================================================

if (chkUsarProyecto) {
    chkUsarProyecto.addEventListener('change', function() {
        if (this.checked) {
            proyectoSelectContainer.classList.remove('hidden');
            nombreProyectoInput.disabled = true;
            clienteSelect.disabled = true;
        } else {
            proyectoSelectContainer.classList.add('hidden');
            nombreProyectoInput.disabled = false;
            clienteSelect.disabled = false;
            proyectoSelect.value = '';
            nombreProyectoInput.value = '';
            clienteSelect.value = '';
            telefonoInput.value = '';
            emailInput.value = '';
        }
    });
}

if (proyectoSelect) {
    proyectoSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const proyectoNombre = selectedOption.text.split(' (')[0];
        const clienteId = selectedOption.dataset.clienteId;
        const clienteTelefono = selectedOption.dataset.clienteTelefono;
        const clienteEmail = selectedOption.dataset.clienteEmail;

        if (clienteId) {
            nombreProyectoInput.value = proyectoNombre;
            clienteSelect.value = clienteId;
            telefonoInput.value = clienteTelefono || '';
            emailInput.value = clienteEmail || '';
            clienteSelect.dispatchEvent(new Event('change'));
        }
    });
}


// ================================================================
//  HELPERS
// ================================================================
let materialIndex = 0;
let servicioIndex = 0;

async function fetchJSON(url) {
    const res = await fetch(url);
    if (!res.ok) throw new Error(`HTTP ${res.status} en ${url}`);
    return res.json();
}

/**
 * Llena un <select> con las opciones construidas por buildFn.
 * buildFn(o) debe devolver { value, label, dataset:{} }
 */
function llenarSelect(sel, opciones, labelVacio, buildFn, valorPreselect = null) {
    sel.innerHTML = `<option value="">${labelVacio}</option>`;
    opciones.forEach(o => {
        const { value, label, dataset: ds = {} } = buildFn(o);
        const opt = document.createElement('option');
        opt.value = value;
        opt.text  = label;
        Object.entries(ds).forEach(([k, v]) => { opt.dataset[k] = v; });
        sel.appendChild(opt);
    });
    if (valorPreselect != null) sel.value = valorPreselect;
    sel.disabled = false;
}

// ================================================================
//  MODAL — MATERIAL
//  Referencia a la fila <tr> que se está editando en este momento.
// ================================================================
let filaMatEditando = null;

const modalMat          = document.getElementById('modal-material');
const modalMatNombre    = document.getElementById('modal-mat-nombre');
const modalMatProveedor = document.getElementById('modal-mat-proveedor');
const modalMatCantidad  = document.getElementById('modal-mat-cantidad');
const modalMatUnidad    = document.getElementById('modal-mat-unidad');
const modalMatLoading   = document.getElementById('modal-mat-prov-loading');

/** Abre el modal de material cargando los proveedores disponibles para ese abastecimiento/material */
async function abrirModalMaterial(fila) {
    filaMatEditando = fila;
    const ds = fila.dataset;

    // Rellenar campos estáticos
    modalMatNombre.textContent      = ds.materialText;
    modalMatCantidad.value          = ds.cantidad;
    modalMatUnidad.textContent      = ds.unidad ? `(${ds.unidad})` : '';
    modalMatProveedor.innerHTML     = '<option value="">Cargando...</option>';
    modalMatProveedor.disabled      = true;
    modalMatLoading.classList.remove('hidden');

    // Mostrar modal
    modalMat.classList.remove('hidden');
    document.body.style.overflow = 'hidden';

    // Cargar proveedores para este material vía AJAX.
    // El endpoint recibe el fk_id_material; lo obtenemos del abastecimiento_id
    // que guardamos, pero necesitamos el ID del material, no del abastecimiento.
    // En CotizacionController::edit() se mapea 'abastecimiento_id' = ID_prod (abastecimiento).
    // El AjaxController::proveedoresPorMaterial recibe el ID_Material.
    // Por eso en el edit() del controlador también debemos pasar material_id.
    // Si no está disponible, usamos el endpoint de proveedores-por-material con el
    // campo data-material-id que agregamos al <tr>.
    try {
        const matId = ds.materialId; // ver nota en controller
        const provs = await fetchJSON(`/ajax/proveedores-por-material/${matId}`);
        modalMatLoading.classList.add('hidden');
        llenarSelect(
            modalMatProveedor,
            provs,
            'Seleccione proveedor',
            p => ({
                value:   p.ID_prod,
                label:   `${p.text} - $${p.precio}`,
                dataset: { precio: p.precio }
            }),
            ds.abastecimientoId   // pre-selecciona el proveedor actual
        );
    } catch (err) {
        modalMatLoading.classList.add('hidden');
        modalMatProveedor.innerHTML = '<option value="">Error al cargar</option>';
        console.error(err);
    }
}

function cerrarModalMaterial() {
    modalMat.classList.add('hidden');
    document.body.style.overflow = '';
    filaMatEditando = null;
}

// Guardar cambios del modal en la fila <tr>
document.getElementById('modal-mat-guardar').addEventListener('click', () => {
    if (!filaMatEditando) return;

    const nuevaCantidad = parseFloat(modalMatCantidad.value);
    if (!nuevaCantidad || nuevaCantidad <= 0) {
        modalMatCantidad.focus();
        modalMatCantidad.classList.add('border-red-400');
        return;
    }
    modalMatCantidad.classList.remove('border-red-400');

    const sel           = modalMatProveedor;
    const selectedOpt   = sel.options[sel.selectedIndex];
    const nuevoPrecio   = parseFloat(selectedOpt?.dataset?.precio || filaMatEditando.dataset.precio);
    const nuevoProvText = selectedOpt?.text || filaMatEditando.dataset.proveedorText;
    const nuevoAbastId  = sel.value || filaMatEditando.dataset.abastecimientoId;
    const unidad        = filaMatEditando.dataset.unidad;

    // Actualizar data-* de la fila (fuente de verdad para el submit)
    filaMatEditando.dataset.abastecimientoId = nuevoAbastId;
    filaMatEditando.dataset.cantidad         = nuevaCantidad;
    filaMatEditando.dataset.precio           = nuevoPrecio;
    filaMatEditando.dataset.proveedorText    = nuevoProvText;

    // Actualizar celdas visibles
    filaMatEditando.querySelector('.cell-proveedor-text').textContent = nuevoProvText;
    filaMatEditando.querySelector('.cell-cantidad').innerHTML =
        `${nuevaCantidad} <span class="text-slate-400 text-xs">${unidad}</span>`;
    filaMatEditando.querySelector('.cell-precio').textContent =
        `$${nuevoPrecio.toFixed(2)}`;
    filaMatEditando.querySelector('.cell-subtotal').textContent =
        `$${(nuevaCantidad * nuevoPrecio).toFixed(2)}`;

    actualizarTotalesGenerales();
    cerrarModalMaterial();
});

// Eliminar la fila directamente desde el modal
document.getElementById('modal-mat-eliminar').addEventListener('click', () => {
    if (!filaMatEditando) return;
    if (!confirm('¿Eliminar este material de la cotización?')) return;
    filaMatEditando.remove();
    actualizarTotalesGenerales();
    cerrarModalMaterial();
});

document.getElementById('modal-material-cerrar').addEventListener('click', cerrarModalMaterial);
document.getElementById('modal-mat-cancelar').addEventListener('click', cerrarModalMaterial);
// Cerrar al hacer clic en el overlay (fuera del panel)
modalMat.addEventListener('click', e => { if (e.target === modalMat) cerrarModalMaterial(); });

// ================================================================
//  MODAL — SERVICIO
// ================================================================
let filaServEditando = null;

const modalServ          = document.getElementById('modal-servicio');
const modalServNombre    = document.getElementById('modal-serv-nombre');
const modalServProveedor = document.getElementById('modal-serv-proveedor');
const modalServCantidad  = document.getElementById('modal-serv-cantidad');
const modalServUnidad    = document.getElementById('modal-serv-unidad');
const modalServLoading   = document.getElementById('modal-serv-prov-loading');

async function abrirModalServicio(fila) {
    filaServEditando = fila;
    const ds = fila.dataset;

    modalServNombre.textContent      = ds.servicioText;
    modalServCantidad.value          = ds.cantidad;
    modalServUnidad.textContent      = ds.unidad ? `(${ds.unidad})` : '';
    modalServProveedor.innerHTML     = '<option value="">Cargando...</option>';
    modalServProveedor.disabled      = true;
    modalServLoading.classList.remove('hidden');

    modalServ.classList.remove('hidden');
    document.body.style.overflow = 'hidden';

    // Para cargar proveedores por servicio necesitamos el ID_servicio.
    // El campo data-servicio-id en el <tr> debe contener el fk_id_servicio
    // (que viene del manoObra.fk_id_servicio). El controlador edit() ya tiene
    // acceso a $d->manoObra->fk_id_servicio — ver nota al pie.
    try {
        const servId = ds.servicioId || ds.manoObraId;
        const provs  = await fetchJSON(`/ajax/proveedores-por-servicio/${servId}`);
        modalServLoading.classList.add('hidden');
        llenarSelect(
            modalServProveedor,
            provs,
            'Seleccione proveedor',
            p => ({
                value:   p.id,   // ID_mano_obra
                label:   `${p.text} - $${p.precio}`,
                dataset: { precio: p.precio, unidad: p.unidad ?? '' }
            }),
            ds.manoObraId   // pre-selecciona el proveedor actual
        );
    } catch (err) {
        modalServLoading.classList.add('hidden');
        modalServProveedor.innerHTML = '<option value="">Error al cargar</option>';
        console.error(err);
    }
}

function cerrarModalServicio() {
    modalServ.classList.add('hidden');
    document.body.style.overflow = '';
    filaServEditando = null;
}

document.getElementById('modal-serv-guardar').addEventListener('click', () => {
    if (!filaServEditando) return;

    const nuevaCantidad = parseFloat(modalServCantidad.value);
    if (!nuevaCantidad || nuevaCantidad <= 0) {
        modalServCantidad.focus();
        modalServCantidad.classList.add('border-red-400');
        return;
    }
    modalServCantidad.classList.remove('border-red-400');

    const sel           = modalServProveedor;
    const selectedOpt   = sel.options[sel.selectedIndex];
    const nuevoPrecio   = parseFloat(selectedOpt?.dataset?.precio || filaServEditando.dataset.precio);
    const nuevoProvText = selectedOpt?.text || filaServEditando.dataset.proveedorText;
    const nuevoMoId     = sel.value || filaServEditando.dataset.manoObraId;
    const unidad        = selectedOpt?.dataset?.unidad || filaServEditando.dataset.unidad;

    // Actualizar data-* (fuente de verdad para el submit)
    filaServEditando.dataset.manoObraId   = nuevoMoId;
    filaServEditando.dataset.cantidad     = nuevaCantidad;
    filaServEditando.dataset.precio       = nuevoPrecio;
    filaServEditando.dataset.proveedorText = nuevoProvText;
    filaServEditando.dataset.unidad       = unidad;

    // Actualizar celdas visibles
    filaServEditando.querySelector('.cell-proveedor-text').textContent = nuevoProvText;
    filaServEditando.querySelector('.cell-cantidad').innerHTML =
        `${nuevaCantidad} <span class="text-slate-400 text-xs">${unidad}</span>`;
    filaServEditando.querySelector('.cell-precio').textContent =
        `$${nuevoPrecio.toFixed(2)}`;
    filaServEditando.querySelector('.cell-subtotal').textContent =
        `$${(nuevaCantidad * nuevoPrecio).toFixed(2)}`;

    actualizarTotalesGenerales();
    cerrarModalServicio();
});

document.getElementById('modal-serv-eliminar').addEventListener('click', () => {
    if (!filaServEditando) return;
    if (!confirm('¿Eliminar este servicio de la cotización?')) return;
    filaServEditando.remove();
    actualizarTotalesGenerales();
    cerrarModalServicio();
});

document.getElementById('modal-servicio-cerrar').addEventListener('click', cerrarModalServicio);
document.getElementById('modal-serv-cancelar').addEventListener('click', cerrarModalServicio);
modalServ.addEventListener('click', e => { if (e.target === modalServ) cerrarModalServicio(); });

// ================================================================
//  DELEGACIÓN DE EVENTOS — botones Editar en las tablas
// ================================================================
document.addEventListener('click', function (e) {
    // Botón editar material
    const btnMat = e.target.closest('.btn-editar-material');
    if (btnMat) {
        const fila = btnMat.closest('tr.existing-material-row');
        if (fila) abrirModalMaterial(fila);
    }

    // Botón editar servicio
    const btnServ = e.target.closest('.btn-editar-servicio');
    if (btnServ) {
        const fila = btnServ.closest('tr.existing-servicio-row');
        if (fila) abrirModalServicio(fila);
    }

    // Eliminar material dinámico (filas nuevas, sin modal)
    if (e.target.closest('.eliminar-material')) {
        e.target.closest('.material-item').remove();
        actualizarTotalesGenerales();
    }

    // Eliminar servicio dinámico (filas nuevas, sin modal)
    if (e.target.closest('.eliminar-servicio')) {
        e.target.closest('.servicio-item').remove();
        actualizarTotalesGenerales();
    }
});

// Cerrar modales con Escape
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        cerrarModalMaterial();
        cerrarModalServicio();
    }
});

// ================================================================
//  MATERIALES DINÁMICOS — agregar nuevos
// ================================================================
function agregarMaterialConDatos(datos = null) {
    const rowId = `mat_${materialIndex++}`;
    const html  = `
        <div class="material-item border p-4 rounded-lg relative bg-slate-50 mb-4" id="${rowId}">
            <button type="button" class="absolute top-2 right-2 text-red-500 eliminar-material">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-semibold">Categoría</label>
                    <select class="categoria-material w-full border px-3 py-2 rounded">
                        <option value="">Seleccione</option>
                        ${categoriasMateriales.map(c => `<option value="${c.id}">${c.text}</option>`).join('')}
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold">Material</label>
                    <select class="material-select w-full border px-3 py-2 rounded" disabled>
                        <option value="">Primero elija categoría</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold">Proveedor</label>
                    <select class="proveedor-select w-full border px-3 py-2 rounded" disabled>
                        <option value="">Primero elija material</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold">Cantidad</label>
                    <input type="number" class="cantidad-material w-full border px-3 py-2 rounded"
                           step="0.01" min="0" value="${datos ? datos.cantidad : 1}">
                </div>
            </div>
            <div class="mt-2 text-right text-emerald-600 font-bold">
                Subtotal: <span class="subtotal-material">$0.00</span>
            </div>
        </div>
    `;
    document.getElementById('materiales-list').insertAdjacentHTML('beforeend', html);
    lucide.createIcons();

    const container     = document.getElementById(rowId);
    const catSelect     = container.querySelector('.categoria-material');
    const matSelect     = container.querySelector('.material-select');
    const provSelect    = container.querySelector('.proveedor-select');
    const cantidadInput = container.querySelector('.cantidad-material');
    const subtotalSpan  = container.querySelector('.subtotal-material');

    catSelect.addEventListener('change', async (e) => {
        const catId = e.target.value;
        matSelect.disabled = true;
        matSelect.innerHTML = '<option value="">Cargando...</option>';
        provSelect.disabled = true;
        provSelect.innerHTML = '<option value="">Elija material</option>';
        if (!catId) return;
        try {
            const mats = await fetchJSON(`/ajax/materiales-por-categoria/${catId}`);
            llenarSelect(matSelect, mats, 'Seleccione material', m => ({
                value:   m.id,
                label:   m.text,
                dataset: { medidas: m.medidas ?? '' }
            }));
        } catch (err) {
            matSelect.innerHTML = '<option value="">Error al cargar</option>';
            console.error(err);
        }
    });

    matSelect.addEventListener('change', async (e) => {
        const matId = e.target.value;
        provSelect.disabled = true;
        provSelect.innerHTML = '<option value="">Cargando...</option>';
        if (!matId) return;
        try {
            const provs = await fetchJSON(`/ajax/proveedores-por-material/${matId}`);
            llenarSelect(provSelect, provs, 'Seleccione proveedor', p => ({
                value:   p.ID_prod,
                label:   `${p.text} - $${p.precio}`,
                dataset: { precio: p.precio }
            }));
            calcularSubtotal();
        } catch (err) {
            provSelect.innerHTML = '<option value="">Error al cargar</option>';
            console.error(err);
        }
    });

    function calcularSubtotal() {
        const cantidad = parseFloat(cantidadInput.value) || 0;
        const precio   = parseFloat(provSelect.options[provSelect.selectedIndex]?.dataset?.precio) || 0;
        subtotalSpan.textContent = `$${(cantidad * precio).toFixed(2)}`;
        actualizarTotalesGenerales();
    }

    cantidadInput.addEventListener('input', calcularSubtotal);
    provSelect.addEventListener('change', calcularSubtotal);
}

// ================================================================
//  SERVICIOS DINÁMICOS — agregar nuevos
// ================================================================
function agregarServicioConDatos(datos = null) {
    const rowId = `serv_${servicioIndex++}`;
    const html  = `
        <div class="servicio-item border p-4 rounded-lg relative bg-slate-50 mb-4" id="${rowId}">
            <button type="button" class="absolute top-2 right-2 text-red-500 eliminar-servicio">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-semibold">Categoría</label>
                    <select class="cat-servicio w-full border px-3 py-2 rounded">
                        <option value="">Seleccione</option>
                        ${categoriasServicios.map(c => `<option value="${c.id}">${c.text}</option>`).join('')}
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold">Servicio</label>
                    <select class="servicio-select w-full border px-3 py-2 rounded" disabled>
                        <option value="">Primero elija categoría</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold">Proveedor</label>
                    <select class="prov-servicio-select w-full border px-3 py-2 rounded" disabled>
                        <option value="">Primero elija servicio</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold">Cantidad</label>
                    <input type="number" class="cantidad-servicio w-full border px-3 py-2 rounded"
                           step="0.01" min="0" value="${datos ? datos.cantidad : 1}">
                </div>
            </div>
            <div class="mt-2 text-right text-emerald-600 font-bold">
                Subtotal: <span class="subtotal-servicio">$0.00</span>
            </div>
        </div>
    `;
    document.getElementById('servicios-list').insertAdjacentHTML('beforeend', html);
    lucide.createIcons();

    const container     = document.getElementById(rowId);
    const catSelect     = container.querySelector('.cat-servicio');
    const servSelect    = container.querySelector('.servicio-select');
    const provSelect    = container.querySelector('.prov-servicio-select');
    const cantidadInput = container.querySelector('.cantidad-servicio');
    const subtotalSpan  = container.querySelector('.subtotal-servicio');

    catSelect.addEventListener('change', async (e) => {
        const catId = e.target.value;
        servSelect.disabled = true;
        servSelect.innerHTML = '<option value="">Cargando...</option>';
        provSelect.disabled = true;
        provSelect.innerHTML = '<option value="">Elija servicio</option>';
        if (!catId) return;
        try {
            const servs = await fetchJSON(`/ajax/servicios-por-categoria/${catId}`);
            llenarSelect(servSelect, servs, 'Seleccione servicio', s => ({
                value: s.id,
                label: s.text
            }));
        } catch (err) {
            servSelect.innerHTML = '<option value="">Error al cargar</option>';
            console.error(err);
        }
    });

    servSelect.addEventListener('change', async (e) => {
        const servId = e.target.value;
        provSelect.disabled = true;
        provSelect.innerHTML = '<option value="">Cargando...</option>';
        if (!servId) return;
        try {
            const provs = await fetchJSON(`/ajax/proveedores-por-servicio/${servId}`);
            llenarSelect(provSelect, provs, 'Seleccione proveedor', p => ({
                value:   p.id,
                label:   `${p.text} - $${p.precio}`,
                dataset: { precio: p.precio, unidad: p.unidad ?? '' }
            }));
            calcularSubtotal();
        } catch (err) {
            provSelect.innerHTML = '<option value="">Error al cargar</option>';
            console.error(err);
        }
    });

    function calcularSubtotal() {
        const cantidad = parseFloat(cantidadInput.value) || 0;
        const precio   = parseFloat(provSelect.options[provSelect.selectedIndex]?.dataset?.precio) || 0;
        subtotalSpan.textContent = `$${(cantidad * precio).toFixed(2)}`;
        actualizarTotalesGenerales();
    }

    cantidadInput.addEventListener('input', calcularSubtotal);
    provSelect.addEventListener('change', calcularSubtotal);
}

// ================================================================
//  BOTONES AGREGAR
// ================================================================
document.getElementById('btnAgregarMaterial').addEventListener('click', () => agregarMaterialConDatos());
document.getElementById('btnAgregarServicio').addEventListener('click', () => agregarServicioConDatos());

// ================================================================
//  TOTALES GENERALES
// ================================================================
function actualizarTotalesGenerales() {
    let totalMateriales = 0;
    document.querySelectorAll('.existing-material-row').forEach(row => {
        totalMateriales += parseFloat(row.dataset.cantidad || 0) * parseFloat(row.dataset.precio || 0);
    });
    document.querySelectorAll('.material-item .subtotal-material').forEach(el => {
        totalMateriales += parseFloat(el.textContent.replace('$', '')) || 0;
    });

    let totalServicios = 0;
    document.querySelectorAll('.existing-servicio-row').forEach(row => {
        totalServicios += parseFloat(row.dataset.cantidad || 0) * parseFloat(row.dataset.precio || 0);
    });
    document.querySelectorAll('.servicio-item .subtotal-servicio').forEach(el => {
        totalServicios += parseFloat(el.textContent.replace('$', '')) || 0;
    });

    const costoEquipo   = parseFloat(document.getElementById('costo_equipo').value)    || 0;
    const gastosPercent = parseFloat(document.getElementById('gastos_generales').value) || 0;
    const margenPercent = parseFloat(document.getElementById('margen_ganancia').value)  || 0;

    const base      = totalMateriales + totalServicios + costoEquipo;
    const gastos    = base      * (gastosPercent / 100);
    const conGastos = base      + gastos;
    const margen    = conGastos * (margenPercent / 100);
    const total     = conGastos + margen;

    document.getElementById('sumMateriales').innerText   = `$${totalMateriales.toFixed(2)}`;
    document.getElementById('sumServicios').innerText    = `$${totalServicios.toFixed(2)}`;
    document.getElementById('subtotalGeneral').innerText = `$${(totalMateriales + totalServicios).toFixed(2)}`;
    document.getElementById('montoGastos').innerText     = `$${gastos.toFixed(2)}`;
    document.getElementById('montoMargen').innerText     = `$${margen.toFixed(2)}`;
    document.getElementById('totalFinal').innerText      = `$${total.toFixed(2)}`;
}

['costo_equipo', 'gastos_generales', 'margen_ganancia'].forEach(id => {
    document.getElementById(id).addEventListener('input', actualizarTotalesGenerales);
});

// ================================================================
//  SUBMIT — combina existentes (data-* del DOM) + nuevos dinámicos
// ================================================================
document.getElementById('cotizacionForm').addEventListener('submit', function () {
    const materiales = [];
    nombreProyectoInput.disabled = false;
    clienteSelect.disabled = false;

    // 1. Materiales existentes (tabla con clase existing-material-row)
    document.querySelectorAll('.existing-material-row').forEach(row => {
        materiales.push({
            abastecimiento_id: row.dataset.abastecimientoId,
            cantidad: row.dataset.cantidad
        });
    });

    // 2. Materiales nuevos (filas dinámicas)
    document.querySelectorAll('.material-item').forEach(row => {
        const provSelect = row.querySelector('.proveedor-select');
        const cantidad   = row.querySelector('.cantidad-material').value;
        if (provSelect && provSelect.value) {
            materiales.push({
                abastecimiento_id: provSelect.value,
                cantidad: cantidad
            });
        }
    });

    const servicios = [];

    // 3. Servicios existentes (tabla con clase existing-servicio-row)
    document.querySelectorAll('.existing-servicio-row').forEach(row => {
        servicios.push({
            mano_obra_id: row.dataset.manoObraId,
            cantidad: row.dataset.cantidad,
            precio_unitario: row.dataset.precio
        });
    });

    // 4. Servicios nuevos (filas dinámicas)
    document.querySelectorAll('.servicio-item').forEach(row => {
        const provSelect = row.querySelector('.prov-servicio-select');
        const cantidad   = row.querySelector('.cantidad-servicio').value;
        if (provSelect && provSelect.value) {
            servicios.push({
                mano_obra_id: provSelect.value,
                cantidad: cantidad,
                precio_unitario: provSelect.options[provSelect.selectedIndex]?.dataset?.precio || 0
            });
        }
    });

    document.getElementById('materiales_json').value = JSON.stringify(materiales);
    document.getElementById('servicios_json').value = JSON.stringify(servicios);
});

// Calcular totales iniciales (incluye las filas estáticas ya renderizadas)
actualizarTotalesGenerales();
</script>
</body>
</html>