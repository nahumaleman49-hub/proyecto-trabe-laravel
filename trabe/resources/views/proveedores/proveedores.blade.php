<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QOSTO - Proveedores</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-50">

    {{-- Cabecera --}}
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
        {{-- Volver al inicio --}}
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
                <a href="{{ route('proveedores.crear') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-slate-700 to-slate-800 text-white px-6 py-3 rounded-lg hover:shadow-lg transition-shadow">
                    <i data-lucide="plus" class="w-5 h-5"></i>
                    Nuevo Proveedor
                </a>
            </div>
        </div>

        {{-- Lista de proveedores --}}
        <div class="bg-white rounded-2xl p-8 shadow-lg">
            <h2 class="text-3xl font-bold text-slate-800 mb-6">
                Proveedores Registrados ({{ count($proveedores) }})
            </h2>
            <div class="space-y-4">
                @forelse($proveedores as $proveedor)
                <div class="border border-slate-200 rounded-xl p-6 hover:border-slate-400 transition-colors">
                    <div class="flex flex-wrap items-start justify-between gap-4 mb-4">
                        <div class="flex-1">
                            <h3 class="font-bold text-slate-800 text-xl">{{ $proveedor->nombre }}</h3>
                            <p class="text-slate-500 text-sm mt-1">Contacto: {{ $proveedor->nombre_contacto }}</p>
                        </div>
                        {{-- Puedes agregar algún badge si lo deseas, por ejemplo "Activo" fijo --}}
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium">
                            Activo
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
                        <div class="flex items-center text-slate-600 text-sm">
                            <i data-lucide="mail" class="w-4 h-4 mr-2"></i>
                            <span>{{ $proveedor->correo_e }}</span>
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

                    {{-- Botones de acción --}}
                    <div class="flex gap-3">
                        <a href="{{ route('proveedores.editar', $proveedor->ID_proveedor) }}" class="flex-1 bg-slate-700 text-white py-2 rounded-lg hover:bg-slate-800 transition-colors text-center">
                            Editar
                        </a>
                        <form action="{{ route('proveedores.eliminar', $proveedor->ID_proveedor) }}" method="POST" onsubmit="return confirm('¿Eliminar este proveedor?')" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-100 text-red-700 py-2 rounded-lg hover:bg-red-200 transition-colors">
                                Eliminar
                            </button>
                        </form>
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