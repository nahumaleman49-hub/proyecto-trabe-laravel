<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QOSTO - Nueva Cotización</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-50">

    <div class="bg-gradient-to-r from-slate-700 to-slate-800 text-white py-12">
        <div class="container mx-auto px-4">
            <a href="{{ route('cotizaciones') }}" class="inline-flex items-center text-white hover:text-slate-200 transition-colors mb-4">
                <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i>
                Volver a Cotizaciones
            </a>
            <div class="flex items-center gap-4">
                <i data-lucide="file-text" class="w-12 h-12"></i>
                <div>
                    <h1 class="text-4xl font-bold">Crear Nueva Cotización</h1>
                    <p class="text-slate-300">Completa los detalles para generar una cotización del proyecto</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <form id="quoteForm" class="max-w-6xl mx-auto">
            @csrf

            {{-- Información del Proyecto --}}
            <div class="bg-white rounded-2xl p-8 shadow-lg mb-6">
                <h2 class="text-2xl font-bold text-slate-800 mb-6">Información del Proyecto</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nombre del Proyecto *</label>
                        <input type="text" name="projectName" id="projectName" required class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent" placeholder="ej., Renovación de Cocina">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Tipo de Proyecto *</label>
                        <select name="projectType" id="projectType" required class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent">
                            <option value="">Seleccionar tipo</option>
                            <option value="Residencial">Residencial</option>
                            <option value="Comercial">Comercial</option>
                            <option value="Industrial">Industrial</option>
                            <option value="Renovación">Renovación</option>
                            <option value="Construcción Nueva">Construcción Nueva</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Ubicación del Proyecto *</label>
                        <input type="text" name="projectLocation" id="projectLocation" required class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent" placeholder="Dirección o ubicación">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Fecha de Inicio</label>
                            <input type="date" name="startDate" id="startDate" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Fecha de Fin</label>
                            <input type="date" name="endDate" id="endDate" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent">
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Descripción del Proyecto</label>
                        <textarea name="description" id="description" rows="4" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent" placeholder="Describe el alcance y requisitos del proyecto..."></textarea>
                    </div>
                </div>
            </div>

            {{-- Información del Cliente --}}
            <div class="bg-white rounded-2xl p-8 shadow-lg mb-6">
                <h2 class="text-2xl font-bold text-slate-800 mb-6">Información del Cliente</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nombre del Cliente *</label>
                        <input type="text" name="clientName" id="clientName" required class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent" placeholder="Nombre completo o empresa">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Correo Electrónico *</label>
                        <input type="email" name="clientEmail" id="clientEmail" required class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent" placeholder="cliente@ejemplo.com">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Número de Teléfono</label>
                        <input type="tel" name="clientPhone" id="clientPhone" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent" placeholder="+52 (555) 000-0000">
                    </div>
                </div>
            </div>

            {{-- Lista de Materiales --}}
            <div class="bg-white rounded-2xl p-8 shadow-lg mb-6">
                <h2 class="text-2xl font-bold text-slate-800 mb-6">Lista de Materiales</h2>

                <div class="bg-slate-50 rounded-lg p-6 mb-4">
                    <h3 class="font-semibold text-slate-700 mb-4">Agregar Material</h3>
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-4">
                        <select id="materialCategoria" class="px-4 py-2 border border-slate-300 rounded-lg">
                            <option value="">Categoría</option>
                            <option value="Estructurales">Estructurales</option>
                            <option value="Albañilería">Albañilería</option>
                            <option value="Acabados">Acabados</option>
                            <option value="Instalaciones">Instalaciones</option>
                        </select>
                        <input type="text" id="materialNombre" placeholder="Nombre del material" class="px-4 py-2 border border-slate-300 rounded-lg">
                        <input type="number" id="materialCantidad" placeholder="Cantidad" class="px-4 py-2 border border-slate-300 rounded-lg">
                        <input type="text" id="materialUnidad" placeholder="Unidad (m², kg, pza)" class="px-4 py-2 border border-slate-300 rounded-lg">
                        <input type="number" id="materialPrecioUnitario" placeholder="Precio unitario" class="px-4 py-2 border border-slate-300 rounded-lg">
                    </div>
                    <button type="button" id="addMaterialBtn" class="flex items-center gap-2 bg-slate-700 text-white px-6 py-2 rounded-lg hover:bg-slate-800 transition-colors">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        Agregar Material
                    </button>
                </div>

                <div id="materialsTableContainer" class="overflow-x-auto hidden">
                    <table class="w-full" id="materialsTable">
                        <thead>
                            <tr class="border-b-2 border-slate-200">
                                <th class="text-left py-3 px-2 text-slate-700 font-semibold">Categoría</th>
                                <th class="text-left py-3 px-2 text-slate-700 font-semibold">Material</th>
                                <th class="text-right py-3 px-2 text-slate-700 font-semibold">Cantidad</th>
                                <th class="text-left py-3 px-2 text-slate-700 font-semibold">Unidad</th>
                                <th class="text-right py-3 px-2 text-slate-700 font-semibold">Precio Unit.</th>
                                <th class="text-right py-3 px-2 text-slate-700 font-semibold">Subtotal</th>
                                <th class="py-3 px-2"></th>
                            </tr>
                        </thead>
                        <tbody id="materialsTableBody"></tbody>
                    </table>
                </div>
                <div id="noMaterialsMessage" class="text-center py-4 text-slate-500">No hay materiales agregados.</div>
            </div>

            {{-- Desglose de Costos --}}
            <div class="bg-white rounded-2xl p-8 shadow-lg mb-6">
                <h2 class="text-2xl font-bold text-slate-800 mb-6">Desglose de Costos</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Costo de Mano de Obra ($) *</label>
                        <input type="number" name="labourCost" id="labourCost" required min="0" step="0.01" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent" placeholder="0.00">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Costo de Materiales ($) *</label>
                        <input type="number" name="materialsCost" id="materialsCost" required min="0" step="0.01" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent" placeholder="0.00">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Costo de Equipo ($)</label>
                        <input type="number" name="equipmentCost" id="equipmentCost" min="0" step="0.01" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent" placeholder="0.00">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Gastos Generales (%)</label>
                        <input type="number" name="overheadPercentage" id="overheadPercentage" min="0" step="0.1" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent" placeholder="10">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Margen de Ganancia (%)</label>
                        <input type="number" name="profitMargin" id="profitMargin" min="0" step="0.1" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent" placeholder="15">
                    </div>
                </div>
            </div>

            {{-- Resumen de Cotización --}}
            <div class="bg-gradient-to-br from-slate-50 to-slate-100 rounded-2xl p-8 shadow-lg mb-6">
                <h2 class="text-2xl font-bold text-slate-800 mb-6">Resumen de Cotización</h2>
                <div class="space-y-3">
                    <div class="flex justify-between items-center text-lg">
                        <span class="text-slate-700">Subtotal:</span>
                        <span class="font-semibold text-slate-800" id="subtotal">$0.00</span>
                    </div>
                    <div class="flex justify-between items-center text-lg">
                        <span class="text-slate-700">Gastos Generales:</span>
                        <span class="font-semibold text-slate-800" id="overhead">$0.00</span>
                    </div>
                    <div class="flex justify-between items-center text-lg">
                        <span class="text-slate-700">Ganancia:</span>
                        <span class="font-semibold text-slate-800" id="profit">$0.00</span>
                    </div>
                    <div class="border-t-2 border-slate-300 pt-3 mt-3">
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-slate-800">Total de Cotización:</span>
                            <span class="text-3xl font-bold text-slate-700" id="total">$0.00</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex gap-4 justify-end">
                <a href="{{ route('cotizaciones') }}" class="px-8 py-3 border-2 border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition-colors inline-block text-center">Cancelar</a>
                <button type="submit" id="submitBtn" class="flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-slate-700 to-slate-800 text-white rounded-lg hover:shadow-lg transition-shadow">
                    <i data-lucide="save" class="w-5 h-5"></i>
                    Generar Cotización
                </button>
            </div>
        </form>
    </div>

    <script>
        // Materiales list (array)
        let materials = [];

        // Elementos DOM
        const materialsTableBody = document.getElementById('materialsTableBody');
        const materialsTableContainer = document.getElementById('materialsTableContainer');
        const noMaterialsMessage = document.getElementById('noMaterialsMessage');
        const addMaterialBtn = document.getElementById('addMaterialBtn');

        // Función para actualizar tabla de materiales
        function updateMaterialsTable() {
            if (materials.length === 0) {
                materialsTableContainer.classList.add('hidden');
                noMaterialsMessage.classList.remove('hidden');
                return;
            }
            materialsTableContainer.classList.remove('hidden');
            noMaterialsMessage.classList.add('hidden');

            let html = '';
            materials.forEach((item, idx) => {
                const subtotal = item.cantidad * item.precioUnitario;
                html += `
                    <tr class="border-b border-slate-100">
                        <td class="py-3 px-2 text-slate-600">${escapeHtml(item.categoria)}</td>
                        <td class="py-3 px-2 text-slate-800">${escapeHtml(item.material)}</td>
                        <td class="py-3 px-2 text-right text-slate-800">${item.cantidad}</td>
                        <td class="py-3 px-2 text-slate-600">${escapeHtml(item.unidad)}</td>
                        <td class="py-3 px-2 text-right text-slate-800">$${formatNumber(item.precioUnitario)}</td>
                        <td class="py-3 px-2 text-right font-semibold text-slate-800">$${formatNumber(subtotal)}</td>
                        <td class="py-3 px-2 text-center">
                            <button type="button" class="text-red-600 hover:text-red-800 remove-material" data-index="${idx}">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
            materialsTableBody.innerHTML = html;

            // Recrear íconos en los botones de eliminar
            lucide.createIcons();

            // Agregar event listeners a los botones de eliminar
            document.querySelectorAll('.remove-material').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const index = parseInt(btn.getAttribute('data-index'));
                    materials.splice(index, 1);
                    updateMaterialsTable();
                    updateTotals(); // Actualizar totales ya que materiales afectan el subtotal
                });
            });
        }

        // Agregar material
        addMaterialBtn.addEventListener('click', () => {
            const categoria = document.getElementById('materialCategoria').value;
            const material = document.getElementById('materialNombre').value.trim();
            const cantidad = parseFloat(document.getElementById('materialCantidad').value);
            const unidad = document.getElementById('materialUnidad').value.trim();
            const precioUnitario = parseFloat(document.getElementById('materialPrecioUnitario').value);

            if (!material || isNaN(cantidad) || cantidad <= 0 || isNaN(precioUnitario) || precioUnitario <= 0) {
                alert('Por favor completa todos los campos del material (nombre, cantidad >0, precio unitario >0)');
                return;
            }

            materials.push({
                categoria: categoria || 'General',
                material: material,
                cantidad: cantidad,
                unidad: unidad || 'pza',
                precioUnitario: precioUnitario
            });

            // Limpiar campos
            document.getElementById('materialCategoria').value = '';
            document.getElementById('materialNombre').value = '';
            document.getElementById('materialCantidad').value = '';
            document.getElementById('materialUnidad').value = '';
            document.getElementById('materialPrecioUnitario').value = '';

            updateMaterialsTable();
            updateTotals(); // Actualizar totales
        });

        // Calcular totales (subtotal, overhead, profit, total)
        function calculateTotals() {
            const labourCost = parseFloat(document.getElementById('labourCost').value) || 0;
            const materialsCost = parseFloat(document.getElementById('materialsCost').value) || 0;
            const equipmentCost = parseFloat(document.getElementById('equipmentCost').value) || 0;
            const overheadPercent = parseFloat(document.getElementById('overheadPercentage').value) || 0;
            const profitPercent = parseFloat(document.getElementById('profitMargin').value) || 0;

            // Calcular subtotal de materiales manualmente (si se usan materiales)
            let materialsListTotal = materials.reduce((sum, m) => sum + (m.cantidad * m.precioUnitario), 0);
            // Si el usuario también ingresó un valor en materialsCost, podemos sumarlo o reemplazarlo? 
            // Por simplicidad, usaremos el valor de materiales del formulario y sumaremos el total de la lista.
            const finalMaterialsCost = materialsCost + materialsListTotal;

            const subtotal = labourCost + finalMaterialsCost + equipmentCost;
            const overhead = subtotal * (overheadPercent / 100);
            const withOverhead = subtotal + overhead;
            const profit = withOverhead * (profitPercent / 100);
            const total = withOverhead + profit;

            return { subtotal, overhead, profit, total, finalMaterialsCost };
        }

        function updateTotals() {
            const totals = calculateTotals();
            document.getElementById('subtotal').textContent = `$${formatNumber(totals.subtotal)}`;
            document.getElementById('overhead').textContent = `$${formatNumber(totals.overhead)}`;
            document.getElementById('profit').textContent = `$${formatNumber(totals.profit)}`;
            document.getElementById('total').textContent = `$${formatNumber(totals.total)}`;
        }

        // Escuchar cambios en campos de costos
        const costInputs = ['labourCost', 'materialsCost', 'equipmentCost', 'overheadPercentage', 'profitMargin'];
        costInputs.forEach(id => {
            document.getElementById(id).addEventListener('input', updateTotals);
        });

        // Envío del formulario vía AJAX
        const quoteForm = document.getElementById('quoteForm');
        quoteForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            // Recolectar datos del formulario
            const formData = {
                projectName: document.getElementById('projectName').value,
                projectType: document.getElementById('projectType').value,
                projectLocation: document.getElementById('projectLocation').value,
                startDate: document.getElementById('startDate').value,
                endDate: document.getElementById('endDate').value,
                description: document.getElementById('description').value,
                clientName: document.getElementById('clientName').value,
                clientEmail: document.getElementById('clientEmail').value,
                clientPhone: document.getElementById('clientPhone').value,
                labourCost: parseFloat(document.getElementById('labourCost').value) || 0,
                materialsCost: parseFloat(document.getElementById('materialsCost').value) || 0,
                equipmentCost: parseFloat(document.getElementById('equipmentCost').value) || 0,
                overheadPercentage: parseFloat(document.getElementById('overheadPercentage').value) || 0,
                profitMargin: parseFloat(document.getElementById('profitMargin').value) || 0,
                materialsList: materials
            };

            // Validaciones básicas
            if (!formData.projectName || !formData.projectType || !formData.projectLocation || !formData.clientName || !formData.clientEmail) {
                alert('Por favor completa todos los campos obligatorios (*).');
                return;
            }

            // Enviar al servidor (simulado, pero crearemos una ruta POST)
            try {
                const response = await fetch('{{ route("cotizaciones.guardar") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify(formData)
                });

                if (response.ok) {
                    const data = await response.json();
                    // Redirigir a la página de selección de vistas
                    window.location.href = data.redirect_url;
                } else {
                    const error = await response.json();
                    alert('Error al guardar la cotización: ' + (error.message || 'Error desconocido'));
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error de conexión. Intenta de nuevo.');
            }
        });

        // Helper: escape HTML
        function escapeHtml(str) {
            if (!str) return '';
            return str.replace(/[&<>]/g, function(m) {
                if (m === '&') return '&amp;';
                if (m === '<') return '&lt;';
                if (m === '>') return '&gt;';
                return m;
            });
        }

        function formatNumber(num) {
            return num.toLocaleString('es-MX', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }

        // Inicializar íconos de Lucide
        lucide.createIcons();
    </script>
</body>
</html>