<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($cotizacion) ? 'Editar Cotización' : 'Nueva Cotización' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-slate-50">

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
    <form id="cotizacionForm" method="POST" action="{{ isset($cotizacion) ? route('cotizaciones.actualizar', $cotizacion->ID_cotizacion) : route('cotizaciones.guardar') }}">
        @csrf
        @if(isset($cotizacion)) @method('PUT') @endif

        <input type="hidden" name="materiales_json" id="materiales_json">
        <input type="hidden" name="servicios_json" id="servicios_json">

        {{-- 1. Datos del proyecto y cliente --}}
        <div class="bg-white rounded-2xl p-8 shadow-lg mb-6">
            <h2 class="text-2xl font-bold mb-4">Proyecto y Cliente</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block font-semibold mb-2">Nombre del Proyecto *</label>
                    <input type="text" name="nombre_proyecto" id="nombre_proyecto" required class="w-full border rounded-lg px-4 py-2" value="{{ old('nombre_proyecto', $cotizacion->proyecto->nombre ?? '') }}">
                </div>
                <div>
                    <label class="block font-semibold mb-2">Cliente *</label>
                    <select name="cliente_id" id="cliente_id" required class="w-full border rounded-lg px-4 py-2">
                        <option value="">Seleccione cliente</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->ID_cliente }}" {{ (old('cliente_id', $cotizacion->proyecto->fk_id_cliente ?? '') == $cliente->ID_cliente) ? 'selected' : '' }}>
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
                    <input type="email" id="correo" readonly class="w-full border rounded-lg bg-gray-100 px-4 py-2">
                </div>
            </div>
        </div>

        {{-- 2. Materiales --}}
        <div class="bg-white rounded-2xl p-8 shadow-lg mb-6">
            <h2 class="text-2xl font-bold mb-4 flex justify-between items-center">
                Materiales
                <button type="button" id="btnAgregarMaterial" class="bg-slate-700 text-white px-4 py-2 rounded-lg text-sm flex items-center gap-2">
                    <i data-lucide="plus" class="w-4 h-4"></i> Agregar material
                </button>
            </h2>
            <div id="materiales-wrapper">
                <div class="grid grid-cols-1 gap-4" id="materiales-list"></div>
            </div>
        </div>

        {{-- 3. Servicios --}}
        <div class="bg-white rounded-2xl p-8 shadow-lg mb-6">
            <h2 class="text-2xl font-bold mb-4 flex justify-between items-center">
                Servicios (Mano de obra)
                <button type="button" id="btnAgregarServicio" class="bg-slate-700 text-white px-4 py-2 rounded-lg text-sm flex items-center gap-2">
                    <i data-lucide="plus" class="w-4 h-4"></i> Agregar servicio
                </button>
            </h2>
            <div id="servicios-wrapper">
                <div class="grid grid-cols-1 gap-4" id="servicios-list"></div>
            </div>
        </div>

        {{-- 4. Gastos generales y márgenes --}}
        <div class="bg-white rounded-2xl p-8 shadow-lg mb-6">
            <h2 class="text-2xl font-bold mb-4">Costos Adicionales</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block font-semibold mb-2">Costo de Equipo ($)</label>
                    <input type="number" name="costo_equipo" id="costo_equipo" value="{{ old('costo_equipo', $cotizacion->costo_equipo ?? 0) }}" step="0.01" class="w-full border rounded-lg px-4 py-2">
                </div>
                <div>
                    <label class="block font-semibold mb-2">Gastos Generales (%)</label>
                    <input type="number" name="gastos_generales" id="gastos_generales" value="{{ old('gastos_generales', $cotizacion->gastos_generales ?? 10) }}" step="0.1" class="w-full border rounded-lg px-4 py-2">
                </div>
                <div>
                    <label class="block font-semibold mb-2">Margen de Ganancia (%)</label>
                    <input type="number" name="margen_ganancia" id="margen_ganancia" value="{{ old('margen_ganancia', $cotizacion->margen_ganancia ?? 15) }}" step="0.1" class="w-full border rounded-lg px-4 py-2">
                </div>
            </div>
        </div>

        {{-- 5. Resumen --}}
        <div class="bg-gradient-to-br from-slate-100 to-slate-200 rounded-2xl p-8 shadow-lg">
            <h2 class="text-2xl font-bold mb-4">Resumen</h2>
            <div class="space-y-2 text-lg">
                <div class="flex justify-between"><span>Subtotal Materiales:</span><span id="sumMateriales">$0.00</span></div>
                <div class="flex justify-between"><span>Subtotal Servicios:</span><span id="sumServicios">$0.00</span></div>
                <div class="flex justify-between font-semibold"><span>Subtotal General:</span><span id="subtotalGeneral">$0.00</span></div>
                <div class="flex justify-between"><span>+ Gastos Generales:</span><span id="montoGastos">$0.00</span></div>
                <div class="flex justify-between"><span>+ Margen de Ganancia:</span><span id="montoMargen">$0.00</span></div>
                <div class="flex justify-between text-2xl font-bold pt-2 border-t"><span>Total Cotización:</span><span id="totalFinal">$0.00</span></div>
            </div>
        </div>

        <div class="flex justify-end gap-4 mt-8">
            <a href="{{ route('cotizaciones') }}" class="border border-slate-300 px-6 py-2 rounded-lg">Cancelar</a>
            <button type="submit" class="bg-slate-800 text-white px-6 py-2 rounded-lg">Guardar Cotización</button>
        </div>
    </form>
