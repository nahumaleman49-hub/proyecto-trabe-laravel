<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mano de Obra - Directorio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="bg-slate-50">

<div x-data="{
    selectedTipo: 'all',
    searchTerm: '',
    trabajadores: {{ Js::from($trabajadores) }},
    tiposTrabajo: {{ Js::from($tiposTrabajo) }},
    showModal: false,
    trabajadorActual: null,
    get trabajadoresFiltrados() {
        return this.trabajadores.filter(t => {
            const matchTipo = this.selectedTipo === 'all' || 
                t.detalles.some(d => d.tipo_trabajo === this.selectedTipo);
            const matchSearch = t.nombre.toLowerCase().includes(this.searchTerm.toLowerCase()) ||
                t.detalles.some(d => d.tipo_trabajo.toLowerCase().includes(this.searchTerm.toLowerCase()));
            return matchTipo && matchSearch;
        });
    },
    abrirContacto(trabajador) {
        this.trabajadorActual = trabajador;
        this.showModal = true;
    }
}" x-cloak class="min-h-screen">

    {{-- Header --}}
    <div class="relative h-64 overflow-hidden bg-gradient-to-r from-slate-700 to-slate-800">
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <h1 class="text-5xl font-bold mb-2">Mano de Obra</h1>
                <p class="text-xl text-slate-300">Directorio de personal calificado</p>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        {{-- Botón volver a inicio --}}
        <a href="{{ route('home') }}" class="inline-flex items-center text-slate-600 hover:text-slate-800 transition-colors mb-8">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Volver al Inicio
        </a>
        <a href="{{ route('mano.de.obra.agregar') }}" class="inline-flex items-center bg-slate-600 text-white px-4 py-2 rounded-lg hover:bg-slate-700 transition-colors mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Agregar Trabajador
        </a>

        {{-- Búsqueda --}}
        <div class="bg-white rounded-xl p-6 shadow-lg mb-6">
            <div class="relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-400 w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" x-model="searchTerm" placeholder="Buscar por nombre o tipo de trabajo..."
                    class="w-full pl-12 pr-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent">
            </div>
        </div>

        {{-- Filtros por tipo de trabajo --}}
        <div class="bg-white rounded-xl p-6 shadow-lg mb-8">
            <h2 class="text-xl font-bold text-slate-800 mb-4">Filtrar por Tipo de Trabajo</h2>
            <div class="flex flex-wrap gap-3">
                <button @click="selectedTipo = 'all'"
                    :class="selectedTipo === 'all' ? 'bg-slate-700 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'"
                    class="px-4 py-2 rounded-full transition-colors">
                    Todos
                </button>
                <template x-for="tipo in tiposTrabajo" :key="tipo">
                    <button @click="selectedTipo = tipo"
                        :class="selectedTipo === tipo ? 'bg-slate-700 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'"
                        class="px-4 py-2 rounded-full transition-colors" x-text="tipo">
                    </button>
                </template>
            </div>
        </div>

        {{-- Resultados --}}
        <div class="bg-white rounded-xl p-6 shadow-lg">
            <h2 class="text-2xl font-bold text-slate-800 mb-6" x-text="trabajadoresFiltrados.length + ' Trabajadores Disponibles'"></h2>

            <div class="space-y-4">
                <template x-for="trabajador in trabajadoresFiltrados" :key="trabajador.ID_mano_obra_contac">
                    <div class="border border-slate-200 rounded-xl p-6 hover:border-slate-400 transition-colors">
                        <div class="flex flex-col md:flex-row justify-between mb-4">
                            <div class="flex-1">
                                <h3 class="text-2xl font-bold text-slate-800" x-text="trabajador.nombre"></h3>
                                <p class="text-slate-600 mt-1" x-text="trabajador.direccion"></p>
                            </div>
                            <div class="mt-2 md:mt-0 text-left md:text-right">
                                <p class="text-sm text-slate-600">Teléfono</p>
                                <p class="text-xl font-semibold text-slate-700" x-text="trabajador.telefono"></p>
                            </div>
                        </div>

                        {{-- Servicios --}}
                        <div class="mb-4">
                            <p class="text-lg font-semibold text-slate-700 mb-2">Servicios ofrecidos:</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <template x-for="detalle in trabajador.detalles" :key="detalle.ID_mano_obra">
                                    <div class="bg-slate-50 rounded-lg p-3 flex justify-between items-center">
                                        <div>
                                            <p class="font-semibold text-slate-800" x-text="detalle.tipo_trabajo"></p>
                                            <p class="text-sm text-slate-600">Cantidad: <span x-text="detalle.cantidad"></span></p>
                                        </div>
                                        <p class="text-lg font-bold text-slate-700">$<span x-text="detalle.precio_unit"></span></p>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <button @click="abrirContacto(trabajador)" class="w-full bg-slate-700 text-white py-3 rounded-lg hover:bg-slate-800 transition-colors font-semibold">
                            Contactar
                        </button>
                    </div>
                </template>
                <div x-show="trabajadoresFiltrados.length === 0" class="text-center py-12 text-slate-500">
                    No se encontraron trabajadores con esos criterios.
                </div>
            </div>
        </div>
    </div>

    {{-- Modal de contacto --}}
    <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50" x-cloak>
        <div class="bg-white rounded-xl max-w-md w-full p-6 shadow-2xl">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-2xl font-bold text-slate-800" x-text="trabajadorActual?.nombre"></h3>
                <button @click="showModal = false" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    <a :href="'tel:' + trabajadorActual?.telefono" class="text-blue-600 hover:underline" x-text="trabajadorActual?.telefono"></a>
                </div>
            </div>
            <div class="mt-6 flex justify-end">
                <button @click="showModal = false" class="px-4 py-2 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

</body>
</html>