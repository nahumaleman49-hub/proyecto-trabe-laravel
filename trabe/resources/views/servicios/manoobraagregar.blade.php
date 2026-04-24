<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($servicio) ? 'Editar Servicio' : 'Nuevo Servicio' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-50">

<div x-data="{
    manoObra: {{ isset($servicio) ? json_encode($servicio->manoObra->map(function($item) { return ['fk_id_proveedor' => $item->fk_id_proveedor, 'unidad' => $item->unidad, 'precio' => $item->precio]; })->toArray()) : '[]' }},
    proveedores: {{ Js::from($proveedores) }},
    addManoObra() {
        this.manoObra.push({ fk_id_proveedor: '', unidad: '', precio: 0 });
    },
    removeManoObra(index) {
        this.manoObra.splice(index, 1);
    }
}" class="min-h-screen">

    <div class="relative h-64 overflow-hidden bg-gradient-to-r from-slate-700 to-slate-800">
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white">
                <i data-lucide="briefcase" class="w-16 h-16 mx-auto mb-4"></i>
                <h1 class="text-5xl font-bold mb-2">{{ isset($servicio) ? 'Editar Servicio' : 'Nuevo Servicio' }}</h1>
                <p class="text-xl text-slate-300">{{ isset($servicio) ? 'Actualiza la información' : 'Registra un nuevo servicio' }}</p>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <a href="{{ route('mano.de.obra') }}" class="inline-flex items-center text-slate-600 hover:text-slate-800 transition-colors mb-8">
            <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i>
            Volver a Servicios
        </a>

        <div class="bg-white rounded-2xl p-8 shadow-lg">
            <form action="{{ isset($servicio) ? route('mano.de.obra.actualizar', $servicio->ID_servicio) : route('mano.de.obra.guardar') }}" method="POST">
                @csrf
                @if(isset($servicio)) @method('PUT') @endif

                <div class="space-y-6">
                    <div>
                        <label class="block text-slate-700 font-semibold mb-2">Nombre del Servicio *</label>
                        <input type="text" name="nombre" value="{{ old('nombre', $servicio->nombre ?? '') }}" required maxlength="50"
                               class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-500">
                    </div>

                    <div>
                        <label class="block text-slate-700 font-semibold mb-2">Categoría *</label>
                        <select name="fk_id_categoria" required class="w-full px-4 py-3 border border-slate-300 rounded-lg">
                            <option value="">Seleccione una categoría</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->ID_Categoria }}" {{ (old('fk_id_categoria', $servicio->fk_id_categoria ?? '') == $categoria->ID_Categoria) ? 'selected' : '' }}>
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-4">
                            <label class="block text-slate-700 font-semibold">Proveedores y Precios *</label>
                            <button type="button" @click="addManoObra" class="bg-slate-600 text-white px-3 py-1 rounded-lg text-sm hover:bg-slate-700">
                                + Agregar proveedor
                            </button>
                        </div>

                        <template x-for="(item, idx) in manoObra" :key="idx">
                            <div class="border border-slate-200 rounded-lg p-4 mb-4 relative">
                                <button type="button" @click="removeManoObra(idx)" class="absolute top-2 right-2 text-red-500 hover:text-red-700">
                                    <i data-lucide="x" class="w-5 h-5"></i>
                                </button>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-1">Proveedor *</label>
                                        <select :name="'mano_obra['+idx+'][fk_id_proveedor]'" x-model="item.fk_id_proveedor" required class="w-full px-3 py-2 border rounded-lg">
                                            <option value="">Seleccione</option>
                                            <template x-for="prov in proveedores">
                                                <option :value="prov.ID_proveedor" x-text="prov.nombre"></option>
                                            </template>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-1">Unidad *</label>
                                        <input type="text" :name="'mano_obra['+idx+'][unidad]'" x-model="item.unidad" required maxlength="15"
                                               placeholder="Ej: hora, m2, día" class="w-full px-3 py-2 border rounded-lg">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-1">Precio *</label>
                                        <input type="number" step="0.01" :name="'mano_obra['+idx+'][precio]'" x-model="item.precio" required min="0"
                                               placeholder="0.00" class="w-full px-3 py-2 border rounded-lg">
                                    </div>
                                </div>
                            </div>
                        </template>

                        <div x-show="manoObra.length === 0" class="text-center py-4 text-slate-500">
                            No hay proveedores agregados. Haga clic en "+ Agregar proveedor".
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex gap-4">
                    <button type="submit" class="inline-flex items-center gap-2 bg-gradient-to-r from-slate-700 to-slate-800 text-white px-8 py-3 rounded-lg hover:shadow-lg">
                        <i data-lucide="save" class="w-5 h-5"></i>
                        {{ isset($servicio) ? 'Actualizar Servicio' : 'Guardar Servicio' }}
                    </button>
                    <a href="{{ route('mano.de.obra') }}" class="px-8 py-3 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
        });
    </script>
</body>
</html>