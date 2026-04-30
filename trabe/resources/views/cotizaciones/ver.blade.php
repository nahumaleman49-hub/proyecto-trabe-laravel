<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotización #{{ $cotizacion->ID_cotizacion }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-50">

<div class="min-h-screen pb-12">
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
        <a href="{{ route('cotizaciones') }}" class="inline-flex items-center text-slate-600 hover:text-slate-800 transition-colors mb-6">
            <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i>
            Volver a Cotizaciones
        </a>

        @php
            $estados = ['Borrador', 'Enviada', 'Aprobada', 'Rechazada'];
            $badgeColor = match($cotizacion->estado) {
                0 => 'bg-slate-100 text-slate-700',
                1 => 'bg-blue-100 text-blue-700',
                2 => 'bg-green-100 text-green-700',
                3 => 'bg-red-100 text-red-700',
                default => 'bg-gray-100'
            };
        @endphp

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            {{-- Cabecera con estado y fecha --}}
            <div class="bg-slate-50 px-8 py-4 border-b flex justify-between items-center flex-wrap gap-2">
                <div>
                    <span class="px-3 py-1 rounded-full text-sm font-medium {{ $badgeColor }}">
                        {{ $estados[$cotizacion->estado] }}
                    </span>
                    <span class="ml-3 text-slate-500 text-sm">Creada: {{ $cotizacion->fecha->format('d/m/Y') }}</span>
                </div>
                <div class="text-slate-700 font-mono text-sm">ID Cotización: {{ $cotizacion->ID_cotizacion }}</div>
            </div>

            {{-- Información del proyecto y cliente --}}
            <div class="p-8 border-b">
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <i data-lucide="info" class="w-5 h-5"></i> Datos del Proyecto
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-slate-500">Nombre del Proyecto</p>
                        <p class="font-semibold">{{ $cotizacion->proyecto->nombre ?? 'No especificado' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500">Cliente</p>
                        <p class="font-semibold">{{ $cotizacion->proyecto->cliente->nombre ?? 'No especificado' }}</p>
                        <p class="text-sm text-slate-600">{{ $cotizacion->proyecto->cliente->telefono ?? '' }} {{ $cotizacion->proyecto->cliente->correo_e ?? '' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500">Fechas del Proyecto</p>
                        <p>Inicio: {{ $cotizacion->proyecto->fecha_ini ? \Carbon\Carbon::parse($cotizacion->proyecto->fecha_ini)->format('d/m/Y') : 'N/A' }}</p>
                        <p>Fin: {{ $cotizacion->proyecto->fecha_fin ? \Carbon\Carbon::parse($cotizacion->proyecto->fecha_fin)->format('d/m/Y') : 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500">Presupuesto inicial del proyecto</p>
                        <p class="font-medium">${{ number_format($cotizacion->proyecto->presupuesto, 2) }}</p>
                    </div>
                </div>
            </div>

            {{-- Materiales --}}
            @php $materiales = $cotizacion->detalles->whereNotNull('fk_id_material'); @endphp
            @if($materiales->count())
            <div class="p-8 border-b">
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <i data-lucide="package" class="w-5 h-5"></i> Materiales
                </h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-100">
                            <tr>
                                <th class="text-left py-2 px-3">Material</th>
                                <th class="text-left py-2 px-3">Proveedor</th>
                                <th class="text-right py-2 px-3">Cantidad</th>
                                <th class="text-right py-2 px-3">Precio unitario</th>
                                <th class="text-right py-2 px-3">Importe</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($materiales as $det)
                            <tr class="border-b">
                                <td class="py-2 px-3">{{ $det->material->nombre ?? 'N/A' }} ({{ $det->material->medidas ?? '' }})</td>
                                <td class="py-2 px-3">{{ $det->proveedor->nombre ?? 'N/A' }}</td>
                                <td class="py-2 px-3 text-right">{{ number_format($det->cantidad, 2) }}</td>
                                <td class="py-2 px-3 text-right">${{ number_format($det->precio_unit, 2) }}</td>
                                <td class="py-2 px-3 text-right font-semibold">${{ number_format($det->cantidad * $det->precio_unit, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            {{-- Servicios (Mano de obra) --}}
            @php $servicios = $cotizacion->detalles->whereNotNull('fk_id_mano_obra'); @endphp
            @if($servicios->count())
            <div class="p-8 border-b">
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <i data-lucide="briefcase" class="w-5 h-5"></i> Servicios (Mano de obra)
                </h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-100">
                            <tr>
                                <th class="text-left py-2 px-3">Servicio</th>
                                <th class="text-left py-2 px-3">Proveedor</th>
                                <th class="text-right py-2 px-3">Cantidad</th>
                                <th class="text-right py-2 px-3">Precio unitario</th>
                                <th class="text-right py-2 px-3">Importe</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($servicios as $det)
                            @php
                                $servicioNombre = $det->manoObra->servicio->nombre ?? 'Servicio';
                                $unidad = $det->manoObra->unidad ?? '';
                            @endphp
                            <tr class="border-b">
                                <td class="py-2 px-3">{{ $servicioNombre }} <span class="text-xs text-slate-500">({{ $unidad }})</span></td>
                                <td class="py-2 px-3">{{ $det->proveedor->nombre ?? 'N/A' }}</td>
                                <td class="py-2 px-3 text-right">{{ number_format($det->cantidad, 2) }}</td>
                                <td class="py-2 px-3 text-right">${{ number_format($det->precio_unit, 2) }}</td>
                                <td class="py-2 px-3 text-right font-semibold">${{ number_format($det->cantidad * $det->precio_unit, 2) }}</td>
                             </tr>
                            @endforeach
                        </tbody>
                     </table>
                </div>
            </div>
            @endif

            {{-- Resumen de costos --}}
            @php
                $subtotalMateriales = $materiales->sum(fn($d) => $d->cantidad * $d->precio_unit);
                $subtotalServicios = $servicios->sum(fn($d) => $d->cantidad * $d->precio_unit);
                $subtotalGeneral = $subtotalMateriales + $subtotalServicios;
                $costoEquipo = 0; // Si no se guardó en la cotización, se puede omitir o tomar de otro lado
                // Podrías agregar estos campos extra a la tabla cotizacion si los necesitas, por simplicidad asumimos 0
                $gastosGenerales = 0;
                $margenGanancia = 0;
                $total = $cotizacion->total;
            @endphp
            <div class="p-8 bg-slate-50">
                <h2 class="text-xl font-bold text-slate-800 mb-4">Resumen Económico</h2>
                <div class="max-w-md ml-auto space-y-2 text-right">
                    <div class="flex justify-between">
                        <span>Subtotal Materiales:</span>
                        <span class="font-medium">${{ number_format($subtotalMateriales, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Subtotal Servicios:</span>
                        <span class="font-medium">${{ number_format($subtotalServicios, 2) }}</span>
                    </div>
                    <div class="flex justify-between pt-2 border-t">
                        <span class="font-semibold">Subtotal General:</span>
                        <span class="font-bold">${{ number_format($subtotalGeneral, 2) }}</span>
                    </div>
                    @if($costoEquipo > 0)
                    <div class="flex justify-between text-sm">
                        <span>Costo de Equipo:</span>
                        <span>${{ number_format($costoEquipo, 2) }}</span>
                    </div>
                    @endif
                    @if($gastosGenerales > 0)
                    <div class="flex justify-between text-sm">
                        <span>Gastos Generales:</span>
                        <span>${{ number_format($gastosGenerales, 2) }}</span>
                    </div>
                    @endif
                    @if($margenGanancia > 0)
                    <div class="flex justify-between text-sm">
                        <span>Margen de Ganancia:</span>
                        <span>${{ number_format($margenGanancia, 2) }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between text-lg font-bold pt-2 border-t">
                        <span>Total Cotización:</span>
                        <span class="text-emerald-700">${{ number_format($total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 flex justify-end gap-3">
                <form action="{{ route('cotizaciones.editar', $cotizacion->ID_cotizacion) }}" method="PUT">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Editar</button>
                </form>
            <a href="{{ route('cotizaciones.pdf', $cotizacion->ID_cotizacion) }}" target="_blank" class="bg-slate-700 text-white px-6 py-2 rounded-lg hover:bg-slate-800">Generar PDF</a>
        </div>
    </div>
</div>

<script>
    lucide.createIcons();
</script>
</body>
</html>