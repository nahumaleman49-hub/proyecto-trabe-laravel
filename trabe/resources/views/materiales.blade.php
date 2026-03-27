<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QOSTO - Materiales</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-50">

    @php
        // Definición de categorías (puede venir desde el controlador)
        $categorias = [
            [
                'id' => 'estructurales',
                'nombre' => 'Materiales Estructurales',
                'icono' => '🏗️',
                'subcategorias' => [
                    [
                        'id' => 'concreto',
                        'nombre' => 'Concreto y Cemento',
                        'materiales' => [
                            ['nombre' => 'Concreto Premezclado f\'c=250', 'unidad' => 'm³', 'proveedores' => [
                                ['proveedor' => 'Concretos CEMEX', 'precio' => 2200, 'entrega' => '24h'],
                                ['proveedor' => 'Soluciones en Concreto', 'precio' => 2150, 'entrega' => '48h']
                            ]],
                            ['nombre' => 'Cemento Portland Gris CPC 30R', 'unidad' => 'bulto 50kg', 'proveedores' => [
                                ['proveedor' => 'CEMEX', 'precio' => 195, 'entrega' => '24h'],
                                ['proveedor' => 'Cementos Moctezuma', 'precio' => 190, 'entrega' => '48h']
                            ]],
                            ['nombre' => 'Grava 3/4"', 'unidad' => 'm³', 'proveedores' => [
                                ['proveedor' => 'Agregados del Valle', 'precio' => 350, 'entrega' => '24h']
                            ]],
                            ['nombre' => 'Arena de Río', 'unidad' => 'm³', 'proveedores' => [
                                ['proveedor' => 'Agregados del Valle', 'precio' => 280, 'entrega' => '24h']
                            ]]
                        ]
                    ],
                    [
                        'id' => 'acero',
                        'nombre' => 'Acero y Metales',
                        'materiales' => [
                            ['nombre' => 'Varilla Corrugada 3/8"', 'unidad' => '6m', 'proveedores' => [
                                ['proveedor' => 'Aceros y Metales', 'precio' => 85, 'entrega' => '24h'],
                                ['proveedor' => 'Distribuidora de Acero', 'precio' => 82, 'entrega' => '48h']
                            ]],
                            ['nombre' => 'Varilla Corrugada 1/2"', 'unidad' => '6m', 'proveedores' => [
                                ['proveedor' => 'Aceros y Metales', 'precio' => 145, 'entrega' => '24h']
                            ]],
                            ['nombre' => 'Viga IPR 6"', 'unidad' => '6m', 'proveedores' => [
                                ['proveedor' => 'Aceros y Metales', 'precio' => 2800, 'entrega' => '72h']
                            ]],
                            ['nombre' => 'Alambrón', 'unidad' => 'kg', 'proveedores' => [
                                ['proveedor' => 'Ferretería Industrial', 'precio' => 18, 'entrega' => '24h']
                            ]],
                            ['nombre' => 'Malla Electrosoldada 6x6-10/10', 'unidad' => 'rollo', 'proveedores' => [
                                ['proveedor' => 'Aceros y Metales', 'precio' => 580, 'entrega' => '24h']
                            ]]
                        ]
                    ],
                    [
                        'id' => 'madera',
                        'nombre' => 'Madera y Derivados',
                        'materiales' => [
                            ['nombre' => 'Polines de Pino 4x4"', 'unidad' => '3.6m', 'proveedores' => [
                                ['proveedor' => 'Maderas del Norte', 'precio' => 220, 'entrega' => '24h'],
                                ['proveedor' => 'Madera Premium', 'precio' => 215, 'entrega' => '48h']
                            ]],
                            ['nombre' => 'Triplay de Pino 16mm', 'unidad' => '1.22x2.44m', 'proveedores' => [
                                ['proveedor' => 'Maderas del Norte', 'precio' => 485, 'entrega' => '24h']
                            ]],
                            ['nombre' => 'Duela de Pino', 'unidad' => 'm²', 'proveedores' => [
                                ['proveedor' => 'Madera Premium', 'precio' => 380, 'entrega' => '72h']
                            ]],
                            ['nombre' => 'MDF 15mm', 'unidad' => '1.22x2.44m', 'proveedores' => [
                                ['proveedor' => 'Maderas del Norte', 'precio' => 420, 'entrega' => '48h']
                            ]]
                        ]
                    ]
                ]
            ],
            [
                'id' => 'albanileria',
                'nombre' => 'Albañilería',
                'icono' => '🧱',
                'subcategorias' => [
                    [
                        'id' => 'block',
                        'nombre' => 'Block y Tabiques',
                        'materiales' => [
                            ['nombre' => 'Block de Concreto 15x20x40', 'unidad' => 'pza', 'proveedores' => [
                                ['proveedor' => 'Blockera Central', 'precio' => 18, 'entrega' => '24h'],
                                ['proveedor' => 'Materiales GAMA', 'precio' => 17.5, 'entrega' => '48h']
                            ]],
                            ['nombre' => 'Tabique Rojo Recocido 7x14x28', 'unidad' => 'millar', 'proveedores' => [
                                ['proveedor' => 'Ladrillera San Miguel', 'precio' => 4200, 'entrega' => '48h']
                            ]],
                            ['nombre' => 'Adocreto 10x20', 'unidad' => 'm²', 'proveedores' => [
                                ['proveedor' => 'Blockera Central', 'precio' => 145, 'entrega' => '24h']
                            ]]
                        ]
                    ],
                    [
                        'id' => 'recubrimientos',
                        'nombre' => 'Recubrimientos',
                        'materiales' => [
                            ['nombre' => 'Loseta Cerámica 33x33', 'unidad' => 'm²', 'proveedores' => [
                                ['proveedor' => 'Cerámicas Monterrey', 'precio' => 180, 'entrega' => '48h'],
                                ['proveedor' => 'Azulejos y Pisos', 'precio' => 175, 'entrega' => '72h']
                            ]],
                            ['nombre' => 'Piso Porcelánico 60x60', 'unidad' => 'm²', 'proveedores' => [
                                ['proveedor' => 'Porcelanite', 'precio' => 420, 'entrega' => '72h']
                            ]],
                            ['nombre' => 'Azulejo para Baño 20x30', 'unidad' => 'm²', 'proveedores' => [
                                ['proveedor' => 'Azulejos y Pisos', 'precio' => 220, 'entrega' => '48h']
                            ]],
                            ['nombre' => 'Mármol Blanco', 'unidad' => 'm²', 'proveedores' => [
                                ['proveedor' => 'Mármoles Finos', 'precio' => 850, 'entrega' => '7 días']
                            ]]
                        ]
                    ]
                ]
            ],
            [
                'id' => 'acabados',
                'nombre' => 'Acabados',
                'icono' => '🎨',
                'subcategorias' => [
                    [
                        'id' => 'pintura',
                        'nombre' => 'Pinturas',
                        'materiales' => [
                            ['nombre' => 'Pintura Vinílica Blanca', 'unidad' => 'cubeta 19L', 'proveedores' => [
                                ['proveedor' => 'Comex', 'precio' => 680, 'entrega' => '24h'],
                                ['proveedor' => 'Sherwin Williams', 'precio' => 720, 'entrega' => '24h']
                            ]],
                            ['nombre' => 'Esmalte Alquidálico', 'unidad' => 'galón', 'proveedores' => [
                                ['proveedor' => 'Comex', 'precio' => 485, 'entrega' => '24h']
                            ]],
                            ['nombre' => 'Impermeabilizante Acrílico', 'unidad' => 'cubeta 19L', 'proveedores' => [
                                ['proveedor' => 'Comex', 'precio' => 920, 'entrega' => '24h']
                            ]]
                        ]
                    ],
                    [
                        'id' => 'yeso',
                        'nombre' => 'Yeso y Acabados',
                        'materiales' => [
                            ['nombre' => 'Placa de Yeso 1.22x2.44x12.7mm', 'unidad' => 'pza', 'proveedores' => [
                                ['proveedor' => 'Tablaroca USG', 'precio' => 285, 'entrega' => '48h'],
                                ['proveedor' => 'Materiales GAMA', 'precio' => 275, 'entrega' => '72h']
                            ]],
                            ['nombre' => 'Perfil Metálico PTR', 'unidad' => '3.6m', 'proveedores' => [
                                ['proveedor' => 'Perfiles y Acero', 'precio' => 95, 'entrega' => '24h']
                            ]],
                            ['nombre' => 'Pasta para Juntas', 'unidad' => 'cubeta 27kg', 'proveedores' => [
                                ['proveedor' => 'Tablaroca USG', 'precio' => 380, 'entrega' => '24h']
                            ]]
                        ]
                    ]
                ]
            ],
            [
                'id' => 'instalaciones',
                'nombre' => 'Instalaciones',
                'icono' => '🔧',
                'subcategorias' => [
                    [
                        'id' => 'hidraulica',
                        'nombre' => 'Hidráulica',
                        'materiales' => [
                            ['nombre' => 'Tubo PVC Hidráulico 1/2"', 'unidad' => '6m', 'proveedores' => [
                                ['proveedor' => 'Tuberías del Norte', 'precio' => 68, 'entrega' => '24h'],
                                ['proveedor' => 'Hidráulicos SA', 'precio' => 65, 'entrega' => '48h']
                            ]],
                            ['nombre' => 'Tubo PVC Hidráulico 3/4"', 'unidad' => '6m', 'proveedores' => [
                                ['proveedor' => 'Tuberías del Norte', 'precio' => 95, 'entrega' => '24h']
                            ]],
                            ['nombre' => 'Codo PVC 1/2" x 90°', 'unidad' => 'pza', 'proveedores' => [
                                ['proveedor' => 'Hidráulicos SA', 'precio' => 8, 'entrega' => '24h']
                            ]],
                            ['nombre' => 'Llave de Paso 1/2"', 'unidad' => 'pza', 'proveedores' => [
                                ['proveedor' => 'Hidráulicos SA', 'precio' => 145, 'entrega' => '24h']
                            ]]
                        ]
                    ],
                    [
                        'id' => 'electrica',
                        'nombre' => 'Eléctrica',
                        'materiales' => [
                            ['nombre' => 'Cable THW Cal. 12', 'unidad' => 'rollo 100m', 'proveedores' => [
                                ['proveedor' => 'Eléctrica Total', 'precio' => 1850, 'entrega' => '24h'],
                                ['proveedor' => 'Cables y Conductores', 'precio' => 1820, 'entrega' => '48h']
                            ]],
                            ['nombre' => 'Tubo Conduit 3/4"', 'unidad' => '3m', 'proveedores' => [
                                ['proveedor' => 'Eléctrica Total', 'precio' => 52, 'entrega' => '24h']
                            ]],
                            ['nombre' => 'Chalupa Octagonal', 'unidad' => 'pza', 'proveedores' => [
                                ['proveedor' => 'Eléctrica Total', 'precio' => 12, 'entrega' => '24h']
                            ]],
                            ['nombre' => 'Apagador Sencillo', 'unidad' => 'pza', 'proveedores' => [
                                ['proveedor' => 'Material Eléctrico', 'precio' => 35, 'entrega' => '24h']
                            ]]
                        ]
                    ]
                ]
            ]
        ];

        // Obtener parámetros de la URL
        $categoriaId = request()->query('categoria');
        $subcategoriaId = request()->query('subcategoria');

        // Función auxiliar para encontrar subcategoría
        $categoriaActual = null;
        $subcategoriaActual = null;
        if ($categoriaId) {
            foreach ($categorias as $cat) {
                if ($cat['id'] === $categoriaId) {
                    $categoriaActual = $cat;
                    break;
                }
            }
        }
        if ($subcategoriaId && $categoriaActual) {
            foreach ($categoriaActual['subcategorias'] as $sub) {
                if ($sub['id'] === $subcategoriaId) {
                    $subcategoriaActual = $sub;
                    break;
                }
            }
        }
    @endphp

    {{-- Vista de categorías principales --}}
    @if(!$categoriaId)
    <div class="min-h-screen bg-slate-50">
        <div class="relative h-64 overflow-hidden bg-gradient-to-r from-slate-700 to-slate-800">
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="text-center text-white">
                    <i data-lucide="box" class="w-16 h-16 mx-auto mb-4"></i>
                    <h1 class="text-5xl font-bold mb-2">Materiales</h1>
                    <p class="text-xl text-slate-300">Catálogo completo de materiales de construcción</p>
                </div>
            </div>
        </div>

        <div class="container mx-auto px-4 py-8">
            <a href="{{ route('home') }}" class="inline-flex items-center text-slate-600 hover:text-slate-800 transition-colors mb-8">
                <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i>
                Volver al Inicio
            </a>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($categorias as $categoria)
                <a href="?categoria={{ $categoria['id'] }}" class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all hover:scale-105 text-left group block">
                    <div class="text-6xl mb-4">{{ $categoria['icono'] }}</div>
                    <h2 class="text-3xl font-bold text-slate-800 mb-3 group-hover:text-slate-700">{{ $categoria['nombre'] }}</h2>
                    <p class="text-slate-600 mb-4">{{ count($categoria['subcategorias']) }} categorías disponibles</p>
                    <div class="flex items-center text-slate-600 group-hover:text-slate-800">
                        <span class="mr-2">Ver materiales</span>
                        <i data-lucide="chevron-right" class="w-5 h-5"></i>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Vista de subcategorías --}}
    @elseif($categoriaActual && !$subcategoriaId)
    <div class="min-h-screen bg-slate-50">
        <div class="relative h-48 overflow-hidden bg-gradient-to-r from-slate-700 to-slate-800">
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="text-center text-white">
                    <div class="text-5xl mb-3">{{ $categoriaActual['icono'] }}</div>
                    <h1 class="text-4xl font-bold">{{ $categoriaActual['nombre'] }}</h1>
                </div>
            </div>
        </div>

        <div class="container mx-auto px-4 py-8">
            <a href="{{ route('materiales') }}" class="inline-flex items-center text-slate-600 hover:text-slate-800 transition-colors mb-6">
                <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i>
                Volver a Categorías
            </a>

            {{-- Breadcrumb --}}
            <div class="flex items-center gap-2 text-sm text-slate-600 mb-6">
                <a href="{{ route('materiales') }}" class="hover:text-slate-800">Materiales</a>
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                <span class="font-semibold text-slate-800">{{ $categoriaActual['nombre'] }}</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($categoriaActual['subcategorias'] as $sub)
                <a href="?categoria={{ $categoriaActual['id'] }}&subcategoria={{ $sub['id'] }}" class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all hover:scale-105 text-left group block">
                    <h3 class="text-2xl font-bold text-slate-800 mb-3 group-hover:text-slate-700">{{ $sub['nombre'] }}</h3>
                    <p class="text-slate-600 mb-4">{{ count($sub['materiales']) }} materiales disponibles</p>
                    <div class="flex items-center text-slate-600 group-hover:text-slate-800">
                        <span class="mr-2">Ver opciones</span>
                        <i data-lucide="chevron-right" class="w-5 h-5"></i>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Vista de materiales (detalle) --}}
    @elseif($subcategoriaActual)
    <div class="min-h-screen bg-slate-50">
        <div class="relative h-48 overflow-hidden bg-gradient-to-r from-slate-700 to-slate-800">
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="text-center text-white">
                    <h1 class="text-4xl font-bold">{{ $subcategoriaActual['nombre'] }}</h1>
                    <p class="text-slate-300">{{ $categoriaActual['nombre'] }}</p>
                </div>
            </div>
        </div>

        <div class="container mx-auto px-4 py-8">
            <a href="?categoria={{ $categoriaActual['id'] }}" class="inline-flex items-center text-slate-600 hover:text-slate-800 transition-colors mb-6">
                <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i>
                Volver a Subcategorías
            </a>

            {{-- Breadcrumb --}}
            <div class="flex items-center gap-2 text-sm text-slate-600 mb-6">
                <a href="{{ route('materiales') }}" class="hover:text-slate-800">Materiales</a>
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                <a href="?categoria={{ $categoriaActual['id'] }}" class="hover:text-slate-800">{{ $categoriaActual['nombre'] }}</a>
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                <span class="font-semibold text-slate-800">{{ $subcategoriaActual['nombre'] }}</span>
            </div>

            <div class="space-y-4">
                @foreach($subcategoriaActual['materiales'] as $material)
                <div class="bg-white rounded-xl p-6 shadow-lg">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 class="text-2xl font-bold text-slate-800 mb-1">{{ $material['nombre'] }}</h3>
                            <p class="text-slate-600">Unidad: {{ $material['unidad'] }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-slate-600 mb-1">Desde</p>
                            <p class="text-3xl font-bold text-slate-700">
                                ${{ number_format(min(array_column($material['proveedores'], 'precio')), 0) }}
                            </p>
                        </div>
                    </div>

                    <div class="bg-slate-50 rounded-lg p-4">
                        <p class="text-sm font-semibold text-slate-700 mb-3">{{ count($material['proveedores']) }} proveedor(es) disponible(s):</p>
                        <div class="space-y-2">
                            @foreach($material['proveedores'] as $proveedor)
                            <div class="bg-white rounded-lg p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <p class="font-semibold text-slate-800">{{ $proveedor['proveedor'] }}</p>
                                    <p class="text-sm text-slate-600">Entrega: {{ $proveedor['entrega'] }}</p>
                                </div>
                                <div class="text-right mt-2 sm:mt-0">
                                    <p class="text-2xl font-bold text-slate-700">${{ number_format($proveedor['precio'], 0) }}</p>
                                    <button class="text-sm text-slate-600 hover:text-slate-800 font-medium mt-1">Seleccionar</button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
        });
    </script>
</body>
</html>