</div>

<script>
    lucide.createIcons();

    const clienteSelect = document.getElementById('cliente_id');
    const telefonoInput = document.getElementById('telefono');
    const correoInput = document.getElementById('correo');
    const clientesData = {!! json_encode($clientes->map(function($c) {
        return ['id' => $c->ID_cliente, 'telefono' => $c->telefono, 'correo' => $c->correo_e ?? ''];
        })->values()) !!};
    const categoriasMateriales = {!! json_encode($categoriasMateriales) !!};
    const categoriasServicios = {!! json_encode($categoriasServicios) !!};
    
    clienteSelect.addEventListener('change', function() {
        const selected = clientesData.find(c => c.id == this.value);
        if (selected) {
            telefonoInput.value = selected.telefono || '';
            correoInput.value = selected.correo || '';
        } else {
            telefonoInput.value = '';
            correoInput.value = '';
        }
    });

    let materialIndex = 0;
    let servicioIndex = 0;

    // ---- Materiales dinámicos ----
    function agregarMaterialConDatos(datos = null) {
        const rowId = `mat_${materialIndex++}`;
        const html = `
            <div class="material-item border p-4 rounded-lg relative bg-slate-50" id="${rowId}">
                <button type="button" class="absolute top-2 right-2 text-red-500 eliminar-material"><i data-lucide="x" class="w-4 h-4"></i></button>
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
                        <label class="block text-sm font-semibold">proveedor</label>
                        <select class="proveedor-select w-full border px-3 py-2 rounded" disabled>
                            <option value="">Primero elija material</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold">Cantidad</label>
                        <input type="number" class="cantidad-material w-full border px-3 py-2 rounded" step="0.01" min="0" value="${datos ? datos.cantidad : 1}">
                    </div>
                </div>
                <div class="mt-2 text-right text-emerald-600 font-bold">
                    Subtotal: <span class="subtotal-material">$0.00</span>
                </div>
            </div>
        `;
        document.getElementById('materiales-list').insertAdjacentHTML('beforeend', html);
        lucide.createIcons();

        const container = document.getElementById(rowId);
        const catSelect = container.querySelector('.categoria-material');
        const matSelect = container.querySelector('.material-select');
        const provSelect = container.querySelector('.proveedor-select');
        const cantidadInput = container.querySelector('.cantidad-material');
        const subtotalSpan = container.querySelector('.subtotal-material');

        catSelect.addEventListener('change', async (e) => {
            const catId = e.target.value;
            matSelect.disabled = true;
            matSelect.innerHTML = '<option value="">Cargando...</option>';
            provSelect.disabled = true;
            provSelect.innerHTML = '<option value="">Elija material</option>';
            if (!catId) return;
            const res = await fetch(`/ajax/materiales-por-categoria/${catId}`);
            const mats = await res.json();
            matSelect.disabled = false;
            matSelect.innerHTML = '<option value="">Seleccione material</option>';
            mats.forEach(m => {
                matSelect.innerHTML += `<option value="${m.id}" data-medidas="${m.medidas}">${m.text}</option>`;
            });
            if(datos && datos.material_id) matSelect.value = datos.material_id;
        });

        matSelect.addEventListener('change', async (e) => {
            const matId = e.target.value;
            provSelect.disabled = true;
            provSelect.innerHTML = '<option value="">Cargando...</option>';
            if (!matId) return;
            const res = await fetch(`/ajax/proveedores-por-material/${matId}`);
            const provs = await res.json();
            provSelect.disabled = false;
            provSelect.innerHTML = '<option value="">Seleccione proveedor</option>';
            provs.forEach(p => {
                // AQUÍ USAMOS ID_PROD como valor del option
                provSelect.innerHTML += `<option value="${p.id_prod}" data-precio="${p.precio}" data-proveedor-id="${p.id}">${p.text} - $${p.precio}</option>`;
            });
            if(datos && datos.proveedor_id) {
                // Buscar el option que tenga el proveedor_id original para asignar el ID_prod correcto
                const targetOption = Array.from(provSelect.options).find(opt => opt.dataset.proveedorId == datos.proveedor_id);
                if(targetOption) provSelect.value = targetOption.value;
            }
        });

        function calcularSubtotal() {
            const cantidad = parseFloat(cantidadInput.value) || 0;
            const selectedOption = provSelect.options[provSelect.selectedIndex];
            const precio = selectedOption?.dataset?.precio ? parseFloat(selectedOption.dataset.precio) : 0;
            const subtotal = cantidad * precio;
            subtotalSpan.textContent = `$${subtotal.toFixed(2)}`;
            actualizarTotalesGenerales();
        }

        cantidadInput.addEventListener('input', calcularSubtotal);
        provSelect.addEventListener('change', calcularSubtotal);

        if (datos) {
            catSelect.value = datos.categoria_id || '';
            catSelect.dispatchEvent(new Event('change'));
            setTimeout(() => {
                matSelect.dispatchEvent(new Event('change'));
                setTimeout(() => {
                    provSelect.dispatchEvent(new Event('change'));
                }, 400);
            }, 400);
        }
    }

    // ---- Servicios dinámicos ----
    function agregarServicioConDatos(datos = null) {
        const rowId = `serv_${servicioIndex++}`;
        const html = `
            <div class="servicio-item border p-4 rounded-lg relative bg-slate-50" id="${rowId}">
                <button type="button" class="absolute top-2 right-2 text-red-500 eliminar-servicio"><i data-lucide="x" class="w-4 h-4"></i></button>
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
                        <label class="block text-sm font-semibold">proveedor</label>
                        <select class="prov-servicio-select w-full border px-3 py-2 rounded" disabled>
                            <option value="">Primero elija servicio</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold">Cantidad</label>
                        <input type="number" class="cantidad-servicio w-full border px-3 py-2 rounded" step="0.01" min="0" value="${datos ? datos.cantidad : 1}">
                    </div>
                </div>
                <div class="mt-2 text-right text-emerald-600 font-bold">
                    Subtotal: <span class="subtotal-servicio">$0.00</span>
                </div>
            </div>
        `;
        document.getElementById('servicios-list').insertAdjacentHTML('beforeend', html);
        lucide.createIcons();

        const container = document.getElementById(rowId);
        const catSelect = container.querySelector('.cat-servicio');
        const servSelect = container.querySelector('.servicio-select');
        const provSelect = container.querySelector('.prov-servicio-select');
        const cantidadInput = container.querySelector('.cantidad-servicio');
        const subtotalSpan = container.querySelector('.subtotal-servicio');

        catSelect.addEventListener('change', async (e) => {
            const catId = e.target.value;
            servSelect.disabled = true;
            servSelect.innerHTML = '<option value="">Cargando...</option>';
            if (!catId) return;
            const res = await fetch(`/ajax/servicios-por-categoria/${catId}`);
            const servs = await res.json();
            servSelect.disabled = false;
            servSelect.innerHTML = '<option value="">Seleccione servicio</option>';
            servs.forEach(s => {
                servSelect.innerHTML += `<option value="${s.id}">${s.text}</option>`;
            });
            if(datos && datos.servicio_id) servSelect.value = datos.servicio_id;
        });

        servSelect.addEventListener('change', async (e) => {
            const servId = e.target.value;
            provSelect.disabled = true;
            provSelect.innerHTML = '<option value="">Cargando...</option>';
            if (!servId) return;
            const res = await fetch(`/ajax/proveedores-por-servicio/${servId}`);
            const provs = await res.json();
            provSelect.disabled = false;
            provSelect.innerHTML = '<option value="">Seleccione proveedor</option>';
            provs.forEach(p => {
                provSelect.innerHTML += `<option value="${p.id}" data-precio="${p.precio}">${p.text}</option>`;
            });
            if(datos && datos.mano_obra_id) provSelect.value = datos.mano_obra_id;
        });

        function calcularSubtotal() {
            const cantidad = parseFloat(cantidadInput.value) || 0;
            const selectedOption = provSelect.options[provSelect.selectedIndex];
            const precio = selectedOption?.dataset?.precio ? parseFloat(selectedOption.dataset.precio) : 0;
            const subtotal = cantidad * precio;
            subtotalSpan.textContent = `$${subtotal.toFixed(2)}`;
            actualizarTotalesGenerales();
        }

        cantidadInput.addEventListener('input', calcularSubtotal);
        provSelect.addEventListener('change', calcularSubtotal);

        if (datos) {
            catSelect.value = datos.categoria_id || '';
            catSelect.dispatchEvent(new Event('change'));
            setTimeout(() => {
                servSelect.dispatchEvent(new Event('change'));
                setTimeout(() => {
                    provSelect.dispatchEvent(new Event('change'));
                }, 400);
            }, 400);
        }
    }

    function actualizarTotalesGenerales() {
        let totalMateriales = 0;
        document.querySelectorAll('.material-item .subtotal-material').forEach(el => {
            totalMateriales += parseFloat(el.textContent.replace('$', '')) || 0;
        });
        let totalServicios = 0;
        document.querySelectorAll('.servicio-item .subtotal-servicio').forEach(el => {
            totalServicios += parseFloat(el.textContent.replace('$', '')) || 0;
        });
        const subtotal = totalMateriales + totalServicios;
        const costoEquipo = parseFloat(document.getElementById('costo_equipo').value) || 0;
        const gastosPercent = parseFloat(document.getElementById('gastos_generales').value) || 0;
        const margenPercent = parseFloat(document.getElementById('margen_ganancia').value) || 0;

        const base = subtotal + costoEquipo;
        const gastos = base * (gastosPercent / 100);
        const conGastos = base + gastos;
        const margen = conGastos * (margenPercent / 100);
        const total = conGastos + margen;

        document.getElementById('sumMateriales').innerText = `$${totalMateriales.toFixed(2)}`;
        document.getElementById('sumServicios').innerText = `$${totalServicios.toFixed(2)}`;
        document.getElementById('subtotalGeneral').innerText = `$${subtotal.toFixed(2)}`;
        document.getElementById('montoGastos').innerText = `$${gastos.toFixed(2)}`;
        document.getElementById('montoMargen').innerText = `$${margen.toFixed(2)}`;
        document.getElementById('totalFinal').innerText = `$${total.toFixed(2)}`;
    }

    document.getElementById('btnAgregarMaterial').addEventListener('click', () => agregarMaterialConDatos());
    document.getElementById('btnAgregarServicio').addEventListener('click', () => agregarServicioConDatos());
    
    document.addEventListener('click', function(e) {
        if (e.target.closest('.eliminar-material')) {
            e.target.closest('.material-item').remove();
            actualizarTotalesGenerales();
        }
        if (e.target.closest('.eliminar-servicio')) {
            e.target.closest('.servicio-item').remove();
            actualizarTotalesGenerales();
        }
    });

    ['costo_equipo', 'gastos_generales', 'margen_ganancia'].forEach(id => {
        document.getElementById(id).addEventListener('input', actualizarTotalesGenerales);
    });

    // Carga inicial en edición
    @if(isset($materialesExistentes))
        @foreach($materialesExistentes as $mat)
            agregarMaterialConDatos({!! json_encode($mat) !!});
        @endforeach
    @endif
    @if(isset($serviciosExistentes))
        @foreach($serviciosExistentes as $serv)
            agregarServicioConDatos({!! json_encode($serv) !!});
        @endforeach
    @endif

    document.getElementById('cotizacionForm').addEventListener('submit', function(e) {
        const materiales = [];
        document.querySelectorAll('.material-item').forEach(row => {
            const matSelect = row.querySelector('.material-select');
            const provSelect = row.querySelector('.proveedor-select');
            const cantidad = row.querySelector('.cantidad-material').value;
            if (matSelect.value && provSelect.value) {
                materiales.push({
                    material_id: matSelect.value,
                    proveedor_id: provSelect.options[provSelect.selectedIndex].dataset.proveedorId,
                    id_prod: provSelect.value, // ENVIAMOS ID_PROD
                    cantidad: cantidad
                });
            }
        });

        const servicios = [];
        document.querySelectorAll('.servicio-item').forEach(row => {
            const servSelect = row.querySelector('.servicio-select');
            const provSelect = row.querySelector('.prov-servicio-select');
            const cantidad = row.querySelector('.cantidad-servicio').value;
            if (servSelect.value && provSelect.value) {
                servicios.push({
                    mano_obra_id: provSelect.value, // Es el ID de la tabla manoobra
                    cantidad: cantidad,
                    precio_unitario: provSelect.options[provSelect.selectedIndex].dataset.precio
                });
            }
        });

        document.getElementById('materiales_json').value = JSON.stringify(materiales);
        document.getElementById('servicios_json').value = JSON.stringify(servicios);
    });
</script>
</body>
</html>