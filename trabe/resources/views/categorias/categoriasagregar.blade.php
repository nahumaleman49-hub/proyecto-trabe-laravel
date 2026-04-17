<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($categoria) ? 'Editar Categoría' : 'Nueva Categoría' }} - Categorías</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-50">

<div class="min-h-screen">
    <div class="relative h-64 overflow-hidden bg-gradient-to-r from-slate-700 to-slate-800">
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white">
                <i data-lucide="folder-plus" class="w-16 h-16 mx-auto mb-4"></i>
                <h1 class="text-5xl font-bold mb-2">{{ isset($categoria) ? 'Editar Categoría' : 'Nueva Categoría' }}</h1>
                <p class="text-xl text-slate-300">{{ isset($categoria) ? 'Modifica los detalles de la clasificación' : 'Registra una nueva clasificación' }}</p>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <a href="{{ route('categorias.index') }}" class="inline-flex items-center text-slate-600 hover:text-slate-800 transition-colors mb-8">
            <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i> Volver a Categorías
        </a>

        <div class="bg-white rounded-2xl p-8 shadow-lg">
            <form action="{{ isset($categoria) ? route('categorias.actualizar', $categoria->ID_Categoria) : route('categorias.guardar') }}" method="POST">
                @csrf
                @if(isset($categoria))
                    @method('PUT')
                @endif

                <div class="space-y-6">
                    <div>
                        <label class="block text-slate-700 font-semibold mb-2">Nombre de la Categoría *</label>
                        <input type="text" name="nombre" value="{{ old('nombre', $categoria->nombre ?? '') }}" 
                               class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-500"
                               placeholder="Ej: Materiales Estructurales" required maxlength="50">
                        @error('nombre') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-slate-700 font-semibold mb-2">Descripción *</label>
                        <textarea name="descripcion" rows="3" 
                                  class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-500"
                                  placeholder="Ej: Materiales base para cimentación" required maxlength="255">{{ old('descripcion', $categoria->descripcion ?? '') }}</textarea>
                        @error('descripcion') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mt-8 flex gap-4">
                    <button type="submit" class="inline-flex items-center gap-2 bg-gradient-to-r from-slate-700 to-slate-800 text-white px-8 py-3 rounded-lg hover:shadow-lg transition-shadow">
                        <i data-lucide="save" class="w-5 h-5"></i>
                        {{ isset($categoria) ? 'Actualizar Categoría' : 'Guardar Categoría' }}
                    </button>
                    
                    <a href="{{ route('categorias.index') }}" class="inline-block px-8 py-3 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition-colors">
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