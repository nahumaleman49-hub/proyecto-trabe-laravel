<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materiales - Directorio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-50">

<div class="min-h-screen">
    <div class="relative h-64 overflow-hidden bg-gradient-to-r from-slate-700 to-slate-800">
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white">
                <i data-lucide="box" class="w-16 h-16 mx-auto mb-4"></i>
                <h1 class="text-5xl font-bold mb-2">Materiales</h1>
                <p class="text-xl text-slate-300">Listado general de materiales de construcción</p>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <a href="{{ route('home') }}" class="inline-flex items-center text-slate-600 hover:text-slate-800 transition-colors mb-8">
            <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i> Volver al Inicio
        </a>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl p-8 shadow-lg mb-8">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                <div>
                    <h2 class="text-3xl font-bold text-slate-800 mb-2">Gestión de Materiales</h2>
                    <p class="text-slate-600 text-lg">Administra tus materiales y sus clasificaciones</p>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                    <form action="{{ route('materiales.index') }}" method="GET" class="flex-grow">
                        <div class="relative flex items-center">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i data-lucide="search" class="w-5 h-5 text-slate-400"></i>
                            </div>
                            
                            <input type="text" name="buscar" value="{{ request('buscar') }}" 
                                   class="w-full pl-10 pr-24 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-500 bg-white" 
                                   placeholder="Ingrese material o código">
                            
                            <div class="absolute inset-y-0 right-0 flex items-center pr-2 gap-2">
                                <button type="submit" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-3 py-1.5 rounded-md text-sm font-semibold transition-colors">
                                    Buscar
                                </button>

                                @if(request('buscar'))
                                    <a href="{{ route('materiales.index') }}" class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 px-2 py-1.5 rounded-md transition-colors" title="Limpiar">
                                        <i data-lucide="x" class="w-4 h-4"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>

                    <a href="{{ route('categorias.index') }}" class="inline-flex items-center justify-center gap-2 border border-slate-300 text-slate-700 px-6 py-3 rounded-lg hover:bg-slate-50 transition-all shadow-sm">
                        <i data-lucide="layers" class="w-5 h-5 text-slate-500"></i> 
                        <span class="hidden sm:inline">Categorías</span>
                    </a>

                    <a href="{{ route('materiales.agregar') }}" class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-slate-700 to-slate-800 text-white px-6 py-3 rounded-lg hover:shadow-lg transition-shadow whitespace-nowrap">
                        <i data-lucide="plus" class="w-5 h-5"></i> 
                        Nuevo Material
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-8 shadow-lg">
            <h2 class="text-3xl font-bold text-slate-800 mb-6">Lista de Materiales</h2>
            
            @if(request('buscar'))
                <p class="text-slate-600 mb-4">
                    Mostrando resultados para: <span class="font-semibold text-slate-800">"{{ request('buscar') }}"</span>
                </p>
            @endif

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-200">
                            <th class="text-left py-4 px-4 text-slate-700 font-semibold">Código</th>
                            <th class="text-left py-4 px-4 text-slate-700 font-semibold">Nombre</th>
                            <th class="text-left py-4 px-4 text-slate-700 font-semibold">Unidad</th>
                            <th class="text-left py-4 px-4 text-slate-700 font-semibold">Categoría</th>
                            <th class="text-left py-4 px-4 text-slate-700 font-semibold">Precio</th>
                            <th class="text-left py-4 px-4 text-slate-700 font-semibold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($materiales as $material)
                            <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
                                <td class="py-4 px-4 font-mono text-sm text-slate-600">{{ $material->codigo }}</td>
                                <td class="py-4 px-4 font-semibold text-slate-800">{{ $material->nombre }}</td>
                                <td class="py-4 px-4 text-slate-600">{{ $material->medidas }}</td>
                                <td class="py-4 px-4 text-slate-600">{{ $material->categoria->nombre ?? 'Sin Categoría' }}</td>
                                <td class="py-4 px-4 text-slate-600">${{ number_format($material->precio, 2) }}</td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('materiales.editar', $material->ID_Material) }}" class="text-slate-600 hover:text-slate-800 transition-all" title="Editar">
                                            <i data-lucide="edit" class="w-5 h-5"></i>
                                        </a>
                                        <form action="{{ route('materiales.eliminar', $material->ID_Material) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este material?')" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 transition-all" title="Eliminar">
                                                <i data-lucide="trash-2" class="w-5 h-5"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-500">
                                    @if(request('buscar'))
                                        No se encontraron materiales que coincidan con "{{ request('buscar') }}".
                                    @else
                                        No hay materiales registrados.
                                    @endif
                                </td>
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