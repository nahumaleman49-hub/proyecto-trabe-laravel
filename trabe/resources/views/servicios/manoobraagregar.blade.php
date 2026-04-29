<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($servicio) ? 'Editar Servicio' : 'Nuevo Servicio' }} - Sistema de Inventario</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-50">

<div class="min-h-screen">
    <div class="relative h-64 overflow-hidden bg-gradient-to-r from-slate-700 to-slate-800">
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white">
                <i data-lucide="{{ isset($servicio) ? 'edit' : 'briefcase' }}" class="w-16 h-16 mx-auto mb-4"></i>
                <h1 class="text-5xl font-bold mb-2">{{ isset($servicio) ? 'Editar Servicio' : 'Nuevo Servicio' }}</h1>
                <p class="text-xl text-slate-300">{{ isset($servicio) ? 'Actualiza la información y asigna mano de obra' : 'Registra un nuevo servicio base' }}</p>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <a href="{{ route('mano.de.obra') }}" class="inline-flex items-center text-slate-600 hover:text-slate-800 transition-colors mb-6 font-medium">
            <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i> Volver a Servicios
        </a>

        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-r-lg mb-6 shadow-sm">
                <div class="flex items-center mb-2"><i data-lucide="alert-circle" class="w-5 h-5 mr-2"></i><span class="font-bold">Hay errores en el formulario:</span></div>
                <ul class="list-disc list-inside ml-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-r-lg mb-6 shadow-sm flex items-center">
                <i data-lucide="check-circle" class="w-6 h-6 mr-3 text-emerald-600"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-2xl p-8 shadow-xl border border-slate-100 mb-8">
            <h2 class="text-xl font-bold text-slate-800 mb-6 flex items-center border-b pb-4">
                <i data-lucide="info" class="w-5 h-5 mr-2 text-indigo-500"></i> Información Base
            </h2>

            <form action="{{ isset($servicio) ? route('mano.de.obra.actualizar', $servicio->ID_servicio) : route('mano.de.obra.guardar') }}" method="POST">
                @csrf
                @if(isset($servicio))
                    @method('PUT')
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-1">
                        <label class="block text-slate-700 font-bold mb-2">Nombre del Servicio *</label>
                        <input type="text" name="nombre" value="{{ old('nombre', $servicio->nombre ?? '') }}" required maxlength="50"
                               class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-slate-500 transition-all"
                               placeholder="Ej: Instalación Eléctrica">
                    </div>

                    <div class="md:col-span-1">
                        <label class="block text-slate-700 font-bold mb-2">Categoría *</label>
                        <select name="fk_id_categoria" required class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-slate-500 bg-white transition-all">
                            <option value="">Seleccione una categoría</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->ID_Categoria }}" {{ (old('fk_id_categoria', $servicio->fk_id_categoria ?? '') == $categoria->ID_Categoria) ? 'selected' : '' }}>
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mt-8 flex flex-col sm:flex-row gap-4 pt-6">
                    <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 bg-slate-800 text-white px-8 py-3 rounded-xl hover:bg-slate-900 transition-all shadow-md font-bold">
                        <i data-lucide="save" class="w-5 h-5"></i>
                        {{ isset($servicio) ? 'Actualizar Información Base' : 'Guardar Servicio' }}
                    </button>
                    <a href="{{ route('mano.de.obra') }}" class="flex-1 inline-flex items-center justify-center px-8 py-3 border border-slate-300 text-slate-700 rounded-xl hover:bg-slate-50 transition-all font-semibold">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>

        @if(isset($servicio))
            <div class="bg-white rounded-2xl p-8 shadow-xl border border-slate-100">
                <h3 class="text-xl font-bold text-slate-800 mb-6 flex items-center border-b pb-4">
                    <i data-lucide="users" class="w-6 h-6 mr-3 text-emerald-500"></i>
                    Mano de Obra y Precios
                </h3>

                <form action="{{ route('mano.de.obra.vincularProveedor') }}" method="POST" class="bg-slate-50 p-6 rounded-xl border border-slate-200 mb-8">
                    @csrf
                    <input type="hidden" name="fk_id_servicio" value="{{ $servicio->ID_servicio }}">
                    
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                        <div class="md:col-span-4">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Proveedor / Contratista *</label>
                            <select name="fk_id_proveedor" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                <option value="" disabled selected>Seleccione...</option>
                                @foreach($proveedores as $prov)
                                    <option value="{{ $prov->ID_proveedor }}">{{ $prov->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-3">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Unidad de Medida *</label>
                            <input type="text" name="unidad" required maxlength="15" placeholder="Ej: hora, m2, día, obra" 
                                   class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>
                        
                        <div class="md:col-span-3">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Precio ($) *</label>
                            <input type="number" step="0.01" name="precio" required min="0" placeholder="0.00" 
                                   class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>

                        <div class="md:col-span-2">
                            <button type="submit" class="w-full bg-emerald-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-emerald-700 transition-colors flex items-center justify-center shadow-md">
                                <i data-lucide="plus" class="w-4 h-4 mr-1"></i> Añadir
                            </button>
                        </div>
                    </div>
                </form>

                <div class="overflow-hidden rounded-xl border border-slate-200">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-800 text-white text-sm uppercase tracking-wider">
                                <th class="py-3 px-4 font-bold">Proveedor / Contratista</th>
                                <th class="py-3 px-4 font-bold">Unidad</th>
                                <th class="py-3 px-4 font-bold text-right">Precio</th>
                                <th class="py-3 px-4 font-bold text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white">
                            @forelse($servicio->manoObra as $detalle)
                                @if($detalle->proveedor) 
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="py-3 px-4 font-semibold text-slate-800 flex items-center">
                                        <i data-lucide="user-check" class="w-4 h-4 mr-2 text-slate-400"></i>
                                        {{ $detalle->proveedor->nombre }}
                                    </td>
                                    <td class="py-3 px-4 text-slate-600 font-medium">{{ $detalle->unidad }}</td>
                                    <td class="py-3 px-4 text-emerald-600 font-bold text-right">${{ number_format($detalle->precio, 2) }}</td>
                                    <td class="py-3 px-4 text-center">
                                        <form action="{{ route('mano.de.obra.desvincularProveedor', ['servicio' => $servicio->ID_servicio, 'proveedor' => $detalle->proveedor->ID_proveedor]) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('¿Estás seguro de quitar a este proveedor de este servicio?');" class="text-red-500 hover:text-red-700 transition-colors p-1 bg-red-50 hover:bg-red-100 rounded-lg" title="Desvincular">
                                                <i data-lucide="trash-2" class="w-5 h-5"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endif
                            @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-slate-500 bg-slate-50">
                                    <i data-lucide="users" class="w-8 h-8 mx-auto text-slate-300 mb-2"></i>
                                    Aún no has registrado quién realiza este servicio.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

    </div>
</div>

<script>
    // Inicializar iconos de Lucide
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
    });
</script>
</body>
</html>