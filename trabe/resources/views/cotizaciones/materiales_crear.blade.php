<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <title>Agregar Material</title>
</head>
<body class="bg-slate-50 p-8">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-sm border border-slate-200">
        <a href="{{ url('/materiales') }}" class="text-slate-500 hover:text-blue-600 flex items-center mb-6 text-sm">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-1"></i> Volver
        </a>
        
        <h2 class="text-3xl font-bold text-slate-900 mb-8">Registrar Nuevo Material</h2>

        <form action="{{ url('/materiales/guardar') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Nombre del Material</label>
                <input type="text" name="nombre" class="w-full p-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Ej. Varilla de 3/8">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Código</label>
                    <input type="text" name="codigo" class="w-full p-3 border border-slate-300 rounded-lg outline-none" placeholder="COD-001">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Unidad de Medida</label>
                    <input type="text" name="medidas" class="w-full p-3 border border-slate-300 rounded-lg outline-none" placeholder="Ej. m3, kg, pza">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Categoría</label>
                <select name="fk_id_categoria" class="w-full p-3 border border-slate-300 rounded-lg outline-none bg-white">
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->ID_Categoria }}">{{ $cat->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-4 rounded-xl hover:bg-blue-700 transition-colors shadow-lg shadow-blue-200">
                Guardar Material
            </button>
        </form>
    </div>
    <script>lucide.createIcons();</script>
</body>
</html>