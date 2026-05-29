<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - QOSTO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gradient-to-b from-slate-800 to-slate-900 text-white flex flex-col">
            <div class="p-6 border-b border-slate-700">
                <h1 class="text-2xl font-bold">QOSTO</h1>
                <p class="text-sm text-slate-400">Panel de Usuario</p>
            </div>
            <nav class="flex-1 py-4">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-6 py-3 bg-slate-700/50">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('cotizaciones') }}" class="flex items-center gap-3 px-6 py-3 hover:bg-slate-700/50 transition">
                    <i data-lucide="file-text" class="w-5 h-5"></i>
                    <span>Cotizaciones</span>
                </a>
                <a href="{{ route('clientes') }}" class="flex items-center gap-3 px-6 py-3 hover:bg-slate-700/50 transition">
                    <i data-lucide="users" class="w-5 h-5"></i>
                    <span>Clientes</span>
                </a>
                <a href="{{ route('proyectos') }}" class="flex items-center gap-3 px-6 py-3 hover:bg-slate-700/50 transition">
                    <i data-lucide="briefcase" class="w-5 h-5"></i>
                    <span>Proyectos</span>
                </a>
                <a href="{{ route('proveedores') }}" class="flex items-center gap-3 px-6 py-3 hover:bg-slate-700/50 transition">
                    <i data-lucide="truck" class="w-5 h-5"></i>
                    <span>Proveedores</span>
                </a>
                <a href="{{ route('materiales.index') }}" class="flex items-center gap-3 px-6 py-3 hover:bg-slate-700/50 transition">
                    <i data-lucide="package" class="w-5 h-5"></i>
                    <span>Materiales</span>
                </a>
                <a href="{{ route('mano.de.obra') }}" class="flex items-center gap-3 px-6 py-3 hover:bg-slate-700/50 transition">
                    <i data-lucide="Hard-Hat" class="w-5 h-5"></i>
                    <span>Mano de Obra</span>
                </a>
            </nav>
            <div class="p-4 border-t border-slate-700">
                <div class="flex items-center gap-3">
                    <i data-lucide="user" class="w-5 h-5"></i>
                    <span class="text-sm">{{ Auth::user()->name }}</span>
                </div>
                <form method="GET" action="{{ route('perfil') }}">
                        <button class= "flex items-center gap-3 text-sm text-slate-300 hover:text-white">
                            <i data-lucide="settings" class="w-4 h-4"></i>
                            Mi Perfil
                        </button>
                </form>
                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 text-sm text-slate-300 hover:text-white">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main content -->
        <main class="flex-1 overflow-y-auto">
            <div class="p-8">
                <h1 class="text-3xl font-bold text-slate-800 mb-6">Bienvenido, {{ Auth::user()->name }}</h1>

                <!-- Cotizaciones recientes -->
                <div class="bg-white rounded-2xl p-6 shadow-lg">
                    <h2 class="text-xl font-bold text-slate-800 mb-4">📋 Cotizaciones recientes</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-slate-200">
                                    <th class="text-left py-3 px-2">ID</th>
                                    <th class="text-left py-3 px-2">Proyecto</th>
                                    <th class="text-left py-3 px-2">Cliente</th>
                                    <th class="text-left py-3 px-2">Fecha</th>
                                    <th class="text-left py-3 px-2">Total</th>
                                    <th class="text-left py-3 px-2">Estado</th>
                                    <th class="text-left py-3 px-2">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cotizaciones as $cotizacion)
                                <tr class="border-b border-slate-100 hover:bg-slate-50">
                                    <td class="py-3 px-2">{{ $cotizacion->ID_cotizacion }}</td>
                                    <td class="py-3 px-2">{{ $cotizacion->proyecto->nombre ?? 'N/A' }}</td>
                                    <td class="py-3 px-2">{{ $cotizacion->proyecto->cliente->nombre ?? 'N/A' }}</td>
                                    <td class="py-3 px-2">{{ \Carbon\Carbon::parse($cotizacion->fecha)->format('d/m/Y') }}</td>
                                    <td class="py-3 px-2">${{ number_format($cotizacion->total, 2) }}</td>
                                    <td class="py-3 px-2">
                                        @php
                                            $estados = ['Borrador', 'Enviada', 'Aprobada', 'Rechazada'];
                                            $clase = match($cotizacion->estado) {
                                                0 => 'bg-slate-100 text-slate-700',
                                                1 => 'bg-blue-100 text-blue-700',
                                                2 => 'bg-green-100 text-green-700',
                                                3 => 'bg-red-100 text-red-700',
                                                default => 'bg-slate-100'
                                            };
                                        @endphp
                                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $clase }}">{{ $estados[$cotizacion->estado] ?? 'Desconocido' }}</span>
                                    </td>
                                    <td class="py-3 px-2">
                                        <a href="{{ route('cotizaciones.ver', $cotizacion->ID_cotizacion) }}" class="text-slate-600 hover:text-slate-800">
                                            <i data-lucide="eye" class="w-4 h-4"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-slate-500">No hay cotizaciones registradas.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>