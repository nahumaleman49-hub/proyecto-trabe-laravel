<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($proveedor) ? 'Editar Proveedor' : 'Nuevo Proveedor' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-50">

<div class="min-h-screen pb-12">
    <div class="relative h-64 overflow-hidden bg-gradient-to-r from-slate-700 to-slate-800">
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white">
                <i data-lucide="truck" class="w-16 h-16 mx-auto mb-4"></i>
                <h1 class="text-5xl font-bold mb-2">{{ isset($proveedor) ? 'Editar Proveedor' : 'Nuevo Proveedor' }}</h1>
                <p class="text-xl text-slate-300">{{ isset($proveedor) ? 'Actualiza la información del proveedor' : 'Registra un nuevo proveedor' }}</p>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8 max-w-4xl">
        @if(session('success'))
            <div class="mb-4 bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <a href="{{ route('proveedores') }}" class="inline-flex items-center text-slate-600 hover:text-slate-800 transition-colors mb-8">
            <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i>
            Volver a Proveedores
        </a>

        <div class="bg-white rounded-2xl p-8 shadow-lg">
            <form action="{{ isset($proveedor) ? route('proveedores.actualizar', $proveedor->ID_proveedor) : route('proveedores.guardar') }}" method="POST">
                @csrf
                @if(isset($proveedor)) @method('PUT') @endif

                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-slate-700 font-semibold mb-2">Nombre de la Empresa / Proveedor *</label>
                            <input type="text" name="nombre" value="{{ old('nombre', $proveedor->nombre ?? '') }}" 
                                   class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-500"
                                   required maxlength="50">
                            @error('nombre') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-slate-700 font-semibold mb-2">Tipo de Proveedor *</label>
                            <select name="tipo" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-500" required>
                                <option value="" disabled {{ !isset($proveedor) ? 'selected' : '' }}>Seleccione...</option>
                                <option value="Materiales" {{ old('tipo', $proveedor->tipo ?? '') == 'Materiales' ? 'selected' : '' }}>Materiales</option>
                                <option value="Servicios" {{ old('tipo', $proveedor->tipo ?? '') == 'Servicios' ? 'selected' : '' }}>Servicios (Mano de obra)</option>
                                <option value="Ambos" {{ old('tipo', $proveedor->tipo ?? '') == 'Ambos' ? 'selected' : '' }}>Ambos</option>
                            </select>
                            @error('tipo') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-slate-700 font-semibold mb-2">Nombre de Contacto *</label>
                        <input type="text" name="nombre_contacto" value="{{ old('nombre_contacto', $proveedor->nombre_contacto ?? '') }}" 
                               class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-500"
                               required maxlength="50">
                        @error('nombre_contacto') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-slate-700 font-semibold mb-2">Teléfono *</label>
                            <input type="tel" name="telefono" value="{{ old('telefono', $proveedor->telefono ?? '') }}" 
                                   class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-500"
                                   required>
                            @error('telefono') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-slate-700 font-semibold mb-2">Correo Electrónico *</label>
                            <input type="email" name="correo_e" value="{{ old('correo_e', $proveedor->correo_e ?? '') }}" 
                                   class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-500"
                                   required>
                            @error('correo_e') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-slate-700 font-semibold mb-2">Dirección *</label>
                        <textarea name="direccion" rows="3" 
                                  class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-500"
                                  required maxlength="80">{{ old('direccion', $proveedor->direccion ?? '') }}</textarea>
                        @error('direccion') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mt-8 flex gap-4">
                    <button type="submit" class="inline-flex items-center gap-2 bg-gradient-to-r from-slate-700 to-slate-800 text-white px-8 py-3 rounded-lg hover:shadow-lg transition-shadow">
                        <i data-lucide="save" class="w-5 h-5"></i>
                        {{ isset($proveedor) ? 'Actualizar Proveedor' : 'Guardar Proveedor' }}
                    </button>
                    <a href="{{ route('proveedores') }}" class="px-8 py-3 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition-colors flex items-center">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
        @if(isset($proveedor) && in_array($proveedor->tipo, ['Materiales', 'Ambos']))
            <div class="mt-12 bg-white rounded-2xl p-8 shadow-xl border border-slate-100">
                <h3 class="text-2xl font-bold text-slate-800 mb-6 flex items-center">
                    <i data-lucide="package" class="w-6 h-6 mr-3 text-indigo-500"></i>
                    Catálogo de Materiales de {{ $proveedor->nombre }}
                </h3>

                <form action="{{ route('proveedores.vincularMaterial') }}" method="POST" class="bg-slate-50 p-6 rounded-xl border border-slate-200 mb-8">
                    @csrf
                    <input type="hidden" name="fk_id_proveedor" value="{{ $proveedor->ID_proveedor }}">
                    
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Seleccionar Material</label>
                            <div class="flex gap-2">
                                <select name="fk_id_material" id="select_materiales" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                    <option value="" disabled selected>Buscar material...</option>
                                    @foreach($materiales as $mat)
                                        <option value="{{ $mat->ID_Material }}">{{ $mat->nombre }} ({{ $mat->codigo }})</option>
                                    @endforeach
                                </select>
                                
                                <button type="button" onclick="abrirModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg flex-shrink-0 transition-colors flex items-center" title="Crear Material Nuevo">
                                    <i data-lucide="plus" class="w-5 h-5 mr-1"></i> Nuevo
                                </button>
                            </div>
                        </div>
                        
                        <div class="md:col-span-1">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Precio de Compra ($)</label>
                            <input type="number" step="0.01" name="precio" required placeholder="0.00" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                        </div>

                        <div class="md:col-span-1">
                            <button type="submit" class="w-full bg-emerald-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-emerald-700 transition-colors flex items-center justify-center">
                                <i data-lucide="link" class="w-4 h-4 mr-2"></i> Vincular
                            </button>
                        </div>
                    </div>
                </form>

                <div class="overflow-x-auto rounded-lg border border-slate-200">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-100 text-slate-600 text-sm uppercase tracking-wider">
                                <th class="py-3 px-4 font-bold border-b">Código</th>
                                <th class="py-3 px-4 font-bold border-b">Material</th>
                                <th class="py-3 px-4 font-bold border-b">Medida</th>
                                <th class="py-3 px-4 font-bold border-b text-right">Precio Actual</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($proveedor->abastecimientos as $abastecimiento)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="py-3 px-4 text-slate-500">{{ $abastecimiento->material->codigo }}</td>
                                <td class="py-3 px-4 font-semibold text-slate-800">{{ $abastecimiento->material->nombre }}</td>
                                <td class="py-3 px-4 text-slate-600">{{ $abastecimiento->material->medidas }}</td>
                                <td class="py-3 px-4 text-emerald-600 font-bold text-right">${{ number_format($abastecimiento->precio, 2) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-slate-500">
                                    Este proveedor aún no tiene materiales asignados.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="modalMaterial" class="fixed inset-0 bg-slate-900 bg-opacity-60 hidden items-center justify-center z-50 transition-opacity backdrop-blur-sm">
                <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-lg mx-4 transform scale-100 transition-transform">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-slate-800">Crear Material Rápido</h2>
                        <button onclick="cerrarModal()" class="text-slate-400 hover:text-red-500 transition-colors">
                            <i data-lucide="x" class="w-6 h-6"></i>
                        </button>
                    </div>
                    
                    <div id="modalErrores" class="hidden bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded mb-6 text-sm"></div>

                    <form id="formMaterialRapido">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nombre del Material</label>
                            <input type="text" name="nombre" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" required>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Código</label>
                                <input type="text" name="codigo" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Medida/Unidad</label>
                                <input type="text" name="medidas" placeholder="Ej. Pza, Kg, Mt" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" required>
                            </div>
                        </div>

                        <div class="mb-8">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Categoría</label>
                            <select name="fk_id_categoria" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" required>
                                <option value="">Seleccione...</option>
                                @foreach($categorias as $cat)
                                    <option value="{{ $cat->ID_Categoria }}">{{ $cat->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex justify-end gap-3 border-t border-slate-100 pt-6">
                            <button type="button" onclick="cerrarModal()" class="px-6 py-2 bg-slate-100 text-slate-700 rounded-lg font-bold hover:bg-slate-200 transition-colors">Cancelar</button>
                            <button type="button" onclick="guardarMaterialModal()" class="px-6 py-2 bg-indigo-600 text-white rounded-lg font-bold hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-200 flex items-center" id="btnGuardarModal">
                                Guardar y Seleccionar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif
    </div>
</div>

<script>
    // Inicializar Iconos
    lucide.createIcons();

    // LÓGICA DEL MODAL (Solo se carga si el modal existe en el DOM)
    if(document.getElementById('modalMaterial')) {
        const modal = document.getElementById('modalMaterial');
        const formularioModal = document.getElementById('formMaterialRapido');
        const cajaErrores = document.getElementById('modalErrores');
        const btnGuardar = document.getElementById('btnGuardarModal');
        const selectorMateriales = document.getElementById('select_materiales');

        function abrirModal() {
            formularioModal.reset();
            cajaErrores.classList.add('hidden');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function cerrarModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        async function guardarMaterialModal() {
            btnGuardar.disabled = true;
            btnGuardar.innerHTML = '<i data-lucide="loader-2" class="w-5 h-5 mr-2 animate-spin"></i> Guardando...';
            lucide.createIcons();
            cajaErrores.classList.add('hidden');

            let formData = new FormData(formularioModal);

            try {
                let respuesta = await fetch("{{ route('materiales.guardarRapido') }}", {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                let datos = await respuesta.json();

                if (respuesta.ok && datos.success) {
                    cerrarModal();
                    
                    // Agregar la nueva opción al select de materiales
                    let nuevaOpcion = new Option(`${datos.material.nombre} (Nuevo)`, datos.material.id, true, true);
                    selectorMateriales.add(nuevaOpcion);
                    
                    // Resaltar visualmente el select para que el usuario note el cambio
                    selectorMateriales.classList.add('ring-2', 'ring-emerald-500', 'border-emerald-500');
                    setTimeout(() => {
                        selectorMateriales.classList.remove('ring-2', 'ring-emerald-500', 'border-emerald-500');
                    }, 2000);

                } else {
                    let mensajeError = datos.mensaje || "Revisa los campos.";
                    if(datos.errores) {
                        mensajeError += "<ul class='list-disc ml-5 mt-2'>";
                        for (let campo in datos.errores) {
                            mensajeError += `<li>${datos.errores[campo][0]}</li>`;
                        }
                        mensajeError += "</ul>";
                    }
                    mostrarErrores(mensajeError);
                }
            } catch (error) {
                mostrarErrores("Error de conexión con el servidor. " + error);
            } finally {
                btnGuardar.disabled = false;
                btnGuardar.innerHTML = 'Guardar y Seleccionar';
            }
        }

        function mostrarErrores(mensaje) {
            cajaErrores.innerHTML = mensaje;
            cajaErrores.classList.remove('hidden');
        }
    }
</script>
</body>
</html>