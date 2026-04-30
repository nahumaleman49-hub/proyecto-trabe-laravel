<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($material) ? 'Editar Material' : 'Nuevo Material' }} - Sistema de Inventario</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-50">

<div class="min-h-screen">
    <div class="relative h-64 overflow-hidden bg-gradient-to-r from-slate-700 to-slate-800">
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white">
                <i data-lucide="{{ isset($material) ? 'edit' : 'package-plus' }}" class="w-16 h-16 mx-auto mb-4"></i>
                <h1 class="text-5xl font-bold mb-2">{{ isset($material) ? 'Editar Material' : 'Nuevo Material' }}</h1>
                <p class="text-xl text-slate-300">{{ isset($material) ? 'Modifica los detalles del producto' : 'Registra un nuevo producto en el catálogo base' }}</p>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <a href="{{ route('materiales.index') }}" class="inline-flex items-center text-slate-600 hover:text-slate-800 transition-colors mb-6 font-medium">
            <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i> Volver al listado
        </a>

        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-r-lg mb-6 shadow-sm">
                <div class="flex items-center mb-2"><i data-lucide="alert-circle" class="w-5 h-5 mr-2"></i><span class="font-bold">Hay errores en el formulario:</span></div>
                <ul class="list-disc list-inside ml-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-r-lg mb-6 shadow-sm flex items-center">
                <i data-lucide="check-circle" class="w-6 h-6 mr-3 text-emerald-600"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-2xl p-8 shadow-xl border border-slate-100 mb-8">
            <h2 class="text-xl font-bold text-slate-800 mb-6 flex items-center border-b pb-4">
                <i data-lucide="info" class="w-5 h-5 mr-2 text-indigo-500"></i> Información Base
            </h2>

            <form action="{{ isset($material) ? route('materiales.actualizar', $material->ID_Material) : route('materiales.guardar') }}" method="POST">
                @csrf
                @if(isset($material))
                    @method('PUT')
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-slate-700 font-bold mb-2">Nombre del Material *</label>
                        <input type="text" name="nombre" value="{{ old('nombre', $material->nombre ?? '') }}" 
                               class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-slate-500 transition-all"
                               placeholder="Ej: Cemento Gris Tolteca" required>
                    </div>

                    <div>
                        <label class="block text-slate-700 font-bold mb-2">Código Interno *</label>
                        <input type="text" name="codigo" value="{{ old('codigo', $material->codigo ?? '') }}" 
                               class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-slate-500 transition-all"
                               placeholder="Ej: CEM-001" required>
                    </div>

                    <div>
                        <label class="block text-slate-700 font-bold mb-2">Unidad de Medida *</label>
                        <input type="text" name="medidas" value="{{ old('medidas', $material->medidas ?? '') }}" 
                               class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-slate-500 transition-all"
                               placeholder="Ej: Bulto 50kg, m2, Pieza" required>
                    </div>

                    <div class="md:col-span-2">
                        <div class="flex justify-between items-center mb-2">
                            <label class="text-slate-700 font-bold">Categoría *</label>
                            <a href="{{ route('categorias.agregar') }}" class="text-xs text-indigo-600 hover:text-indigo-800 font-semibold flex items-center gap-1">
                                <i data-lucide="plus-circle" class="w-3 h-3"></i> Crear nueva
                            </a>
                        </div>
                        <select name="fk_id_categoria" required class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-slate-500 bg-white transition-all">
                            <option value="">Seleccione una opción...</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->ID_Categoria }}" 
                                    {{ (old('fk_id_categoria', $material->fk_id_categoria ?? '') == $categoria->ID_Categoria) ? 'selected' : '' }}>
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mt-8 flex flex-col sm:flex-row gap-4 pt-6">
                    <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 bg-slate-800 text-white px-8 py-3 rounded-xl hover:bg-slate-900 transition-all shadow-md font-bold">
                        <i data-lucide="save" class="w-5 h-5"></i>
                        {{ isset($material) ? 'Actualizar Información Base' : 'Guardar Material' }}
                    </button>
                    <a href="{{ route('materiales.index') }}" class="flex-1 inline-flex items-center justify-center px-8 py-3 border border-slate-300 text-slate-700 rounded-xl hover:bg-slate-50 transition-all font-semibold">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>

        @if(isset($material))
            <div class="bg-white rounded-2xl p-8 shadow-xl border border-slate-100">
                <h3 class="text-xl font-bold text-slate-800 mb-6 flex items-center border-b pb-4">
                    <i data-lucide="store" class="w-6 h-6 mr-3 text-emerald-500"></i>
                    Proveedores y Precios
                </h3>

                <form action="{{ route('materiales.vincularProveedor') }}" method="POST" class="bg-slate-50 p-6 rounded-xl border border-slate-200 mb-8">
                    @csrf
                    <input type="hidden" name="fk_id_material" value="{{ $material->ID_Material }}">
                    
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Seleccionar Proveedor</label>
                            <select name="fk_id_proveedor" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                <option value="" disabled selected>Buscar proveedor...</option>
                                @foreach($proveedor as $prov)
                                    <option value="{{ $prov->ID_proveedor }}">{{ $prov->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="md:col-span-1">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Precio de Compra ($)</label>
                            <input type="number" step="0.01" name="precio" required placeholder="0.00" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>

                        <div class="md:col-span-1">
                            <button type="submit" class="w-full bg-emerald-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-emerald-700 transition-colors flex items-center justify-center shadow-md">
                                <i data-lucide="plus" class="w-4 h-4 mr-1"></i> Agregar
                            </button>
                        </div>
                    </div>
                </form>

                <div class="overflow-hidden rounded-xl border border-slate-200">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-800 text-white text-sm uppercase tracking-wider">
                                <th class="py-3 px-4 font-bold">Proveedor</th>
                                <th class="py-3 px-4 font-bold">Contacto</th>
                                <th class="py-3 px-4 font-bold text-right">Precio Actual</th>
                                <th class="py-3 px-4 font-bold text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white">
                            @forelse($material->abastecimientos as $abastecimiento)
                                @if($abastecimiento->proveedor) 
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="py-3 px-4 font-semibold text-slate-800 flex items-center">
                                        <i data-lucide="truck" class="w-4 h-4 mr-2 text-slate-400"></i>
                                        {{ $abastecimiento->proveedor->nombre }}
                                    </td>
                                    <td class="py-3 px-4 text-slate-600">{{ $abastecimiento->proveedor->telefono ?? 'Sin teléfono' }}</td>
                                    <td class="py-3 px-4 text-emerald-600 font-bold text-right">${{ number_format($abastecimiento->precio, 2) }}</td>
                                    <td class="py-3 px-4 text-center">
                                        <form action="{{ route('materiales.desvincularProveedor', ['material' => $material->ID_Material, 'proveedor' => $abastecimiento->proveedor->ID_proveedor]) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('¿Estás seguro de desvincular a este proveedor de este material?');" class="text-red-500 hover:text-red-700 transition-colors p-1 bg-red-50 hover:bg-red-100 rounded-lg" title="Desvincular">
                                                <i data-lucide="trash-2" class="w-5 h-5"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endif
                            @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-slate-500 bg-slate-50">
                                    <i data-lucide="store" class="w-8 h-8 mx-auto text-slate-300 mb-2"></i>
                                    Aún no has registrado qué proveedores surten este material.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

    </div>
</div>

<script>
    // Inicializar iconos de Lucide
    lucide.createIcons();
</script>
</body>
</html>