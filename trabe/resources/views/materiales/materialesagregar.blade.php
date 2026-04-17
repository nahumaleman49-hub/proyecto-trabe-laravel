<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($material) ? 'Editar Material' : 'Nuevo Material' }} - Materiales</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-50">

<div class="min-h-screen">
    <div class="relative h-64 overflow-hidden bg-gradient-to-r from-slate-700 to-slate-800">
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white">
                <i data-lucide="package-plus" class="w-16 h-16 mx-auto mb-4"></i>
                <h1 class="text-5xl font-bold mb-2">{{ isset($material) ? 'Editar Material' : 'Nuevo Material' }}</h1>
                <p class="text-xl text-slate-300">{{ isset($material) ? 'Actualiza los datos del material' : 'Añade un nuevo material al inventario' }}</p>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <a href="{{ route('materiales.index') }}" class="inline-flex items-center text-slate-600 hover:text-slate-800 transition-colors mb-8">
            <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i> Volver a Materiales
        </a>

        <div class="bg-white rounded-2xl p-8 shadow-lg">
            <form action="{{ isset($material) ? route('materiales.actualizar', $material->ID_Material) : route('materiales.guardar') }}" method="POST">
                @csrf
                @if(isset($material))
                    @method('PUT')
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-slate-700 font-semibold mb-2">Nombre del Material *</label>
                        <input type="text" name="nombre" value="{{ old('nombre', $material->nombre ?? '') }}" 
                               class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-500"
                               placeholder="Ej: Cemento Tolteca Gris" required>
                        @error('nombre') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-slate-700 font-semibold mb-2">Código *</label>
                        <input type="text" name="codigo" value="{{ old('codigo', $material->codigo ?? '') }}" 
                               class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-500"
                               placeholder="Ej: CEM-001" required>
                        @error('codigo') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-slate-700 font-semibold mb-2">Unidad de Medida *</label>
                        <input type="text" name="medidas" value="{{ old('medidas', $material->medidas ?? '') }}" 
                               class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-500"
                               placeholder="Ej: Bulto 50kg, m2, Pieza" required>
                        @error('medidas') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-slate-700 font-semibold mb-2">Categoría *</label>
                        <select name="fk_id_categoria" required class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-500 bg-white">
                            <option value="">Selecciona una categoría...</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->ID_Categoria }}" 
                                    {{ old('fk_id_categoria', $material->fk_id_categoria ?? '') == $categoria->ID_Categoria ? 'selected' : '' }}>
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('fk_id_categoria') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mt-8 flex gap-4">
                    <button type="submit" class="inline-flex items-center gap-2 bg-gradient-to-r from-slate-700 to-slate-800 text-white px-8 py-3 rounded-lg hover:shadow-lg transition-shadow">
                        <i data-lucide="save" class="w-5 h-5"></i>
                        {{ isset($material) ? 'Actualizar Material' : 'Guardar Material' }}
                    </button>
                    <a href="{{ route('materiales.index') }}" class="inline-block px-8 py-3 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition-colors">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
<script>lucide.createIcons();</script>
</body>
</html>