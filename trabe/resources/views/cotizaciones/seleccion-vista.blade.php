<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QOSTO - Cotización Generada</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-50">

    <div class="relative h-48 overflow-hidden bg-gradient-to-r from-slate-700 to-slate-800">
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white">
                <i data-lucide="file-text" class="w-12 h-12 mx-auto mb-3"></i>
                <h1 class="text-4xl font-bold">Cotización Generada</h1>
                <p class="text-slate-300">Selecciona la vista que deseas consultar</p>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <a href="{{ route('cotizaciones.nueva') }}" class="inline-flex items-center text-slate-600 hover:text-slate-800 transition-colors mb-8">
            <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i>
            Volver a Editar
        </a>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <a href="{{ route('cotizaciones.vista-cliente') }}" class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all hover:scale-105 group block">
                <div class="bg-blue-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-blue-200 transition-colors">
                    <i data-lucide="eye" class="w-10 h-10 text-blue-600"></i>
                </div>
                <h2 class="text-3xl font-bold text-slate-800 mb-3 text-center">Vista Cliente</h2>
                <p class="text-slate-600 text-center mb-4">Cotización simplificada con información básica del proyecto y precio total</p>
                <ul class="text-sm text-slate-600 space-y-2">
                    <li> Información del proyecto</li>
                    <li> Precio total</li>
                    <li> Términos y condiciones</li>
                </ul>
            </a>

            <a href="{{ route('cotizaciones.vista-ingeniero') }}" class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all hover:scale-105 group block">
                <div class="bg-green-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-green-200 transition-colors">
                    <i data-lucide="file-text" class="w-10 h-10 text-green-600"></i>
                </div>
                <h2 class="text-3xl font-bold text-slate-800 mb-3 text-center">Vista Ingeniero</h2>
                <p class="text-slate-600 text-center mb-4">Desglose completo con todos los costos, márgenes y lista detallada de materiales</p>
                <ul class="text-sm text-slate-600 space-y-2">
                    <li>Desglose completo de costos</li>
                    <li>Lista detallada de materiales</li>
                    <li>Márgenes y gastos generales</li>
                </ul>
            </a>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>