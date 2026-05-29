<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QOSTO - Cotizaciones</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-50">

    {{-- Cabecera con gradiente --}}
    <div class="relative h-64 overflow-hidden bg-gradient-to-r from-slate-700 to-slate-800">
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white">
                <i data-lucide="file-text" class="w-16 h-16 mx-auto mb-4"></i>
                <h1 class="text-5xl font-bold mb-2">Cotizaciones</h1>
                <p class="text-xl text-slate-300">Gestiona tus estimaciones de proyectos</p>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        {{-- Botón volver al inicio --}}
        <a href="{{ auth()->user()->isAdmin() ? route('home') : route('dashboard') }}" class="inline-flex items-center text-slate-600 hover:text-slate-800 transition-colors mb-8">
            <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i>
            Volver {{ auth()->user()->isAdmin() ? 'al Inicio' : 'al Dashboard' }}
        </a>

        {{-- Sección crear nueva cotización --}}
        <div class="bg-white rounded-2xl p-8 shadow-lg mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-bold text-slate-800 mb-2">Crear Cotización</h2>
                    <p class="text-slate-600 text-lg">Genera una cotización detallada para tu próximo proyecto de construcción</p>
                </div>
                <a href="{{ route('cotizaciones.nueva') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-slate-700 to-slate-800 text-white px-8 py-3 rounded-lg hover:shadow-lg transition-shadow">
                    <i data-lucide="plus" class="w-5 h-5"></i>
                    Nueva
                </a>
            </div>
        </div>

        {{-- Historial de cotizaciones --}}
        <div class="bg-white rounded-2xl p-8 shadow-lg">
            <h2 class="text-3xl font-bold text-slate-800 mb-6">Historial de Cotizaciones</h2>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-200">
                            <th class="text-left py-4 px-4 text-slate-700 font-semibold">ID</th>
                            <th class="text-left py-4 px-4 text-slate-700 font-semibold">Proyecto</th>
                            <th class="text-left py-4 px-4 text-slate-700 font-semibold">Cliente</th>
                            <th class="text-left py-4 px-4 text-slate-700 font-semibold">Fecha</th>
                            <th class="text-left py-4 px-4 text-slate-700 font-semibold">Valor</th>
                            <th class="text-left py-4 px-4 text-slate-700 font-semibold">Estado</th>
                            <th class="text-left py-4 px-4 text-slate-700 font-semibold text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($cotizaciones as $cot)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="py-4 px-4 font-medium text-slate-900">#{{ $cot->ID_cotizacion }}</td>
                                <td class="py-4 px-4 text-slate-600">{{ $cot->proyecto->nombre ?? 'Sin Proyecto' }}</td>
                                <td class="py-4 px-4 text-slate-600">{{ $cot->proyecto->cliente->nombre ?? 'N/A' }}</td>
                                <td class="py-4 px-4 text-slate-600">{{ \Carbon\Carbon::parse($cot->fecha)->format('d/m/Y') }}</td>
                                <td class="py-4 px-4 font-bold text-slate-800">${{ number_format($cot->total, 2) }}</td>
                                <td class="py-4 px-4">
                                    @php
                                        $estados = [0 => 'Borrador', 1 => 'Enviada', 2 => 'Aprobada', 3 => 'Rechazada'];
                                        $clases = [
                                            0 => 'bg-slate-100 text-slate-600 border-slate-200',
                                            1 => 'bg-blue-50 text-blue-700 border-blue-200',
                                            2 => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                            3 => 'bg-red-50 text-red-700 border-red-200'
                                        ];
                                        $estadoLabel = $estados[$cot->estado] ?? 'Desconocido';
                                        $claseEstado = $clases[$cot->estado] ?? 'bg-gray-100';
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold border {{ $claseEstado }}">
                                        {{ $estadoLabel }}
                                    </span>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center justify-center gap-3">
                                        <a href="{{ route('cotizaciones.ver', $cot->ID_cotizacion) }}" class="p-2 text-slate-400 hover:text-slate-800 title="Ver Detalle">
                                            <i data-lucide="eye" class="w-5 h-5"></i>
                                        </a>
                                        <a href="{{ route('cotizaciones.editar', $cot->ID_cotizacion) }}" class="p-2 text-slate-400 hover:text-blue-600" title="Editar">
                                            <i data-lucide="edit-3" class="w-5 h-5"></i>
                                        </a>
                                        <a href="{{ route('cotizaciones.pdf', $cot->ID_cotizacion) }}" class="p-2 text-slate-400 hover:text-red-600" title="Descargar PDF">
                                            <i data-lucide="file-down" class="w-5 h-5"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-12">
                                    <div class="flex flex-col items-center text-slate-400">
                                        <i data-lucide="inbox" class="w-12 h-12 mb-2"></i>
                                        <p class="text-lg">No se encontraron cotizaciones registradas</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
        });
    </script>
</body>
</html>