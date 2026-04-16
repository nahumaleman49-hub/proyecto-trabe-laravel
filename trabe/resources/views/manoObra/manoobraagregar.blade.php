<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Trabajador - Mano de Obra</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="bg-slate-50">

<div x-data="{
    detalles: [{ tipo_trabajo: '', precio_unit: '', cantidad: 1 }],
    agregarDetalle() {
        this.detalles.push({ tipo_trabajo: '', precio_unit: '', cantidad: 1 });
    },
    quitarDetalle(index) {
        if (this.detalles.length > 1) {
            this.detalles.splice(index, 1);
        }
    }
}" class="min-h-screen py-8">
    <div class="container mx-auto px-4 max-w-3xl">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-3xl font-bold text-slate-800">Agregar Nuevo Trabajador</h1>
                <a href="{{ route('mano.de.obra') }}" class="text-slate-600 hover:text-slate-800">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </a>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('mano.de.obra.guardar') }}" method="POST">
                @csrf

                {{-- Datos del trabajador --}}
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-slate-700 mb-4">Información Personal</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-slate-700 font-medium mb-1">Nombre completo *</label>
                            <input type="text" name="nombre" value="{{ old('nombre') }}" required
                                class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-slate-500">
                        </div>
                        <div>
                            <label class="block text-slate-700 font-medium mb-1">Teléfono *</label>
                            <input type="number" name="telefono" value="{{ old('telefono') }}" required
                                class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-slate-500">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-slate-700 font-medium mb-1">Dirección *</label>
                            <input type="text" name="direccion" value="{{ old('direccion') }}" required
                                class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-slate-500">
                        </div>
                    </div>
                </div>

                {{-- Detalles de servicios --}}
                <div class="mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold text-slate-700">Servicios Ofrecidos</h2>
                        <button type="button" @click="agregarDetalle"
                            class="bg-slate-600 text-white px-3 py-1 rounded-lg text-sm hover:bg-slate-700">
                            + Agregar otro servicio
                        </button>
                    </div>

                    <template x-for="(detalle, idx) in detalles" :key="idx">
                        <div class="border border-slate-200 rounded-lg p-4 mb-4 relative">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-slate-700 font-medium mb-1">Tipo de trabajo *</label>
                                    <input type="text" :name="'detalles['+idx+'][tipo_trabajo]'" required
                                        class="w-full border border-slate-300 rounded-lg px-4 py-2">
                                </div>
                                <div>
                                    <label class="block text-slate-700 font-medium mb-1">Precio unitario *</label>
                                    <input type="number" step="0.01" :name="'detalles['+idx+'][precio_unit]'" required
                                        class="w-full border border-slate-300 rounded-lg px-4 py-2">
                                </div>
                                <div>
                                    <label class="block text-slate-700 font-medium mb-1">Cantidad *</label>
                                    <input type="number" min="1" :name="'detalles['+idx+'][cantidad]'" required
                                        class="w-full border border-slate-300 rounded-lg px-4 py-2">
                                </div>
                            </div>
                            <button type="button" @click="quitarDetalle(idx)" x-show="detalles.length > 1"
                                class="absolute top-2 right-2 text-red-500 hover:text-red-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </template>
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('mano.de.obra') }}" class="px-6 py-2 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-100">Cancelar</a>
                    <button type="submit" class="px-6 py-2 bg-slate-700 text-white rounded-lg hover:bg-slate-800">Guardar Trabajador</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>