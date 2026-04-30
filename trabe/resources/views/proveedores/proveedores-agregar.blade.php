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
                <p class="text-xl text-slate-300">{{ isset($proveedor) ? $proveedor->nombre : 'Registra un nuevo proveedor' }}</p>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8 max-w-5xl">
        @if(session('success'))
            <div class="mb-4 bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded relative shadow-sm" role="alert">
                <span class="block sm:inline font-medium">{{ session('success') }}</span>
            </div>
        @endif
        
        @if($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative shadow-sm">
                <ul class="list-disc ml-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <a href="{{ route('proveedores') }}" class="inline-flex items-center text-slate-600 hover:text-slate-800 transition-colors mb-8 font-medium">
            <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i>
            Volver a Proveedores
        </a>

        <div class="bg-white rounded-2xl p-8 shadow-lg mb-8 border border-slate-100">
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
                        </div>

                        <div>
                            <label class="block text-slate-700 font-semibold mb-2">Tipo de Proveedor *</label>
                            <select name="tipo" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-500" required>
                                <option value="" disabled {{ !isset($proveedor) ? 'selected' : '' }}>Seleccione...</option>
                                <option value="Materiales" {{ old('tipo', $proveedor->tipo ?? '') == 'Materiales' ? 'selected' : '' }}>Materiales</option>
                                <option value="Servicios" {{ old('tipo', $proveedor->tipo ?? '') == 'Servicios' ? 'selected' : '' }}>Servicios (Mano de obra)</option>
                                <option value="Ambos" {{ old('tipo', $proveedor->tipo ?? '') == 'Ambos' ? 'selected' : '' }}>Ambos</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-1">
                            <label class="block text-slate-700 font-semibold mb-2">Nombre de Contacto *</label>
                            <input type="text" name="nombre_contacto" value="{{ old('nombre_contacto', $proveedor->nombre_contacto ?? '') }}" 
                                   class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-500"
                                   required maxlength="50">
                        </div>
                        <div>
                            <label class="block text-slate-700 font-semibold mb-2">Teléfono *</label>
                            <input type="tel" name="telefono" value="{{ old('telefono', $proveedor->telefono ?? '') }}" 
                                   class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-500"
                                   required>
                        </div>
                        <div>
                            <label class="block text-slate-700 font-semibold mb-2">Correo Electrónico *</label>
                            <input type="email" name="correo_e" value="{{ old('correo_e', $proveedor->correo_e ?? '') }}" 
                                   class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-500"
                                   required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-slate-700 font-semibold mb-2">Dirección *</label>
                        <textarea name="direccion" rows="2" 
                                  class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-500"
                                  required maxlength="80">{{ old('direccion', $proveedor->direccion ?? '') }}</textarea>
                    </div>
                </div>

                <div class="mt-8 flex gap-4 border-t pt-6">
                    <button type="submit" class="inline-flex items-center gap-2 bg-gradient-to-r from-slate-700 to-slate-800 text-white px-8 py-3 rounded-lg hover:shadow-lg transition-shadow font-semibold">
                        <i data-lucide="save" class="w-5 h-5"></i>
                        {{ isset($proveedor) ? 'Actualizar Información' : 'Guardar Proveedor' }}
                    </button>
                </div>
            </form>
        </div>

        @if(isset($proveedor) && in_array($proveedor->tipo, ['Materiales', 'Ambos']))
            <div class="bg-white rounded-2xl p-8 shadow-xl border border-slate-100 mb-8">
                <h3 class="text-2xl font-bold text-slate-800 mb-6 flex items-center">
                    <i data-lucide="package" class="w-6 h-6 mr-3 text-indigo-500"></i>
                    Gestión de Materiales
                </h3>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                    <div class="lg:col-span-2">
                        <form action="{{ route('proveedores.vincularMaterial') }}" method="POST" class="bg-slate-50 p-6 rounded-xl border border-slate-200 h-full">
                            @csrf
                            <p class="text-sm font-bold text-slate-500 uppercase mb-4 tracking-wider">Vinculación Individual</p>
                            <input type="hidden" name="fk_id_proveedor" value="{{ $proveedor->ID_proveedor }}">
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-end">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Material Existente</label>
                                    <div class="flex gap-2">
                                        <select name="fk_id_material" id="select_materiales" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                            <option value="" disabled selected>Buscar material...</option>
                                            @foreach($materiales as $mat)
                                                <option value="{{ $mat->ID_Material }}">{{ $mat->nombre }} ({{ $mat->codigo }})</option>
                                            @endforeach
                                        </select>
                                        <button type="button" onclick="abrirModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-3 rounded-lg transition-colors" title="Crear Material Nuevo">
                                            <i data-lucide="plus" class="w-5 h-5"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="flex gap-2 items-end">
                                    <div class="flex-1">
                                        <label class="block text-sm font-bold text-slate-700 mb-2">Precio ($)</label>
                                        <input type="number" step="0.01" name="precio" required placeholder="0.00" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                    </div>
                                    <button type="submit" class="bg-emerald-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-emerald-700 transition-colors flex items-center shadow-md">
                                        <i data-lucide="link" class="w-4 h-4 mr-2"></i> Vincular
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="lg:col-span-1">
                        <form action="{{ route('materiales.importar') }}" method="POST" enctype="multipart/form-data" class="bg-indigo-50 p-6 rounded-xl border border-indigo-100 h-full">
                            @csrf
                            <p class="text-sm font-bold text-indigo-600 uppercase mb-4 tracking-wider">Carga Masiva (CSV)</p>
                            <input type="hidden" name="fk_id_proveedor" value="{{ $proveedor->ID_proveedor }}">
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-500 mb-1 leading-tight">
                                        Archivo CSV: Código, Nombre, ID_Cat, Unidad, Precio
                                    </label>
                                    <input type="file" name="archivo_csv" accept=".csv" required 
                                           class="w-full text-xs text-slate-500 file:mr-2 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 cursor-pointer">
                                </div>
                                <button type="submit" class="w-full bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg hover:bg-indigo-800 transition-colors flex items-center justify-center shadow-md">
                                    <i data-lucide="upload-cloud" class="w-4 h-4 mr-2"></i> Procesar Catálogo
                                </button>
                                <p class="text-[10px] text-indigo-400 text-center italic leading-tight">
                                    Si el código no existe, el material se creará automáticamente.
                                </p>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="overflow-x-auto rounded-lg border border-slate-200">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-100 text-slate-600 text-sm uppercase tracking-wider">
                                <th class="py-3 px-4 font-bold border-b">Código</th>
                                <th class="py-3 px-4 font-bold border-b">Material</th>
                                <th class="py-3 px-4 font-bold border-b">Medida</th>
                                <th class="py-3 px-4 font-bold border-b text-right">Precio Actual</th>
                                <th class="py-3 px-4 font-bold border-b text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($proveedor->abastecimiento as $abastecimiento)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="py-3 px-4 text-slate-500">{{ $abastecimiento->materiales->codigo }}</td>
                                <td class="py-3 px-4 font-semibold text-slate-800">{{ $abastecimiento->materiales->nombre }}</td>
                                <td class="py-3 px-4 text-slate-600">{{ $abastecimiento->materiales->medidas }}</td>
                                <td class="py-3 px-4 text-emerald-600 font-bold text-right">${{ number_format($abastecimiento->precio, 2) }}</td>
                                <td class="py-3 px-4 text-center">
                                    <form action="{{ route('proveedores.desvincularMaterial', [$proveedor->ID_proveedor, $abastecimiento->fk_id_material]) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('¿Seguro que deseas desvincular este material?');" class="text-red-500 hover:text-red-700 transition-colors bg-red-50 hover:bg-red-100 p-2 rounded-lg" title="Desvincular">
                                            <i data-lucide="trash-2" class="w-5 h-5"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-500 italic">
                                    Sin materiales vinculados.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        @if(isset($proveedor) && in_array($proveedor->tipo, ['Servicios', 'Ambos']))
            <div class="bg-white rounded-2xl p-8 shadow-xl border border-slate-100">
                <h3 class="text-2xl font-bold text-slate-800 mb-6 flex items-center">
                    <i data-lucide="wrench" class="w-6 h-6 mr-3 text-amber-500"></i>
                    Gestión de Mano de Obra
                </h3>

                <form action="{{ route('proveedores.vincularServicio') }}" method="POST" class="bg-slate-50 p-6 rounded-xl border border-slate-200 mb-8">
                    @csrf
                    <input type="hidden" name="fk_id_proveedor" value="{{ $proveedor->ID_proveedor }}">
                    
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-end">
                        <div class="md:col-span-5">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Seleccionar Servicio</label>
                            <select name="fk_id_servicio" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500">
                                <option value="" disabled selected>Buscar servicio...</option>
                                @foreach($servicios as $srv)
                                    <option value="{{ $srv->ID_servicio }}">{{ $srv->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="md:col-span-3">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Unidad de Cobro</label>
                            <input type="text" name="unidad" required placeholder="Ej. Hora, M2" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Precio ($)</label>
                            <input type="number" step="0.01" name="precio" required placeholder="0.00" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500">
                        </div>

                        <div class="md:col-span-2">
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
                                <th class="py-3 px-4 font-bold border-b">Servicio</th>
                                <th class="py-3 px-4 font-bold border-b">Categoría</th>
                                <th class="py-3 px-4 font-bold border-b text-right">Precio</th>
                                <th class="py-3 px-4 font-bold border-b text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($proveedor->manoObra as $mo)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="py-3 px-4 font-semibold text-slate-800">{{ $mo->servicio->nombre }}</td>
                                <td class="py-3 px-4 text-slate-500">{{ $mo->servicio->categoria->nombre ?? 'N/A' }}</td>
                                <td class="py-3 px-4 text-emerald-600 font-bold text-right">${{ number_format($mo->precio, 2) }} / {{ $mo->unidad }}</td>
                                <td class="py-3 px-4 text-center">
                                    <form action="{{ route('proveedores.desvincularServicio', [$proveedor->ID_proveedor, $mo->fk_id_servicio]) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('¿Eliminar vínculo?');" class="text-red-500 hover:text-red-700 p-2">
                                            <i data-lucide="trash-2" class="w-5 h-5"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="py-8 text-center text-slate-500">Sin servicios registrados.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>

@if(isset($proveedor))
<div id="modalMaterial" class="fixed inset-0 bg-slate-900/60 hidden items-center justify-center z-50 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-lg mx-4">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-slate-800">Crear Nuevo Material</h2>
            <button onclick="cerrarModal()" class="text-slate-400 hover:text-red-500">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        
        <div id="modalErrores" class="hidden bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded mb-6 text-sm"></div>

        <form id="formMaterialRapido">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Nombre</label>
                    <input type="text" name="nombre" class="w-full px-4 py-2 border border-slate-300 rounded-lg" required>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Código</label>
                        <input type="text" name="codigo" class="w-full px-4 py-2 border border-slate-300 rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Unidad</label>
                        <input type="text" name="medidas" placeholder="Pza, Kg..." class="w-full px-4 py-2 border border-slate-300 rounded-lg" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Categoría</label>
                    <select name="fk_id_categoria" class="w-full px-4 py-2 border border-slate-300 rounded-lg" required>
                        <option value="">Seleccione...</option>
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->ID_Categoria }}">{{ $cat->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-8 pt-6 border-t">
                <button type="button" onclick="cerrarModal()" class="px-6 py-2 text-slate-600 font-bold">Cancelar</button>
                <button type="button" onclick="guardarMaterialModal()" id="btnGuardarModal" class="px-6 py-2 bg-indigo-600 text-white rounded-lg font-bold shadow-lg">
                    Guardar y Seleccionar
                </button>
            </div>
        </form>
    </div>
</div>
@endif

<script>
    lucide.createIcons();

    // LÓGICA DEL MODAL
    const modal = document.getElementById('modalMaterial');
    if(modal) {
        function abrirModal() {
            document.getElementById('formMaterialRapido').reset();
            document.getElementById('modalErrores').classList.add('hidden');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function cerrarModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        async function guardarMaterialModal() {
            const btn = document.getElementById('btnGuardarModal');
            const cajaErrores = document.getElementById('modalErrores');
            
            btn.disabled = true;
            btn.innerText = "Guardando...";
            cajaErrores.classList.add('hidden');

            try {
                let formData = new FormData(document.getElementById('formMaterialRapido'));
                let response = await fetch("{{ route('materiales.guardarRapido') }}", {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });

                let result = await response.json();

                if (response.ok && result.success) {
                    cerrarModal();
                    // Agregar al select y seleccionar
                    let newOpt = new Option(`${result.material.nombre} (Creado)`, result.material.id, true, true);
                    document.getElementById('select_materiales').add(newOpt);
                } else {
                    cajaErrores.innerHTML = result.mensaje || "Error al validar datos.";
                    cajaErrores.classList.remove('hidden');
                }
            } catch (e) {
                alert("Error técnico al guardar.");
            } finally {
                btn.disabled = false;
                btn.innerText = "Guardar y Seleccionar";
            }
        }
    }
</script>
</body>
</html>