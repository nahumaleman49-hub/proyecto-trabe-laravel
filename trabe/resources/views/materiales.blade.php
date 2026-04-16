<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QOSTO - Materiales</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-50 text-slate-800">

<div class="container mx-auto px-4 py-8 max-w-5xl">

    {{-- 1. LÓGICA DE BREADCRUMBS (Navegación dinámica) --}}
    <nav class="text-sm text-slate-500 mb-6 flex items-center">
        <a href="{{ url('/materiales') }}" class="hover:text-blue-600 transition-colors">Materiales</a>
        @if($categoriaId)
            @php $catActual = $categorias->where('ID_Categoria', $categoriaId)->first(); @endphp
            @if($catActual)
                <i data-lucide="chevron-right" class="w-4 h-4 mx-1"></i>
                <a href="{{ url('/materiales?categoria='.$categoriaId) }}" class="hover:text-blue-600 transition-colors">{{ $catActual->nombre }}</a>
            @endif
        @endif
    </nav>

    {{-- CASO A: VISTA DE DETALLE DE MATERIAL --}}
    @if($materialId)
        @php 
            $material = \App\Models\materiales::with('preciosHistoricos.proveedor')->where('ID_Material', $materialId)->first(); 
        @endphp
        
        @if($material)
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h1 class="text-3xl font-bold text-slate-900 mb-2">{{ $material->nombre }}</h1>
                        <p class="text-slate-500">Unidad: <span class="font-semibold">{{ $material->medidas }}</span> | Código: {{ $material->codigo }}</p>
                    </div>
                </div>

                <div class="space-y-4 bg-slate-50 p-6 rounded-xl border border-slate-100">
                    <p class="font-semibold text-slate-700 mb-4">{{ $material->preciosHistoricos->count() }} proveedor(es) disponible(s):</p>
                    
                    @foreach($material->preciosHistoricos as $precio)
                        <div class="flex justify-between items-center p-5 bg-white rounded-lg shadow-sm border border-slate-200 hover:border-blue-300 transition-colors">
                            <div>
                                <p class="font-bold text-lg text-slate-800">{{ $precio->proveedor->nombre }}</p>
                                <p class="text-sm text-slate-500">Contacto: {{ $precio->proveedor->nombre_contacto }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-bold text-slate-900 mb-1">${{ number_format($precio->precio, 2) }}</p>
                                <button class="text-blue-600 text-sm font-bold hover:text-blue-800 transition-colors">Seleccionar</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <p class="text-red-500">Material no encontrado.</p>
        @endif

    {{-- CASO B: LISTA DE MATERIALES POR CATEGORÍA --}}
    @elseif($categoriaId && isset($catActual))
        <div class="text-center mb-10">
            <h2 class="text-4xl font-bold text-slate-900 mb-3">{{ $catActual->nombre }}</h2>
            <p class="text-slate-500">{{ $catActual->descripcion }}</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($catActual->materiales as $mat)
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 hover:shadow-md transition-shadow">
                    <h3 class="text-xl font-bold text-slate-800 mb-1">{{ $mat->nombre }}</h3>
                    <p class="text-slate-500 text-sm mb-6">Código: {{ $mat->codigo }}</p>
                    <a href="{{ url('/materiales?categoria='.$categoriaId.'&material='.$mat->ID_Material) }}" 
                       class="text-blue-600 font-semibold flex items-center hover:text-blue-800 transition-colors">
                        Ver opciones <i data-lucide="chevron-right" class="w-4 h-4 ml-1"></i>
                    </a>
                </div>
            @endforeach
        </div>

        {{-- CASO C: VISTA PRINCIPAL DE CATEGORÍAS --}}
@else
    <div class="flex justify-between items-center mb-16 mt-8">
        <div class="text-left">
            <h1 class="text-5xl font-extrabold text-slate-900 mb-4 tracking-tight">Materiales</h1>
            <p class="text-lg text-slate-500">Catálogo completo de materiales de construcción</p>
        </div>
        <a href="{{ url('/materiales/crear') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg flex items-center transition-all transform hover:scale-105">
            <i data-lucide="plus" class="w-5 h-5 mr-2"></i>
            Nuevo Material
        </a>
    </div>
    
    ```

### 2. Crear la nueva ruta en `routes/web.php`
Necesitamos decirle a Laravel que responda cuando alguien haga clic en ese botón. Abre tu archivo de rutas y añade estas dos líneas:

```php
use App\Http\Controllers\MaterialController;

// Ruta para mostrar el formulario
Route::get('/materiales/crear', [MaterialController::class, 'create']);

// Ruta para guardar el material en la base de datos
Route::post('/materiales/guardar', [MaterialController::class, 'store']);

<script>
    lucide.createIcons();
</script>
</body>
</html>