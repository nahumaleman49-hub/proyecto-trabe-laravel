<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($cliente) ? 'Editar Cliente' : 'Nuevo Cliente' }} - Clientes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        .gradient-1 { background: linear-gradient(135deg, #1e293b, #0f172a); }
    </style>
</head>
<body class="bg-slate-50">

<div class="min-h-screen">
    <!-- Header -->
    <div class="relative h-64 overflow-hidden bg-gradient-to-r from-slate-700 to-slate-800">
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white">
                <i data-lucide="user-circle" class="w-16 h-16 mx-auto mb-4"></i>
                <h1 class="text-5xl font-bold mb-2">{{ isset($cliente) ? 'Editar Cliente' : 'Nuevo Cliente' }}</h1>
                <p class="text-xl text-slate-300">{{ isset($cliente) ? 'Actualiza la información del cliente' : 'Registra un nuevo cliente' }}</p>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <!-- Botón volver -->
        <a href="{{ route('clientes') }}" class="inline-flex items-center text-slate-600 hover:text-slate-800 transition-colors mb-8">
            <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i>
            Volver a Clientes
        </a>

        <div class="bg-white rounded-2xl p-8 shadow-lg">
            <form action="{{ isset($cliente) ? route('clientes.actualizar', $cliente->ID_cliente) : route('clientes.guardar') }}" method="POST">
                @csrf
                @if(isset($cliente))
                    @method('PUT')
                @endif

                <div class="space-y-6">
                    <div>
                        <label class="block text-slate-700 font-semibold mb-2">Nombre del Cliente *</label>
                        <input type="text" name="nombre" value="{{ old('nombre', $cliente->nombre ?? '') }}" 
                               class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-500"
                               placeholder="Ej: Juan García o Corporación ABC" required maxlength="50">
                        @error('nombre') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-slate-700 font-semibold mb-2">Teléfono *</label>
                        <input type="tel" name="telefono" value="{{ old('telefono', $cliente->telefono ?? '') }}" 
                               class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-500"
                               placeholder="5551234567" required>
                        @error('telefono') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-slate-700 font-semibold mb-2">Dirección *</label>
                        <textarea name="direccion" rows="3" 
                                  class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-500"
                                  placeholder="Ej: Av. Reforma 123, Ciudad de México" required maxlength="80">{{ old('direccion', $cliente->direccion ?? '') }}</textarea>
                        @error('direccion') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mt-8 flex gap-4">
                    <button type="submit" class="inline-flex items-center gap-2 bg-gradient-to-r from-slate-700 to-slate-800 text-white px-8 py-3 rounded-lg hover:shadow-lg transition-shadow">
                        <i data-lucide="save" class="w-5 h-5"></i>
                        {{ isset($cliente) ? 'Actualizar Cliente' : 'Guardar Cliente' }}
                    </button>
                    
                    <a href="{{ route('clientes') }}" class="inline-block px-8 py-3 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition-colors">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    lucide.createIcons();
</script>
</body>
</html>