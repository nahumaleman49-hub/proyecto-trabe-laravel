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
    <div class="relative h-48 overflow-hidden bg-gradient-to-r from-slate-700 to-slate-800 shadow-inner">
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white">
                <i data-lucide="file-text" class="w-12 h-12 mx-auto mb-2 opacity-80"></i>
                <h1 class="text-3xl font-black tracking-tight">COTIZACIÓN #{{ str_pad($cotizacion->ID_cotizacion, 5, '0', STR_PAD_LEFT) }}</h1>
                <p class="text-slate-300 font-medium tracking-wide italic">Vista detallada del presupuesto</p>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8 max-w-5xl">
        {{-- Botón Volver --}}
        <div class="flex justify-between items-center mb-6">
            <a href="{{ route('cotizaciones') }}" class="inline-flex items-center text-slate-600 hover:text-slate-900 transition-colors font-medium group">
                <i data-lucide="arrow-left" class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform"></i>
                Volver a Cotizaciones
            </a>
            <div class="text-xs font-mono text-slate-400 uppercase tracking-widest">
                Cotizacion #: {{ $cotizacion->ID_cotizacion }}
            </div>
        </div>

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
            $materiales = $cotizacion->detallesMateriales ?? collect();
            $servicios = $cotizacion->detallesManoObra ?? collect();
            
        $subtotalMateriales = $materiales->sum(function($det) {
            return $det->cantidad * ($det->abastecimiento->precio ?? 0);
        });
            $subtotalServicios = $servicios->sum(function($det) {
            return $det->cantidad * ($det->manoObra->precio ?? 0);
         });
        @endphp

        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-200">
            {{-- Barra de Estado Superior --}}
            <div class="bg-slate-50 px-8 py-5 border-b flex justify-between items-center flex-wrap gap-4">
                <div class="flex items-center gap-4">
                    <div class="flex flex-col">
                        <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Estado Actual</span>
                        <span class="px-3 py-0.5 rounded-full text-xs font-black border uppercase {{ $badgeColor }}">
                            {{ $estados[$cotizacion->estado] ?? 'Desconocido' }}
                        </span>
                    </div>
                    <div class="w-px h-8 bg-slate-200"></div>
                    <div class="flex flex-col">
                        <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Fecha Emisión</span>
                        <span class="text-slate-700 text-sm font-bold flex items-center gap-1">
                            <i data-lucide="calendar" class="w-4 h-4 text-slate-400"></i>
                            {{ \Carbon\Carbon::parse($cotizacion->fecha)->format('d/m/Y') }}
                        </span>
                    </div>
                </div>
                <div class="hidden md:block">
                    <span class="text-slate-400 font-black italic">QOSTO SYSTEM</span>
                </div>
            </div>

            {{-- Información del Proyecto y Cliente --}}
            <div class="p-8 border-b bg-white grid grid-cols-1 md:grid-cols-2 gap-12">
                <div>
                    <h2 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Información del Cliente</h2>
                    <div class="space-y-1">
                        <p class="text-xl font-black text-slate-800">{{ $cotizacion->proyecto->cliente->nombre ?? 'N/A' }}</p>
                        <p class="text-slate-500 flex items-center gap-2 text-sm">
                            <i data-lucide="mail" class="w-4 h-4"></i> {{ $cotizacion->proyecto->cliente->email?? 'Sin correo' }}
                        </p>
                        <p class="text-slate-500 flex items-center gap-2 text-sm">
                            <i data-lucide="phone" class="w-4 h-4"></i> {{ $cotizacion->proyecto->cliente->telefono ?? 'Sin teléfono' }}
                        </p>
                    </div>
                </div>
                
                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100">
                    <h2 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4 text-right">Datos del Proyecto</h2>
                    <div class="text-right space-y-1">
                        <p class="text-lg font-bold text-slate-800">{{ $cotizacion->proyecto->nombre ?? 'Sin nombre' }}</p>
                        <p class="text-sm text-slate-500">
                            {{ $cotizacion->proyecto->fecha_ini ? \Carbon\Carbon::parse($cotizacion->proyecto->fecha_ini)->format('d/m/Y') : 'N/A' }} 
                            — 
                            {{ $cotizacion->proyecto->fecha_fin ? \Carbon\Carbon::parse($cotizacion->proyecto->fecha_fin)->format('d/m/Y') : 'N/A' }}
                        </p>
                        <p class="text-xs font-mono text-slate-400 uppercase">Presupuesto Base: ${{ number_format($cotizacion->proyecto->presupuesto ?? 0, 2) }}</p>
                    </div>
                </div>
            </div>

            {{-- Tabla de Materiales --}}
            @if($materiales->count())
            <div class="px-8 pt-8">
                <h3 class="text-sm font-black text-slate-800 mb-4 flex items-center gap-2 uppercase tracking-tight">
                    <span class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                        <i data-lucide="package" class="w-5 h-5"></i>
                    </span>
                    Desglose de Insumos y Materiales
                </h3>
                <div class="overflow-hidden rounded-xl border border-slate-100 shadow-sm">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] font-black tracking-widest border-b">
                            <tr>
                                <th class="text-left py-4 px-4">Descripción del Material</th>
                                <th class="text-left py-4 px-4">Proveedor</th>
                                <th class="text-center py-4 px-4">Cantidad</th>
                                <th class="text-right py-4 px-4">Precio Unit.</th>
                                <th class="text-right py-4 px-4">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($materiales as $det)
                            <tr class="hover:bg-blue-50/30 transition-colors">
                                <td class="py-4 px-4">
                                    {{-- Corregido para usar la relación 'materiales' como definiste en tu modelo --}}
                                    <p class="font-bold text-slate-800">{{ $det->abastecimiento->materiales->nombre?? 'Material no especificado' }}</p>
                                    <p class="text-[10px] text-slate-400 uppercase">{{ $det->abastecimiento->materiales->medidas ?? 'Sin medidas' }}</p>
                                </td>
                                <td class="py-4 px-4 text-slate-500 font-medium">{{ $det->abastecimiento->proveedor->nombre?? 'N/A' }}</td>
                                <td class="py-4 px-4 text-center font-mono font-bold">{{ number_format($det->cantidad * ($det->abastecimiento->precio ?? 0), 2) }}</td>
                                <td class="py-4 px-4 text-right text-slate-400 font-mono">${{ number_format($det->abastecimiento-> precio ?? 0, 2) }}</td>
                                <td class="py-4 px-4 text-right font-black text-slate-700 font-mono">${{ number_format($det->cantidad * ( $det->abastecimiento->precio ?? 0), 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            {{-- Tabla de Servicios --}}
            @if($servicios->count())
            <div class="px-8 pt-8 pb-8">
                <h3 class="text-sm font-black text-slate-800 mb-4 flex items-center gap-2 uppercase tracking-tight">
                    <span class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                        <i data-lucide="briefcase" class="w-5 h-5"></i>
                    </span>
                    Mano de Obra y Servicios Externos
                </h3>
                <div class="overflow-hidden rounded-xl border border-slate-100 shadow-sm">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] font-black tracking-widest border-b">
                            <tr>
                                <th class="text-left py-4 px-4">Servicio Ejecutado</th>
                                <th class="text-left py-4 px-4">Especialista / Proveedor</th>
                                <th class="text-center py-4 px-4">Cantidad</th>
                                <th class="text-right py-4 px-4">Precio Unit.</th>
                                <th class="text-right py-4 px-4">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($servicios as $det)
                            <tr class="hover:bg-amber-50/30 transition-colors">
                                <td class="py-4 px-4">
                                    <p class="font-bold text-slate-800">{{ $det->manoObra->servicio->nombre ?? 'Servicio' }}</p>
                                    <span class="inline-block px-2 py-0.5 rounded bg-slate-100 text-[9px] font-black text-slate-500 uppercase">{{ $det->manoObra->unidad ?? 'Unidad' }}</span>
                                </td>
                                <td class="py-4 px-4 text-slate-500 font-medium">{{ $det->manoObra->proveedor->nombre ?? 'N/A' }}</td>
                                <td class="py-4 px-4 text-center font-mono font-bold">{{ number_format($det->cantidad, 2) }}</td>
                                <td class="py-4 px-4 text-right text-slate-400 font-mono">${{ number_format($det->manoObra->precio ?? 0, 2) }}</td>
                                <td class="py-4 px-4 text-right font-black text-slate-700 font-mono">${{ number_format($det->cantidad * ($det->manoObra->precio ?? 0), 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            {{-- Resumen Económico Final --}}
            <div class="p-10 bg-slate-900 text-slate-400">
                <div class="max-w-xs ml-auto space-y-4">
                    <div class="flex justify-between text-xs font-bold uppercase tracking-widest">
                        <span>Subtotal Materiales</span>
                        <span class="text-white font-mono">${{ number_format($subtotalMateriales, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-xs font-bold uppercase tracking-widest">
                        <span>Subtotal Servicios</span>
                        <span class="text-white font-mono">${{ number_format($subtotalServicios, 2) }}</span>
                    </div>
                    <div class="pt-6 border-t border-slate-700 flex justify-between items-center">
                        <div class="flex flex-col">
                            <span class="text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em]">Total Cotizado</span>
                            <span class="text-lg font-black text-white leading-none">MONTO NETO</span>
                        </div>
                        <span class="text-4xl font-black text-emerald-400 font-mono tracking-tighter">${{ number_format($cotizacion->total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Acciones Finales --}}
        <div class="mt-8 flex flex-col md:flex-row justify-end gap-4">
            <a href="{{ route('cotizaciones.editar', $cotizacion->ID_cotizacion) }}" 
               class="group inline-flex items-center justify-center gap-2 bg-white border-2 border-slate-200 text-slate-700 px-8 py-3 rounded-2xl hover:border-blue-600 hover:text-blue-600 transition-all font-bold shadow-sm">
                <i data-lucide="edit-2" class="w-5 h-5 group-hover:rotate-12 transition-transform"></i>
                Editar Presupuesto
            </a>
            <a href="{{ route('cotizaciones.pdf', $cotizacion->ID_cotizacion) }}" target="_blank" 
               class="group inline-flex items-center justify-center gap-2 bg-slate-800 text-white px-8 py-3 rounded-2xl hover:bg-slate-950 transition-all font-bold shadow-lg shadow-slate-200">
                <i data-lucide="file-down" class="w-5 h-5 group-hover:translate-y-0.5 transition-transform"></i>
                Descargar Documento PDF
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