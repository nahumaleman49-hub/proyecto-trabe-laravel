<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($proyecto) ? 'Editar Proyecto' : 'Nuevo Proyecto' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-50">

<div class="min-h-screen">
    <div class="relative h-64 overflow-hidden bg-gradient-to-r from-slate-700 to-slate-800">
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white">
                <i data-lucide="briefcase" class="w-16 h-16 mx-auto mb-4"></i>
                <h1 class="text-5xl font-bold mb-2">{{ isset($proyecto) ? 'Editar Proyecto' : 'Nuevo Proyecto' }}</h1>
                <p class="text-xl text-slate-300">{{ isset($proyecto) ? 'Actualiza la información del proyecto' : 'Registra un nuevo proyecto' }}</p>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <a href="{{ route('proyectos.index') }}" class="inline-flex items-center text-slate-600 hover:text-slate-800 transition-colors mb-8">
            <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i>
            Volver a Proyectos
        </a>

        <div class="bg-white rounded-2xl p-8 shadow-lg">
            <form action="{{ isset($proyecto) ? route('proyectos.actualizar', $proyecto->ID_proyecto) : route('proyectos.guardar') }}" method="POST">
                @csrf
                @if(isset($proyecto)) @method('PUT') @endif

                <div class="space-y-6">
                    <div>
                        <label class="block text-slate-700 font-semibold mb-2">Nombre del Proyecto *</label>
                        <input type="text" name="nombre" value="{{ old('nombre', $proyecto->nombre ?? '') }}" class="w-full px-4 py-3 border border-slate-300 rounded-lg" required maxlength="50">
                    </div>

                    <div>
                        <label class="block text-slate-700 font-semibold mb-2">Cliente *</label>
                        <select name="fk_id_cliente" class="w-full px-4 py-3 border border-slate-300 rounded-lg" required>
                            <option value="">Seleccione un cliente</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->ID_cliente }}" {{ (old('fk_id_cliente', $proyecto->fk_id_cliente ?? '') == $cliente->ID_cliente) ? 'selected' : '' }}>
                                    {{ $cliente->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-slate-700 font-semibold mb-2">Estado *</label>
                        <select name="estado" class="w-full px-4 py-3 border border-slate-300 rounded-lg" required>
                            <option value="1" {{ (old('estado', $proyecto->estado ?? '') == 1) ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ (old('estado', $proyecto->estado ?? '') == 0) ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-slate-700 font-semibold mb-2">Fecha de Inicio *</label>
                        <input type="date" name="fecha_ini" value="{{ old('fecha_ini', $proyecto->fecha_ini ?? '') }}" class="w-full px-4 py-3 border border-slate-300 rounded-lg" required>
                    </div>

                    <div>
                        <label class="block text-slate-700 font-semibold mb-2">Fecha de Fin</label>
                        <input type="date" name="fecha_fin" value="{{ old('fecha_fin', $proyecto->fecha_fin ?? '') }}" class="w-full px-4 py-3 border border-slate-300 rounded-lg">
                    </div>

                    <div>
                        <label class="block text-slate-700 font-semibold mb-2">Presupuesto *</label>
                        <input type="number" step="0.01" name="presupuesto" value="{{ old('presupuesto', $proyecto->presupuesto ?? '') }}" class="w-full px-4 py-3 border border-slate-300 rounded-lg" required min="0">
                    </div>
                </div>

                <div class="mt-8 flex gap-4">
                    <button type="submit" class="inline-flex items-center gap-2 bg-gradient-to-r from-slate-700 to-slate-800 text-white px-8 py-3 rounded-lg hover:shadow-lg">
                        <i data-lucide="save" class="w-5 h-5"></i>
                        {{ isset($proyecto) ? 'Actualizar Proyecto' : 'Guardar Proyecto' }}
                    </button>
                    <a href="{{ route('proyectos.index') }}" class="px-8 py-3 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>lucide.createIcons();</script>
</body>
</html>