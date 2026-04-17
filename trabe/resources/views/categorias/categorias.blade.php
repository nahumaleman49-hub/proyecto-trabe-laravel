<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorías - Directorio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        .gradient-1 { background: linear-gradient(135deg, #1e293b, #0f172a); }
        .card { transition: all 0.3s ease; }
        .card:hover { transform: translateY(-4px); box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); }
    </style>
</head>
<body class="bg-slate-50">

<div class="min-h-screen">
    <div class="relative h-64 overflow-hidden bg-gradient-to-r from-slate-700 to-slate-800">
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white">
                <i data-lucide="layers" class="w-16 h-16 mx-auto mb-4"></i>
                <h1 class="text-5xl font-bold mb-2">Categorías</h1>
                <p class="text-xl text-slate-300">Administra las categorías de tus materiales</p>
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
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h2 class="text-3xl font-bold text-slate-800 mb-2">Agregar Nueva Categoría</h2>
                    <p class="text-slate-600 text-lg">Crea una nueva clasificación para tu inventario</p>
                </div>
                <a href="{{ route('categorias.agregar') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-slate-700 to-slate-800 text-white px-8 py-3 rounded-lg hover:shadow-lg transition-shadow">
                    <i data-lucide="plus" class="w-5 h-5"></i> Nueva Categoría
                </a>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-8 shadow-lg">
            <h2 class="text-3xl font-bold text-slate-800 mb-6">Lista de Categorías</h2>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-200">
                            <th class="text-left py-4 px-4 text-slate-700 font-semibold">ID</th>
                            <th class="text-left py-4 px-4 text-slate-700 font-semibold">Nombre</th>
                            <th class="text-left py-4 px-4 text-slate-700 font-semibold">Descripción</th>
                            <th class="text-left py-4 px-4 text-slate-700 font-semibold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categorias as $categoria)
                            <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
                                <td class="py-4 px-4 font-mono text-sm text-slate-600">{{ $categoria->ID_Categoria }}</td>
                                <td class="py-4 px-4 font-semibold text-slate-800">{{ $categoria->nombre }}</td>
                                <td class="py-4 px-4 text-slate-600">{{ $categoria->descripcion }}</td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('categorias.editar', $categoria->ID_Categoria) }}" class="text-slate-600 hover:text-slate-800 transition-all" title="Editar">
                                            <i data-lucide="edit" class="w-5 h-5"></i>
                                        </a>
                                        <form action="{{ route('categorias.eliminar', $categoria->ID_Categoria) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta categoría?')" style="display: inline;">
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
                                <td colspan="4" class="py-8 text-center text-slate-500">No hay categorías registradas.</td>
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