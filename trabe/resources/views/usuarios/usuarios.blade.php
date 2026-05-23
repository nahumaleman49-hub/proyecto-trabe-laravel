<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-50">

<div class="min-h-screen">
    <div class="relative h-64 overflow-hidden bg-gradient-to-r from-slate-700 to-slate-800">
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white">
                <i data-lucide="users" class="w-16 h-16 mx-auto mb-4"></i>
                <h1 class="text-5xl font-bold mb-2">Gestión de Usuarios</h1>
                <p class="text-xl text-slate-300">Administra las cuentas del sistema</p>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <a href="{{ route('home') }}" class="inline-flex items-center text-slate-600 hover:text-slate-800 transition-colors mb-8">
            <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i>
            Volver al Inicio
        </a>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-2xl p-8 shadow-lg mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-bold text-slate-800">Usuarios Registrados</h2>
                    <p class="text-slate-600">Lista de todos los usuarios del sistema</p>
                </div>
                <a href="{{ route('usuarios.create') }}" class="bg-slate-700 text-white px-6 py-3 rounded-lg hover:bg-slate-800 transition flex items-center gap-2">
                    <i data-lucide="plus" class="w-5 h-5"></i>
                    Nuevo Usuario
                </a>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-8 shadow-lg">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-200">
                            <th class="text-left py-3 px-2">ID</th>
                            <th class="text-left py-3 px-2">Nombre</th>
                            <th class="text-left py-3 px-2">Email</th>
                            <th class="text-left py-3 px-2">Rol</th>
                            <th class="text-left py-3 px-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($usuarios as $usuario)
                            <tr class="border-b border-slate-100 hover:bg-slate-50">
                                <td class="py-3 px-2">{{ $usuario->id }}</td>
                                <td class="py-3 px-2 font-medium">{{ $usuario->name }}</td>
                                <td class="py-3 px-2">{{ $usuario->email ?? '-' }}</td>
                                <td class="py-3 px-2">
                                    <span class="px-2 py-1 rounded-full text-xs font-medium {{ $usuario->role === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-slate-100 text-slate-700' }}">
                                        {{ $usuario->role === 'admin' ? 'Administrador' : 'Usuario' }}
                                    </span>
                                </td>
                                <td class="py-3 px-2">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('usuarios.edit', $usuario->id) }}" class="text-slate-600 hover:text-slate-800">
                                            <i data-lucide="edit" class="w-5 h-5"></i>
                                        </a>
                                        <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" onsubmit="return confirm('¿Eliminar este usuario?')" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700" {{ $usuario->id === auth()->id() ? 'disabled' : '' }}>
                                                <i data-lucide="trash-2" class="w-5 h-5"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-500">No hay usuarios registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    lucide.createIcons();
</script>
</body>
</html>