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
                <p class="text-xl text-slate-300">Visualiza a tus socios comerciales</p>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        {{-- Volver al inicio --}}
        <a href="{{ auth()->user()->isAdmin() ? route('home') : route('dashboard') }}" class="inline-flex items-center text-slate-600 hover:text-slate-800 transition-colors mb-8">
            <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i>
            Volver {{ auth()->user()->isAdmin() ? 'al Inicio' : 'al Dashboard' }}
        </a>

        {{-- Barra de Herramientas: Búsqueda y Filtros --}}
        <div class="bg-white rounded-2xl p-6 shadow-lg mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center gap-6">
                {{-- Buscador por nombre/contacto --}}
                <div class="flex-1">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Buscar proveedor</label>
                    <div class="relative">
                        <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"></i>
                        <input type="text" id="searchInput" placeholder="Nombre, contacto o correo..."
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-slate-500 focus:border-slate-500 transition-all">
                    </div>
                </div>

                {{-- Filtro por Ubicación (Pendiente #10) --}}
                <div class="w-full lg:w-72">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Filtrar por Ubicación</label>
                    <div class="relative">
                        <i data-lucide="map-pin" class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"></i>
                        <input type="text" id="locationFilter" placeholder="Ciudad, calle o zona..."
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-slate-500 focus:border-slate-500 transition-all">
                    </div>
                </div>

                {{-- Botón Añadir --}}
                <div class="lg:pt-7">
                    <a href="{{ route('proveedores.crear') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-slate-700 to-slate-800 text-white px-8 py-3 rounded-xl hover:shadow-lg transition-all transform hover:-translate-y-0.5 w-full justify-center">
                        <i data-lucide="plus" class="w-5 h-5"></i>
                        Agregar
                    </a>
                </div>
            </div>
        </div>

        {{-- Lista de proveedores --}}
        <div class="bg-white rounded-2xl p-8 shadow-lg">
            <h2 class="text-2xl font-bold text-slate-800 mb-6 flex items-center gap-2">
                <i data-lucide="users" class="w-6 h-6 text-slate-500"></i>
                Proveedores Registrados (<span id="countDisplay">{{ count($proveedores) }})</span>
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6" id="providersGrid">
                @forelse($proveedores as $proveedor)
                {{-- Las clases 'provider-card' y los data-attributes son para el JS --}}
                <div class="provider-card border border-slate-200 rounded-2xl p-6 hover:border-slate-400 hover:shadow-md transition-all"
                     data-name="{{ strtolower($proveedor->nombre . ' ' . $proveedor->nombre_contacto) }}"
                     data-location="{{ strtolower($proveedor->direccion) }}">

                    <div class="flex items-start justify-between mb-4">
                        <div class="h-12 w-12 bg-slate-100 rounded-xl flex items-center justify-center text-slate-600">
                            <i data-lucide="building-2"></i>
                        </div>
                        <span class="bg-slate-100 text-slate-600 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">
                            {{ $proveedor->tipo }}
                        </span>
                    </div>

                    <h3 class="font-bold text-slate-800 text-lg mb-1">{{ $proveedor->nombre }}</h3>
                    <p class="text-slate-500 text-sm mb-4">{{ $proveedor->nombre_contacto }}</p>

                    <div class="space-y-3 mb-6">
                        <div class="flex items-center text-slate-600 text-sm">
                            <i data-lucide="mail" class="w-4 h-4 mr-3 text-slate-400"></i>
                            <span class="truncate">{{ $proveedor->correo_e }}</span>
                        </div>
                        <div class="flex items-center text-slate-600 text-sm">
                            <i data-lucide="phone" class="w-4 h-4 mr-3 text-slate-400"></i>
                            <span>{{ $proveedor->telefono }}</span>
                        </div>
                        <div class="flex items-start text-slate-600 text-sm">
                            <i data-lucide="map-pin" class="w-4 h-4 mr-3 mt-0.5 text-slate-400"></i>
                            <span class="line-clamp-2">{{ $proveedor->direccion }}</span>
                        </div>
                    </div>

                    <div class="flex gap-2 pt-4 border-t border-slate-100">
                        <a href="{{ route('proveedores.editar', $proveedor->ID_proveedor) }}"
                           class="flex-1 bg-white border border-slate-200 text-slate-700 py-2 rounded-lg hover:bg-slate-50 transition-colors text-center text-sm font-medium">
                            Gestionar
                        </a>
                        @if(auth()->user()->isAdmin())
                        <form action="{{ route('proveedores.eliminar', $proveedor->ID_proveedor) }}" method="POST" onsubmit="return confirm('¿Eliminar este proveedor?')" class="flex-shrink-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors">
                                <i data-lucide="trash-2" class="w-5 h-5"></i>
                            </button>
                        </form>
                        @else
                            <!-- no se hace nada -->
                        @endif
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12">
                    <div class="bg-slate-50 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="inbox" class="w-8 h-8 text-slate-400"></i>
                    </div>
                    <p class="text-slate-500 font-medium">No hay proveedores registrados todavía.</p>
                </div>
                @endforelse
            </div>

            {{-- Mensaje si no hay resultados en el filtro --}}
            <div id="noResults" class="hidden text-center py-12">
                <p class="text-slate-500">No se encontraron proveedores que coincidan con tu búsqueda.</p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();

            const searchInput = document.getElementById('searchInput');
            const locationFilter = document.getElementById('locationFilter');
            const cards = document.querySelectorAll('.provider-card');
            const noResults = document.getElementById('noResults');
            const countDisplay = document.getElementById('countDisplay');

            function filterCards() {
                const searchValue = searchInput.value.toLowerCase();
                const locationValue = locationFilter.value.toLowerCase();
                let visibleCount = 0;

                cards.forEach(card => {
                    const name = card.getAttribute('data-name');
                    const location = card.getAttribute('data-location');

                    const matchesSearch = name.includes(searchValue);
                    const matchesLocation = location.includes(locationValue);

                    if (matchesSearch && matchesLocation) {
                        card.style.display = 'block';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                noResults.classList.toggle('hidden', visibleCount > 0);
                countDisplay.textContent = visibleCount + ')';
            }

            searchInput.addEventListener('input', filterCards);
            locationFilter.addEventListener('input', filterCards);
        });
    </script>
</body>
</html>