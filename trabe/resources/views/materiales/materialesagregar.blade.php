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
                <p class="text-xl text-slate-300">{{ isset($material) ? 'Modifica los detalles del producto' : 'Registra un nuevo producto en el catálogo' }}</p>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <a href="{{ route('materiales.index') }}" class="inline-flex items-center text-slate-600 hover:text-slate-800 transition-colors mb-8 font-medium">
            <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i> Volver al listado
        </a>

        <div class="bg-white rounded-2xl p-8 shadow-xl border border-slate-100">
            <form action="{{ isset($material) ? route('materiales.actualizar', $material->ID_Material) : route('materiales.guardar') }}" method="POST">
                @csrf
                @if(isset($material))
                    @method('PUT')
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    <div class="md:col-span-2">
                        <label class="block text-slate-700 font-bold mb-2">Nombre del Material *</label>
                        <input type="text" name="nombre" value="{{ old('nombre', $material->nombre ?? '') }}" 
                               class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-slate-500 transition-all"
                               placeholder="Ej: Cemento Gris Tolteca" required>
                        @error('nombre') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-slate-700 font-bold mb-2">Código Interno *</label>
                        <input type="text" name="codigo" value="{{ old('codigo', $material->codigo ?? '') }}" 
                               class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-slate-500 transition-all"
                               placeholder="Ej: CEM-001" required>
                        @error('codigo') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-slate-700 font-bold mb-2">Unidad de Medida *</label>
                        <input type="text" name="medidas" value="{{ old('medidas', $material->medidas ?? '') }}" 
                               class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-slate-500 transition-all"
                               placeholder="Ej: Bulto 50kg, m2, Pieza" required>
                        @error('medidas') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label class="text-slate-700 font-bold">Categoría *</label>
                            <a href="{{ route('categorias.agregar') }}" class="text-xs text-blue-600 hover:text-blue-800 font-semibold flex items-center gap-1">
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
                        @error('fk_id_categoria') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    @if(!isset($material))
                        <div class="md:col-span-2 mt-4 pt-6 border-t border-slate-100">
                            <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center">
                                <i data-lucide="truck" class="w-5 h-5 mr-2 text-slate-500"></i>
                                Asignación de Proveedor y Precio Inicial
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                
                                <div>
                                    <label class="block text-slate-700 font-bold mb-2">Proveedor *</label>
                                    <select name="fk_id_proveedor" required class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-slate-500 bg-white transition-all">
                                        <option value="" disabled {{ old('fk_id_proveedor') ? '' : 'selected' }}>Seleccione un proveedor...</option>
                                        @foreach($proveedores as $proveedor)
                                            <option value="{{ $proveedor->ID_proveedor }}" {{ old('fk_id_proveedor') == $proveedor->ID_Proveedor ? 'selected' : '' }}>
                                                {{ $proveedor->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('fk_id_proveedor') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-slate-700 font-bold mb-2">Precio Unitario Inicial ($) *</label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-500 font-semibold">$</span>
                                        <input type="number" name="precio" step="0.01" value="{{ old('precio') }}" 
                                               class="w-full pl-10 pr-4 py-3 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-slate-500 transition-all"
                                               placeholder="0.00" required>
                                    </div>
                                    @error('precio') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                                </div>

                            </div>
                        </div>
                    @endif
                    </div>

                <div class="mt-10 flex flex-col sm:flex-row gap-4 border-t border-slate-100 pt-8">
                    <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 bg-slate-800 text-white px-8 py-4 rounded-xl hover:bg-slate-900 transition-all shadow-lg font-bold">
                        <i data-lucide="save" class="w-5 h-5"></i>
                        {{ isset($material) ? 'Actualizar Cambios' : 'Guardar Material' }}
                    </button>
                    
                    <a href="{{ route('materiales.index') }}" class="flex-1 inline-flex items-center justify-center px-8 py-4 border border-slate-300 text-slate-700 rounded-xl hover:bg-slate-50 transition-all font-semibold">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<script>
    // Inicializar iconos de Lucide
    lucide.createIcons();
</script>
</body>
</html>