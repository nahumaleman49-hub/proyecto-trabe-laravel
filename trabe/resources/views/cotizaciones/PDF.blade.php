<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Cotización #{{ $cotizacion->ID_cotizacion }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #1e293b;
            background: #ffffff;
        }

        /* ── ENCABEZADO ─────────────────────────────── */
        .header {
            background-color: #1e3a5f;
            color: #ffffff;
            padding: 24px 30px;
            margin-bottom: 24px;
        }

        .header-table {
            width: 100%;
        }

        .header-table td {
            vertical-align: middle;
        }

        .empresa-nombre {
            font-size: 22px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .empresa-subtitulo {
            font-size: 11px;
            color: #94a3b8;
            margin-top: 2px;
        }

        .cotizacion-badge {
            text-align: right;
        }

        .cotizacion-badge .label {
            font-size: 10px;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .cotizacion-badge .numero {
            font-size: 20px;
            font-weight: bold;
            color: #ffffff;
        }

        /* ── SECCIÓN DE DATOS ────────────────────────── */
        .section-datos {
            padding: 0 30px;
            margin-bottom: 20px;
        }

        .datos-table {
            width: 100%;
            border-collapse: collapse;
        }

        .datos-table td {
            vertical-align: top;
            padding: 0 8px 0 0;
        }

        .card-dato {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-left: 3px solid #1e3a5f;
            padding: 10px 14px;
            border-radius: 3px;
        }

        .card-dato .titulo {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #64748b;
            margin-bottom: 4px;
        }

        .card-dato .valor {
            font-size: 12px;
            font-weight: bold;
            color: #1e293b;
        }

        .card-dato .sub {
            font-size: 10px;
            color: #475569;
            margin-top: 2px;
        }

        /* ── SECCIÓN TÍTULO ──────────────────────────── */
        .section-title {
            padding: 0 30px;
            margin: 20px 0 8px 0;
        }

        .section-title h2 {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #1e3a5f;
            border-bottom: 2px solid #1e3a5f;
            padding-bottom: 5px;
        }

        /* ── TABLAS ──────────────────────────────────── */
        .section-table {
            padding: 0 30px;
            margin-bottom: 20px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }

        .items-table thead tr {
            background-color: #1e3a5f;
            color: #ffffff;
        }

        .items-table thead th {
            padding: 7px 10px;
            text-align: left;
            font-weight: bold;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .items-table thead th.text-right {
            text-align: right;
        }

        .items-table tbody tr:nth-child(even) {
            background-color: #f1f5f9;
        }

        .items-table tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }

        .items-table tbody td {
            padding: 7px 10px;
            border-bottom: 1px solid #e2e8f0;
            color: #334155;
        }

        .items-table tbody td.text-right {
            text-align: right;
        }

        .items-table tfoot td {
            padding: 7px 10px;
            font-weight: bold;
            background-color: #e8eef5;
            color: #1e3a5f;
            font-size: 11px;
        }

        .items-table tfoot td.text-right {
            text-align: right;
        }

        /* ── RESUMEN TOTAL ───────────────────────────── */
        .section-resumen {
            padding: 0 30px;
            margin-top: 10px;
        }

        .resumen-table {
            width: 100%;
            border-collapse: collapse;
        }

        .resumen-table td {
            vertical-align: top;
            padding: 0;
        }


        .totales-box {
            width: 100%;
            margin-left: auto;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            overflow: hidden;
        }

        .totales-inner {
            width: 100%;
            border-collapse: collapse;
        }

        .totales-inner tr td {
            padding: 8px 14px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 11px;
        }

        .totales-inner tr td:last-child {
            text-align: right;
            font-weight: bold;
        }

        .totales-inner tr.total-final {
            background-color: #1e3a5f;
            color: #ffffff;
        }

        .totales-inner tr.total-final td {
            font-size: 13px;
            border-bottom: none;
        }

        /* ── PIE DE PÁGINA ───────────────────────────── */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: #f1f5f9;
            border-top: 1px solid #e2e8f0;
            padding: 8px 30px;
            font-size: 9px;
            color: #94a3b8;
        }

        .footer-table {
            width: 100%;
        }

        .footer-table td:last-child {
            text-align: right;
        }

        /* ── UTILIDADES ──────────────────────────────── */
        .text-right { text-align: right; }
        .text-muted  { color: #64748b; }
        .badge-estado {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: bold;
            background-color: #fef3c7;
            color: #92400e;
        }
    </style>
</head>
<body>

{{-- PIE DE PÁGINA (va primero en DomPDF para que sea fixed) --}}
<div class="footer">
    <table class="footer-table">
        <tr>
            <td>Trabe Construcciones &mdash; Documento generado el {{ \Carbon\Carbon::now()->format('d/m/Y') }}</td>
            <td>Cotización #{{ $cotizacion->ID_cotizacion }}</td>
        </tr>
    </table>
</div>

{{-- ENCABEZADO --}}
<div class="header">
    <table class="header-table">
        <tr>
            <td>
                <div class="empresa-nombre">TRABE</div>
                <div class="empresa-subtitulo">Construcciones &amp; Proyectos</div>
            </td>
            <td class="cotizacion-badge">
                <div class="label">Cotización</div>
                <div class="numero">#{{ str_pad($cotizacion->ID_cotizacion, 4, '0', STR_PAD_LEFT) }}</div>
                <div style="font-size:10px; color:#94a3b8; margin-top:2px;">
                    {{ \Carbon\Carbon::parse($cotizacion->fecha)->format('d / m / Y') }}
                </div>
            </td>
        </tr>
    </table>
</div>

{{-- DATOS DEL CLIENTE Y PROYECTO --}}
<div class="section-datos">
    <table class="datos-table">
        <tr>
            <td style="width:33%;">
                <div class="card-dato">
                    <div class="titulo">Cliente</div>
                    <div class="valor">{{ $cotizacion->proyecto->cliente->nombre ?? 'N/A' }}</div>
                    <div class="sub">{{ $cotizacion->proyecto->cliente->telefono ?? '' }}</div>
                    <div class="sub">{{ $cotizacion->proyecto->cliente->direccion ?? '' }}</div>
                </div>
            </td>
            <td style="width:34%;">
                <div class="card-dato">
                    <div class="titulo">Proyecto</div>
                    <div class="valor">{{ $cotizacion->proyecto->nombre ?? 'N/A' }}</div>
                    <div class="sub">ID Proyecto: {{ $cotizacion->proyecto->ID_proyecto ?? '' }}</div>
                </div>
            </td>
            <td style="width:33%; padding-right:0;">
                <div class="card-dato">
                    <div class="titulo">Estado</div>
                    <div class="valor" style="margin-top:3px;">
                        <span class="badge-estado">
                            {{ $cotizacion->estado == 1 ? 'Aprobada' : 'Pendiente' }}
                        </span>
                    </div>
                    <div class="sub" style="margin-top:5px;">Fecha: {{ \Carbon\Carbon::parse($cotizacion->fecha)->format('d/m/Y') }}</div>
                </div>
            </td>
        </tr>
    </table>
</div>

{{-- TABLA DE MATERIALES --}}
@if($cotizacion->detallesMateriales->count() > 0)
<div class="section-title">
    <h2>Materiales</h2>
</div>
<div class="section-table">
    <table class="items-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Material</th>
                <th>Proveedor</th>
                <th>Unidad</th>
                <th class="text-right">Cantidad</th>
                <th class="text-right">Precio Unit.</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cotizacion->detallesMateriales as $i => $det)
            <tr>
                <td class="text-muted">{{ $i + 1 }}</td>
                <td>{{ $det->abastecimiento->materiales->nombre ?? 'N/A' }}</td>
                <td class="text-muted">{{ $det->abastecimiento->proveedor->nombre ?? 'N/A' }}</td>
                <td class="text-muted">{{ $det->abastecimiento->materiales->medidas ?? '—' }}</td>
                <td class="text-right">{{ $det->cantidad }}</td>
                <td class="text-right">${{ number_format($det->abastecimiento->precio ?? 0, 2) }}</td>
                <td class="text-right">${{ number_format($det->cantidad * ($det->abastecimiento->precio ?? 0), 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" class="text-right">Total Materiales</td>
                <td class="text-right">${{ number_format($totalMateriales, 2) }}</td>
            </tr>
        </tfoot>
    </table>
</div>
@endif

{{-- TABLA DE SERVICIOS --}}
@if($cotizacion->detallesManoObra->count() > 0)
<div class="section-title">
    <h2>Mano de Obra / Servicios</h2>
</div>
<div class="section-table">
    <table class="items-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Servicio</th>
                <th>Proveedor</th>
                <th>Unidad</th>
                <th class="text-right">Cantidad</th>
                <th class="text-right">Precio Unit.</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cotizacion->detallesManoObra as $i => $det)
            <tr>
                <td class="text-muted">{{ $i + 1 }}</td>
                <td>{{ $det->manoObra->servicio->nombre ?? 'N/A' }}</td>
                <td class="text-muted">{{ $det->manoObra->proveedor->nombre ?? 'N/A' }}</td>
                <td class="text-muted">{{ $det->manoObra->unidad ?? '—' }}</td>
                <td class="text-right">{{ $det->cantidad }}</td>
                <td class="text-right">${{ number_format($det->manoObra->precio ?? 0, 2) }}</td>
                <td class="text-right">${{ number_format($det->cantidad * ($det->manoObra->precio ?? 0), 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" class="text-right">Total Servicios</td>
                <td class="text-right">${{ number_format($totalServicios, 2) }}</td>
            </tr>
        </tfoot>
    </table>
</div>
@endif

{{-- RESUMEN FINAL --}}
<div class="section-resumen">
    <table class="resumen-table">
        <tr>
            <td class="spacer"></td>
            <td>
                <div class="totales-box">
                    <table class="totales-inner">
                        <tr>
                            <td>Subtotal Materiales</td>
                            <td>${{ number_format($totalMateriales, 2) }}</td>
                        </tr>
                        <tr>
                            <td>Subtotal Servicios</td>
                            <td>${{ number_format($totalServicios, 2) }}</td>
                        </tr>
                        <tr class="total-final">
                            <td>TOTAL</td>
                            <td>${{ number_format($cotizacion->total, 2) }}</td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
</div>

</body>
</html>