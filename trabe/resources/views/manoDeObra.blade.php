<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QOSTO - Mano de Obra</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-50">

    {{-- Cabecera --}}
    <div class="relative h-64 overflow-hidden bg-gradient-to-r from-slate-700 to-slate-800">
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white">
                <i data-lucide="users" class="w-16 h-16 mx-auto mb-4"></i>
                <h1 class="text-5xl font-bold mb-2">Mano de Obra</h1>
                <p class="text-xl text-slate-300">Directorio de personal calificado</p>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <a href="{{ route('home') }}" class="inline-flex items-center text-slate-600 hover:text-slate-800 transition-colors mb-8">
            <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i>
            Volver al Inicio
        </a>

        {{-- Barra de búsqueda --}}
        <div class="bg-white rounded-xl p-6 shadow-lg mb-6">
            <div class="relative">
                <i data-lucide="search" class="absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-400 w-5 h-5"></i>
                <input type="text" id="searchInput" placeholder="Buscar por nombre o especialidad..." class="w-full pl-12 pr-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent">
            </div>
        </div>

        {{-- Filtros por área --}}
        <div class="bg-white rounded-xl p-6 shadow-lg mb-8">
            <h2 class="text-xl font-bold text-slate-800 mb-4">Filtrar por Área</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3" id="areaFilters">
                @php
                    $areas = [
                        ['id' => 'all', 'name' => 'Todos', 'icon' => '👷'],
                        ['id' => 'estructura', 'name' => 'Estructura', 'icon' => '🏗️'],
                        ['id' => 'albanileria', 'name' => 'Albañilería', 'icon' => '🧱'],
                        ['id' => 'acabados', 'name' => 'Acabados', 'icon' => '🎨'],
                        ['id' => 'instalaciones', 'name' => 'Instalaciones', 'icon' => '🔧'],
                        ['id' => 'especializado', 'name' => 'Especializado', 'icon' => '⚡']
                    ];
                @endphp
                @foreach($areas as $area)
                <button data-area="{{ $area['id'] }}" class="filter-area p-4 rounded-lg border-2 border-slate-200 hover:border-slate-400 transition-all">
                    <div class="text-3xl mb-2">{{ $area['icon'] }}</div>
                    <div class="text-sm font-semibold">{{ $area['name'] }}</div>
                </button>
                @endforeach
            </div>
        </div>

        {{-- Resultados --}}
        <div class="bg-white rounded-xl p-6 shadow-lg">
            <h2 class="text-2xl font-bold text-slate-800 mb-6" id="resultCount">Cargando trabajadores...</h2>
            <div id="workersContainer" class="space-y-4">
                {{-- Los trabajadores se cargarán dinámicamente desde JavaScript --}}
            </div>
        </div>
    </div>

    {{-- Datos de trabajadores (enviados desde el controlador) --}}
    <script>
        // Convertir los trabajadores de PHP a JavaScript
        const workersData = @json($trabajadores);

        // Función para mostrar tarifa según tipo
        function getTarifaDisplay(worker) {
            if (worker.tipo_tarifa === 'hora') return `$${worker.tarifa}/hora`;
            if (worker.tipo_tarifa === 'dia') return `$${worker.tarifa}/día`;
            if (worker.tipo_tarifa === 'm2') return `$${worker.tarifa_m2}/m²`;
            return 'Por cotizar';
        }

        // Renderizar tarjetas de trabajadores
        function renderWorkers(workers) {
            const container = document.getElementById('workersContainer');
            if (workers.length === 0) {
                container.innerHTML = '<div class="text-center py-8 text-slate-500">No se encontraron trabajadores.</div>';
                document.getElementById('resultCount').innerText = '0 Trabajadores Disponibles';
                return;
            }

            let html = '';
            workers.forEach(worker => {
                const disponibilidadClass = worker.disponibilidad === 'Disponible' 
                    ? 'bg-green-100 text-green-700' 
                    : 'bg-red-100 text-red-700';
                html += `
                    <div class="border border-slate-200 rounded-xl p-6 hover:border-slate-400 transition-colors">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <h3 class="text-2xl font-bold text-slate-800">${worker.nombre}</h3>
                                    <div class="flex items-center bg-yellow-100 px-2 py-1 rounded-full">
                                        <i data-lucide="star" class="w-4 h-4 text-yellow-600 mr-1 fill-yellow-600"></i>
                                        <span class="text-sm font-semibold text-yellow-700">${worker.calificacion}</span>
                                    </div>
                                    <span class="px-3 py-1 rounded-full text-sm font-medium ${disponibilidadClass}">${worker.disponibilidad}</span>
                                </div>
                                <p class="text-lg font-semibold text-slate-700 mb-2">${worker.especialidad}</p>
                                <p class="text-slate-600 mb-3">${worker.descripcion}</p>
                            </div>
                            <div class="text-right ml-6">
                                <p class="text-sm text-slate-600 mb-1">Tarifa aproximada</p>
                                <p class="text-3xl font-bold text-slate-700">${getTarifaDisplay(worker)}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 bg-slate-50 rounded-lg p-4">
                            <div class="flex items-center gap-2">
                                <i data-lucide="clock" class="w-4 h-4 text-slate-600"></i>
                                <div>
                                    <p class="text-xs text-slate-600">Experiencia</p>
                                    <p class="font-semibold text-slate-800">${worker.experiencia}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <i data-lucide="map-pin" class="w-4 h-4 text-slate-600"></i>
                                <div>
                                    <p class="text-xs text-slate-600">Ubicación</p>
                                    <p class="font-semibold text-slate-800">${worker.ubicacion}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <i data-lucide="dollar-sign" class="w-4 h-4 text-slate-600"></i>
                                <div>
                                    <p class="text-xs text-slate-600">Modalidad</p>
                                    <p class="font-semibold text-slate-800">
                                        ${worker.tipo_tarifa === 'hora' ? 'Por hora' : 
                                          worker.tipo_tarifa === 'dia' ? 'Por día' :
                                          worker.tipo_tarifa === 'm2' ? 'Por m²' : 'Por proyecto'}
                                    </p>
                                </div>
                            </div>
                        </div>
                        ${worker.certificaciones && worker.certificaciones.length ? `
                        <div class="mb-4">
                            <p class="text-sm font-semibold text-slate-700 mb-2">Certificaciones:</p>
                            <div class="flex flex-wrap gap-2">
                                ${worker.certificaciones.map(cert => `<span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm">${cert}</span>`).join('')}
                            </div>
                        </div>
                        ` : ''}
                        <div class="mb-4">
                            <p class="text-sm font-semibold text-slate-700 mb-2">Tipo de proyectos:</p>
                            <div class="flex flex-wrap gap-2">
                                ${worker.proyectos.map(proj => `<span class="bg-slate-100 text-slate-700 px-3 py-1 rounded-full text-sm">${proj}</span>`).join('')}
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <button class="flex-1 bg-slate-700 text-white py-3 rounded-lg hover:bg-slate-800 transition-colors font-semibold">Contactar</button>
                            <button class="px-6 bg-slate-100 text-slate-700 py-3 rounded-lg hover:bg-slate-200 transition-colors font-semibold">Ver Perfil</button>
                        </div>
                    </div>
                `;
            });
            container.innerHTML = html;
            document.getElementById('resultCount').innerText = `${workers.length} Trabajadores Disponibles`;
            lucide.createIcons(); // recrear íconos para los nuevos elementos
        }

        // Filtrar trabajadores según área y texto de búsqueda
        function filterWorkers() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const selectedArea = document.querySelector('.filter-area.active')?.getAttribute('data-area') || 'all';
            const filtered = workersData.filter(worker => {
                const matchesArea = selectedArea === 'all' || worker.area === selectedArea;
                const matchesSearch = worker.nombre.toLowerCase().includes(searchTerm) ||
                                      worker.especialidad.toLowerCase().includes(searchTerm);
                return matchesArea && matchesSearch;
            });
            renderWorkers(filtered);
        }

        // Inicializar filtros
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();

            // Configurar botones de área
            const areaButtons = document.querySelectorAll('.filter-area');
            areaButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    areaButtons.forEach(b => b.classList.remove('active', 'border-slate-700', 'bg-slate-700', 'text-white'));
                    btn.classList.add('active', 'border-slate-700', 'bg-slate-700', 'text-white');
                    filterWorkers();
                });
            });
            // Seleccionar "Todos" por defecto
            document.querySelector('.filter-area[data-area="all"]').classList.add('active', 'border-slate-700', 'bg-slate-700', 'text-white');

            // Escuchar cambios en la búsqueda
            document.getElementById('searchInput').addEventListener('input', filterWorkers);

            // Render inicial
            filterWorkers();
        });
    </script>
</body>
</html>