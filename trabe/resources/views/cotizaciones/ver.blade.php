<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QOSTO - Cotización #{{ $cotizacion->ID_cotizacion }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-50">

<div class="min-h-screen pb-12">
    {{-- Cabecera con gradiente reducido --}}
    <div class="relative h-48 overflow-hidden bg-gradient-to-r from-slate-700 to-slate-800">
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white">
                <i data-lucide="file-text" class="w-12 h-12 mx-auto mb-2"></i>
                <h1 class="text-3xl font-bold">Cotización #{{ $cotizacion->ID_cotizacion }}</h1>
                <p class="text-slate-300">Detalle completo de la estimación</p>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8 max-w-5xl">
        {{-- Botón Volver --}}
        <a href="{{ route('cotizaciones') }}" class="inline-flex items-center text-slate-600 hover:text-slate-800 transition-colors mb-6">
            <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i>
            Volver a Cotizaciones
        </a>

        @php
            $estados = [0 => 'Borrador', 1 => 'Enviada', 2 => 'Aprobada', 3 => 'Rechazada'];
            $badgeColor = match($cotizacion->estado) {
                0 => 'bg-slate-100 text-slate-700 border-slate-200',
                1 => 'bg-blue-100 text-blue-700 border-blue-200',
                2 => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                3 => 'bg-red-100 text-red-700 border-red-200',
                default => 'bg-gray-100 border-gray-200'
            };
            
            // Cálculos
            $materiales = $cotizacion->detalles->whereNotNull('fk_id_material');
            $servicios = $cotizacion->detalles->whereNotNull('fk_id_mano_obra');
            
            $subtotalMateriales = $materiales->sum(fn($d) => $d->cantidad * $d->precio_unit);
            $subtotalServicios = $servicios->sum(fn($d) => $d->cantidad * $d->precio_unit);
            $subtotalGeneral = $subtotalMateriales + $subtotalServicios;
        @endphp

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-slate-200">
            {{-- Barra de Estado Superior --}}
            <div class="bg-slate-50 px-8 py-4 border-b flex justify-between items-center flex-wrap gap-2">
                <div class="flex items-center gap-3">
                    <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $badgeColor }}">
                        {{ $estados[$cotizacion->estado] ?? 'Desconocido' }}
                    </span>
                    <span class="text-slate-500 text-sm flex items-center gap-1">
                        <i data-lucide="calendar" class="w-4 h-4"></i>
                        {{ \Carbon\Carbon::parse($cotizacion->fecha)->format('d/m/Y') }}
                    </span>
                </div>
                <div class="text-slate-400 font-mono text-sm tracking-widest uppercase">Folio: {{ str_pad($cotizacion->ID_cotizacion, 5, '0', STR_PAD_LEFT) }}</div>
            </div>

            {{-- Información del Proyecto --}}
            <div class="p-8 border-b bg-white">
                <h2 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2 border-l-4 border-slate-700 pl-3">
                    Información General
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-4">
                        <div>
                            <p class="text-xs uppercase tracking-wider text-slate-400 font-bold">Proyecto</p>
                            <p class="text-lg font-semibold text-slate-800">{{ $cotizacion->proyecto->nombre ?? 'Sin nombre' }}</p>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-wider text-slate-400 font-bold">Ubicación / Fechas</p>
                            <p class="text-slate-600">
                                {{ $cotizacion->proyecto->fecha_ini ? \Carbon\Carbon::parse($cotizacion->proyecto->fecha_ini)->format('d/m/Y') : 'N/A' }} 
                                al 
                                {{ $cotizacion->proyecto->fecha_fin ? \Carbon\Carbon::parse($cotizacion->proyecto->fecha_fin)->format('d/m/Y') : 'N/A' }}
                            </p>
                        </div>
                    </div>
                    <div class="space-y-4 bg-slate-50 p-4 rounded-xl border border-slate-100">
                        <div>
                            <p class="text-xs uppercase tracking-wider text-slate-400 font-bold">Cliente</p>
                            <p class="text-lg font-semibold text-slate-800">{{ $cotizacion->proyecto->cliente->nombre ?? 'N/A' }}</p>
                        </div>
                        <div class="flex flex-col text-sm text-slate-600">
                            <span class="flex items-center gap-2"><i data-lucide="phone" class="w-3 h-3"></i> {{ $cotizacion->proyecto->cliente->telefono ?? 'S/T' }}</span>
                            <span class="flex items-center gap-2"><i data-lucide="mail" class="w-3 h-3"></i> {{ $cotizacion->proyecto->cliente->email ?? 'S/C' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabla de Materiales --}}
            @if($materiales->count())
            <div class="p-8 border-b">
                <h3 class="text-md font-bold text-slate-700 mb-4 flex items-center gap-2">
                    <i data-lucide="package" class="w-5 h-5 text-blue-500"></i> Desglose de Materiales
                </h3>
                <div class="overflow-x-auto rounded-lg border border-slate-100">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 text-slate-500 uppercase text-xs">
                            <tr>
                                <th class="text-left py-3 px-4">Descripción</th>
                                <th class="text-left py-3 px-4">Proveedor</th>
                                <th class="text-center py-3 px-4">Cant.</th>
                                <th class="text-right py-3 px-4">P. Unitario</th>
                                <th class="text-right py-3 px-4">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($materiales as $det)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="py-3 px-4 font-medium">{{ $det->material->nombre ?? 'Material' }} <span class="text-slate-400 font-normal">({{ $det->material->medidas ?? '' }})</span></td>
                                <td class="py-3 px-4 text-slate-500 text-xs">{{ $det->proveedor->nombre ?? 'N/A' }}</td>
                                <td class="py-3 px-4 text-center">{{ number_format($det->cantidad, 2) }}</td>
                                <td class="py-3 px-4 text-right text-slate-500">${{ number_format($det->precio_unit, 2) }}</td>
                                <td class="py-3 px-4 text-right font-bold text-slate-700">${{ number_format($det->cantidad * $det->precio_unit, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            {{-- Tabla de Servicios --}}
            @if($servicios->count())
            <div class="p-8 border-b">
                <h3 class="text-md font-bold text-slate-700 mb-4 flex items-center gap-2">
                    <i data-lucide="briefcase" class="w-5 h-5 text-amber-500"></i> Mano de Obra y Servicios
                </h3>
                <div class="overflow-x-auto rounded-lg border border-slate-100">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 text-slate-500 uppercase text-xs">
                            <tr>
                                <th class="text-left py-3 px-4">Servicio / Unidad</th>
                                <th class="text-left py-3 px-4">Proveedor</th>
                                <th class="text-center py-3 px-4">Cant.</th>
                                <th class="text-right py-3 px-4">P. Unitario</th>
                                <th class="text-right py-3 px-4">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($servicios as $det)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="py-3 px-4 font-medium">
                                    {{ $det->manoObra->servicio->nombre ?? 'Servicio' }}
                                    <span class="block text-[10px] text-slate-400 uppercase tracking-tighter">{{ $det->manoObra->unidad ?? 'Unidad' }}</span>
                                </td>
                                <td class="py-3 px-4 text-slate-500 text-xs">{{ $det->proveedor->nombre ?? 'N/A' }}</td>
                                <td class="py-3 px-4 text-center">{{ number_format($det->cantidad, 2) }}</td>
                                <td class="py-3 px-4 text-right text-slate-500">${{ number_format($det->precio_unit, 2) }}</td>
                                <td class="py-3 px-4 text-right font-bold text-slate-700">${{ number_format($det->cantidad * $det->precio_unit, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            {{-- Resumen Económico Final --}}
            <div class="p-8 bg-slate-900 text-slate-300">
                <div class="max-w-xs ml-auto space-y-3">
                    <div class="flex justify-between text-sm">
                        <span>Total Materiales:</span>
                        <span class="text-white">${{ number_format($subtotalMateriales, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span>Total Mano de Obra:</span>
                        <span class="text-white">${{ number_format($subtotalServicios, 2) }}</span>
                    </div>
                    <div class="pt-4 border-t border-slate-700 flex justify-between items-end">
                        <span class="text-lg font-bold text-white">TOTAL FINAL</span>
                        <span class="text-3xl font-black text-emerald-400">${{ number_format($cotizacion->total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Acciones Finales --}}
        <div class="mt-8 flex justify-end gap-4">
            <a href="{{ route('cotizaciones.editar', $cotizacion->ID_cotizacion) }}" 
               class="inline-flex items-center gap-2 bg-white border border-slate-200 text-slate-700 px-6 py-2.5 rounded-xl hover:bg-slate-50 transition-all font-semibold shadow-sm">
                <i data-lucide="edit-2" class="w-4 h-4"></i>
                Editar Cotización
            </a>
            <a href="{{ route('cotizaciones.pdf', $cotizacion->ID_cotizacion) }}" target="_blank" 
               class="inline-flex items-center gap-2 bg-slate-800 text-white px-6 py-2.5 rounded-xl hover:bg-slate-900 transition-all font-semibold shadow-md">
                <i data-lucide="file-down" class="w-4 h-4"></i>
                Generar PDF
            </a>
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