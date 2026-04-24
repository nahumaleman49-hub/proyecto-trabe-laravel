<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mano de Obra - Servicios</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-50">

<div class="min-h-screen">
    <div class="relative h-64 overflow-hidden bg-gradient-to-r from-slate-700 to-slate-800">
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white">
                <i data-lucide="briefcase" class="w-16 h-16 mx-auto mb-4"></i>
                <h1 class="text-5xl font-bold mb-2">Mano de Obra</h1>
                <p class="text-xl text-slate-300">Servicios especializados y proveedores</p>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <a href="{{ route('home') }}" class="inline-flex items-center text-slate-600 hover:text-slate-800 transition-colors mb-8">
            <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i>
            Volver al Inicio
        </a>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl p-8 shadow-lg mb-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h2 class="text-3xl font-bold text-slate-800 mb-2">Agregar Nuevo Servicio</h2>
                    <p class="text-slate-600 text-lg">Registra un nuevo tipo de servicio</p>
                </div>
                <a href="{{ route('mano.de.obra.agregar') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-slate-700 to-slate-800 text-white px-8 py-3 rounded-lg hover:shadow-lg transition-shadow">
                    <i data-lucide="plus" class="w-5 h-5"></i>
                    Nuevo Servicio
                </a>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-8 shadow-lg">
            <h2 class="text-3xl font-bold text-slate-800 mb-6">Lista de Servicios</h2>
            <div class="space-y-6">
                @forelse($servicios as $servicio)
                <div class="border border-slate-200 rounded-xl p-6 hover:border-slate-400 transition-colors">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-2xl font-bold text-slate-800">{{ $servicio->nombre }}</h3>
                            <p class="text-slate-600 mt-1">Categoría: {{ $servicio->categoria->nombre ?? 'N/A' }}</p>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('mano.de.obra.modificar', $servicio->ID_servicio) }}" class="text-slate-600 hover:text-slate-800">
                                <i data-lucide="edit" class="w-5 h-5"></i>
                            </a>
                            <form action="{{ route('mano.de.obra.eliminar', $servicio->ID_servicio) }}" method="POST" onsubmit="return confirm('¿Eliminar este servicio?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">
                                    <i data-lucide="trash-2" class="w-5 h-5"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h4 class="font-semibold text-slate-700 mb-2">Proveedores que ofrecen este servicio:</h4>
                        <div class="grid gap-3">
                            @forelse($servicio->manoObra as $mano)
                            <div class="bg-slate-50 rounded-lg p-3 flex justify-between items-center">
                                <div>
                                    <p class="font-medium text-slate-800">{{ $mano->proveedor->nombre ?? 'N/A' }}</p>
                                    <p class="text-sm text-slate-600">Contacto: {{ $mano->proveedor->nombre_contacto ?? 'N/A' }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-bold text-slate-700">${{ number_format($mano->precio, 2) }}</p>
                                    <p class="text-xs text-slate-500">por {{ $mano->unidad }}</p>
                                </div>
                            </div>
                            @empty
                            <p class="text-slate-500 text-sm">No hay proveedores registrados para este servicio.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-slate-500">
                    No hay servicios registrados.
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
    lucide.createIcons();
</script>
</body>
</html>