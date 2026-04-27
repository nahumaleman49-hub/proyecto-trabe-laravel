<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyectos - Directorio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-50">

<div class="min-h-screen">
    <div class="relative h-64 overflow-hidden bg-gradient-to-r from-slate-700 to-slate-800">
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white">
                <i data-lucide="briefcase" class="w-16 h-16 mx-auto mb-4"></i>
                <h1 class="text-5xl font-bold mb-2">Proyectos</h1>
                <p class="text-xl text-slate-300">Administra tus proyectos</p>
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
                    <h2 class="text-3xl font-bold text-slate-800 mb-2">Agregar Nuevo Proyecto</h2>
                    <p class="text-slate-600 text-lg">Registra un nuevo proyecto en tu base de datos</p>
                </div>
                <a href="{{ route('proyectos.agregar') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-slate-700 to-slate-800 text-white px-8 py-3 rounded-lg hover:shadow-lg transition-shadow">
                    <i data-lucide="plus" class="w-5 h-5"></i>
                    Nuevo Proyecto
                </a>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-8 shadow-lg">
            <h2 class="text-3xl font-bold text-slate-800 mb-6">Lista de Proyectos</h2>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-200">
                            <th class="text-left py-4 px-4">ID</th>
                            <th class="text-left py-4 px-4">Nombre</th>
                            <th class="text-left py-4 px-4">Cliente</th>
                            <th class="text-left py-4 px-4">Estado</th>
                            <th class="text-left py-4 px-4">Fecha Inicio</th>
                            <th class="text-left py-4 px-4">Fecha Fin</th>
                            <th class="text-left py-4 px-4">Presupuesto</th>
                            <th class="text-left py-4 px-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($proyectos as $proyecto)
                            <tr class="border-b border-slate-100 hover:bg-slate-50">
                                <td class="py-4 px-4 font-mono text-sm">{{ $proyecto->ID_proyecto }}</td>
                                <td class="py-4 px-4 font-semibold">{{ $proyecto->nombre }}</td>
                                <td class="py-4 px-4">{{ $proyecto->cliente->nombre ?? 'N/A' }}</td>
                                <td class="py-4 px-4">
                                    @if($proyecto->estado)
                                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-sm">Activo</span>
                                    @else
                                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-sm">Inactivo</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4">{{ \Carbon\Carbon::parse($proyecto->fecha_ini)->format('d/m/Y') }}</td>
                                <td class="py-4 px-4">{{ $proyecto->fecha_fin ? \Carbon\Carbon::parse($proyecto->fecha_fin)->format('d/m/Y') : '-' }}</td>
                                <td class="py-4 px-4">${{ number_format($proyecto->presupuesto, 2) }}</td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('proyectos.modificar', $proyecto->ID_proyecto) }}" class="text-slate-600 hover:text-slate-800" title="Editar">
                                            <i data-lucide="edit" class="w-5 h-5"></i>
                                        </a>
                                        <!-- eliminar un proyecto funcion incluida no visible para interaccion
                                        <form action="{{ route('proyectos.eliminar', $proyecto->ID_proyecto) }}" method="POST" onsubmit="return confirm('¿Eliminar este proyecto?')" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700" title="Eliminar">
                                                <i data-lucide="trash-2" class="w-5 h-5"></i>
                                            </button>
                                        </form> -->
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-8 text-center text-slate-500">No hay proyectos registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>lucide.createIcons();</script>
</body>
</html>