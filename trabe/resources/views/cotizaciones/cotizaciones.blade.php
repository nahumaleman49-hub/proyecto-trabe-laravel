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
        <a href="{{ route('home') }}" class="inline-flex items-center text-slate-600 hover:text-slate-800 transition-colors mb-8">
            <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i>
            Volver al Inicio
        </a>

        {{-- Sección crear nueva cotización --}}
        <div class="bg-white rounded-2xl p-8 shadow-lg mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-bold text-slate-800 mb-2">Crear Nueva Cotización</h2>
                    <p class="text-slate-600 text-lg">Genera una cotización detallada para tu próximo proyecto de construcción</p>
                </div>
                    <a href="{{ route('cotizaciones.nueva') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-slate-700 to-slate-800 text-white px-8 py-3 rounded-lg hover:shadow-lg transition-shadow">
                    <i data-lucide="plus" class="w-5 h-5"></i>
                    Nueva Cotización
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
                            <th class="text-left py-4 px-4 text-slate-700 font-semibold">ID Cotización</th>
                            <th class="text-left py-4 px-4 text-slate-700 font-semibold">Nombre del Proyecto</th>
                            <th class="text-left py-4 px-4 text-slate-700 font-semibold">Cliente</th>
                            <th class="text-left py-4 px-4 text-slate-700 font-semibold">Fecha</th>
                            <th class="text-left py-4 px-4 text-slate-700 font-semibold">Valor</th>
                            <th class="text-left py-4 px-4 text-slate-700 font-semibold">Estado</th>
                            <th class="text-left py-4 px-4 text-slate-700 font-semibold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cotizaciones as $cot)
                            <tr>
                                <td class="py-4 px-4">{{ $cot->ID_cotizacion }}</td>
                                <td class="py-4 px-4">{{ $cot->proyecto->nombre ?? 'N/A' }}</td>
                                <td class="py-4 px-4">{{ $cot->proyecto->cliente->nombre ?? 'N/A' }}</td>
                                <td class="py-4 px-4">{{ $cot->fecha->format('d/m/Y') }}</td>
                                <td class="py-4 px-4">${{ number_format($cot->total, 2) }}</td>
                                <td class="py-4 px-4">
                                    @php
                                        $estados = ['Borrador', 'Enviada', 'Aprobada', 'Rechazada'];
                                        $clase = match($cot->estado) {
                                            0 => 'bg-slate-100 text-slate-700',
                                            1 => 'bg-blue-100 text-blue-700',
                                            2 => 'bg-green-100 text-green-700',
                                            3 => 'bg-red-100 text-red-700',
                                            default => 'bg-slate-100'
                                        };
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-sm {{ $clase }}">{{ $estados[$cot->estado] }}</span>
                                </td>
                                <td class="py-4 px-4">
                                    <a href="{{ route('cotizaciones.ver', $cot->ID_cotizacion) }}" class="text-slate-600 hover:text-slate-800">Ver</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center py-8">No hay cotizaciones</td></tr>
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