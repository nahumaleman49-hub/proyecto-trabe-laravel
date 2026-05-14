<<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QOSTO - Clientes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
    </style>
</head>
<body class="bg-slate-50">

    <div class="relative h-64 overflow-hidden bg-gradient-to-r from-slate-700 to-slate-800">
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white">
                <i data-lucide="users" class="w-16 h-16 mx-auto mb-4"></i>
                <h1 class="text-5xl font-bold mb-2">Clientes</h1>
                <p class="text-xl text-slate-300">Administra tu cartera y consulta sus proyectos</p>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <a href="{{ route('home') }}" class="inline-flex items-center text-slate-600 hover:text-slate-800 transition-colors mb-8">
            <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i>
            Volver al Inicio
        </a>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-8 rounded-r-lg shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl p-6 shadow-lg mb-8 flex flex-col md:flex-row items-center gap-4">
            <div class="relative flex-1 w-full">
                <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"></i>
                <input type="text" id="searchInput" placeholder="Buscar por nombre o teléfono..." 
                    class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-slate-500 outline-none transition-all">
            </div>
            <a href="{{ route('clientes.agregar') }}" class="w-full md:w-auto inline-flex items-center justify-center gap-2 bg-slate-800 text-white px-8 py-3 rounded-xl hover:bg-slate-900 transition-all shadow-md">
                <i data-lucide="user-plus" class="w-5 h-5"></i>
                Agregar
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="clientesGrid">
            @forelse($clientes as $cliente)
                <div class="cliente-card bg-white rounded-2xl border border-slate-200 overflow-hidden card-hover" 
                     data-search="{{ strtolower($cliente->nombre . ' ' . $cliente->telefono) }}">
                    
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div class="h-12 w-12 bg-slate-100 rounded-xl flex items-center justify-center text-slate-600">
                                <i data-lucide="user"></i>
                            </div>
                            <span class="text-xs font-mono text-slate-400">Cliente: {{ $cliente->ID_cliente }}</span>
                        </div>

                        <h3 class="text-xl font-bold text-slate-800 mb-1">{{ $cliente->nombre }}</h3>
                        
                        <div class="space-y-3 mt-4">
                            <div class="flex items-center text-slate-600 text-sm">
                                <i data-lucide="phone" class="w-4 h-4 mr-3 text-slate-400"></i>
                                {{ $cliente->telefono }}
                            </div>
                            <div class="flex items-start text-slate-600 text-sm">
                                <i data-lucide="mail" class="w-4 h-4 mr-3 mt-0.5 text-slate-400"></i>
                                <span class="line-clamp-2">{{ $cliente->email }}</span>
                            </div>
                            <div class="flex items-start text-slate-600 text-sm">
                                <i data-lucide="map-pin" class="w-4 h-4 mr-3 mt-0.5 text-slate-400"></i>
                                <span class="line-clamp-2">{{ $cliente->direccion }}</span>
                            </div>
                        </div>

                        <div class="mt-6 pt-6 border-t border-slate-100">
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Proyectos</h4>
                                <span class="bg-slate-100 text-slate-600 px-2 py-0.5 rounded text-xs font-bold">
                                    {{ count($cliente->proyectos) }}
                                </span>
                            </div>
                            
                            <ul class="space-y-2">
                                @forelse($cliente->proyectos as $proy)
                                    <li class="flex items-center justify-between text-sm bg-slate-50 p-2 rounded-lg border border-slate-100">
                                        <span class="text-slate-700 truncate mr-2">{{ $proy->nombre }}</span>
                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $proy->estado == 'Activo' ? 'bg-green-100 text-green-700' : 'bg-slate-200 text-slate-600' }}">
                                            {{ $proy->estado }}
                                        </span>
                                    </li>
                                @empty
                                    <li class="text-slate-400 text-xs italic text-center py-2">Sin proyectos registrados</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                    <div class="bg-slate-50 px-6 py-4 flex gap-2">
                        <a href="{{ route('clientes.modificar', $cliente->ID_cliente) }}" 
                           class="flex-1 bg-white border border-slate-200 text-slate-700 py-2 rounded-lg text-center text-sm font-bold hover:bg-slate-100 transition-colors">
                            Gestionar
                        </a>
                        <form action="{{ route('clientes.eliminar', $cliente->ID_cliente) }}" method="POST" onsubmit="return confirm('¿Eliminar cliente y sus datos asociados?')" class="flex-shrink-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all">
                                <i data-lucide="trash-2" class="w-5 h-5"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-20 bg-white rounded-2xl border-2 border-dashed border-slate-200">
                    <i data-lucide="inbox" class="w-12 h-12 mx-auto text-slate-300 mb-4"></i>
                    <p class="text-slate-500 font-medium">No se encontraron clientes registrados.</p>
                </div>
            @endforelse
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();

            // Buscador en tiempo real
            const searchInput = document.getElementById('searchInput');
            const cards = document.querySelectorAll('.cliente-card');

            searchInput.addEventListener('input', function() {
                const term = this.value.toLowerCase();
                cards.forEach(card => {
                    const searchData = card.getAttribute('data-search');
                    card.style.display = searchData.includes(term) ? 'block' : 'none';
                });
            });
        });
    </script>
</body>
</html>