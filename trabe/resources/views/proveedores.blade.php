<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QOSTO - Proveedores</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-50">

    {{-- Cabecera con gradiente --}}
    <div class="relative h-64 overflow-hidden bg-gradient-to-r from-slate-700 to-slate-800">
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white">
                <i data-lucide="package" class="w-16 h-16 mx-auto mb-4"></i>
                <h1 class="text-5xl font-bold mb-2">Proveedores</h1>
                <p class="text-xl text-slate-300">Gestiona tus socios comerciales</p>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        {{-- Botón volver al inicio --}}
        <a href="{{ route('home') }}" class="inline-flex items-center text-slate-600 hover:text-slate-800 transition-colors mb-8">
            <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i>
            Volver al Inicio
        </a>

        {{-- Sección crear nuevo proveedor --}}
        <div class="bg-white rounded-2xl p-6 shadow-lg mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-slate-800 mb-1">Agregar Nuevo Proveedor</h2>
                    <p class="text-slate-600">Registra un nuevo proveedor en tu red</p>
                </div>
                <a href="{{ route('proveedores.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-slate-700 to-slate-800 text-white px-6 py-3 rounded-lg hover:shadow-lg transition-shadow">
                    <i data-lucide="plus" class="w-5 h-5"></i>
                    Nuevo Proveedor
                </a>
            </div>
        </div>

        {{-- Lista de proveedores --}}
        <div class="bg-white rounded-2xl p-8 shadow-lg">
            <h2 class="text-3xl font-bold text-slate-800 mb-6">
                Proveedores Activos ({{ count($proveedores) }})
            </h2>
            <div class="space-y-4">
                @forelse($proveedores as $proveedor)
                <div class="border border-slate-200 rounded-xl p-6 hover:border-slate-400 transition-colors">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <div class="flex flex-wrap items-center gap-3 mb-2">
                                <h3 class="font-bold text-slate-800 text-xl">{{ $proveedor->nombre }}</h3>
                                <div class="flex items-center bg-yellow-100 px-2 py-1 rounded-full">
                                    <i data-lucide="star" class="w-4 h-4 text-yellow-600 mr-1 fill-yellow-600"></i>
                                    <span class="text-sm font-semibold text-yellow-700">{{ $proveedor->calificacion }}</span>
                                </div>
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium">
                                    {{ $proveedor->estado }}
                                </span>
                            </div>
                            <p class="text-slate-600 font-medium mb-3">{{ $proveedor->categoria }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
                        <div class="flex items-center text-slate-600 text-sm">
                            <i data-lucide="mail" class="w-4 h-4 mr-2"></i>
                            <span>{{ $proveedor->email }}</span>
                        </div>
                        <div class="flex items-center text-slate-600 text-sm">
                            <i data-lucide="phone" class="w-4 h-4 mr-2"></i>
                            <span>{{ $proveedor->telefono }}</span>
                        </div>
                        <div class="flex items-start text-slate-600 text-sm md:col-span-2">
                            <i data-lucide="map-pin" class="w-4 h-4 mr-2 mt-0.5"></i>
                            <span>{{ $proveedor->direccion }}</span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <p class="text-sm font-semibold text-slate-700 mb-2">Materiales Suministrados:</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($proveedor->materiales as $material)
                            <span class="bg-slate-100 text-slate-700 px-3 py-1 rounded-full text-sm">
                                {{ $material }}
                            </span>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <a href="{{ route('proveedores.show', $proveedor) }}" class="flex-1 bg-slate-700 text-white py-2 rounded-lg hover:bg-slate-800 transition-colors text-center">
                            Ver Detalles
                        </a>
                        <a href="{{ route('proveedores.edit', $proveedor) }}" class="px-6 bg-slate-100 text-slate-700 py-2 rounded-lg hover:bg-slate-200 transition-colors text-center">
                            Editar
                        </a>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-slate-500">
                    No hay proveedores registrados.
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
        });
    </script>
</body>
</html>