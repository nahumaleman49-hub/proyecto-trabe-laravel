<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($usuario) ? 'Editar Usuario' : 'Nuevo Usuario' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-50">

<div class="min-h-screen">
    <div class="relative h-64 overflow-hidden bg-gradient-to-r from-slate-700 to-slate-800">
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white">
                <i data-lucide="user-plus" class="w-16 h-16 mx-auto mb-4"></i>
                <h1 class="text-5xl font-bold mb-2">{{ isset($usuario) ? 'Editar Usuario' : 'Nuevo Usuario' }}</h1>
                <p class="text-xl text-slate-300">{{ isset($usuario) ? 'Modifica los datos del usuario' : 'Crea una nueva cuenta de acceso' }}</p>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8 max-w-2xl">
        <a href="{{ route('usuarios.index') }}" class="inline-flex items-center text-slate-600 hover:text-slate-800 transition-colors mb-8">
            <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i>
            Volver a Usuarios
        </a>

        <div class="bg-white rounded-2xl p-8 shadow-lg">
            <form action="{{ isset($usuario) ? route('usuarios.update', $usuario->id) : route('usuarios.store') }}" method="POST">
                @csrf
                @if(isset($usuario)) @method('PUT') @endif

                <div class="space-y-6">
                    <div>
                        <label class="block text-slate-700 font-semibold mb-2">Nombre completo *</label>
                        <input type="text" name="name" value="{{ old('name', $usuario->name ?? '') }}" required
                               class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-500">
                    </div>

                    <div>
                        <label class="block text-slate-700 font-semibold mb-2">Correo electrónico</label>
                        <input type="email" name="email" value="{{ old('email', $usuario->email ?? '') }}"
                               class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-500">
                        <p class="text-xs text-slate-500 mt-1">Opcional, solo si el usuario usará correo para recuperar contraseña.</p>
                    </div>

                    <div>
                        <label class="block text-slate-700 font-semibold mb-2">Contraseña {{ isset($usuario) ? '(dejar en blanco para no cambiar)' : '*' }}</label>
                        <input type="password" name="password" {{ isset($usuario) ? '' : 'required' }}
                               class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-500">
                    </div>

                    <div>
                        <label class="block text-slate-700 font-semibold mb-2">Confirmar contraseña {{ isset($usuario) ? '(si se cambia)' : '*' }}</label>
                        <input type="password" name="password_confirmation" {{ isset($usuario) ? '' : 'required' }}
                               class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-500">
                    </div>

                    <div>
                        <label class="block text-slate-700 font-semibold mb-2">Rol *</label>
                        <select name="role" required class="w-full px-4 py-3 border border-slate-300 rounded-lg">
                            <option value="user" {{ old('role', $usuario->role ?? '') == 'user' ? 'selected' : '' }}>Usuario normal</option>
                            <option value="admin" {{ old('role', $usuario->role ?? '') == 'admin' ? 'selected' : '' }}>Administrador</option>
                        </select>
                    </div>
                </div>

                <div class="mt-8 flex gap-4">
                    <button type="submit" class="bg-slate-700 text-white px-8 py-3 rounded-lg hover:bg-slate-800 transition">
                        <i data-lucide="save" class="w-5 h-5 inline mr-2"></i>
                        {{ isset($usuario) ? 'Actualizar Usuario' : 'Crear Usuario' }}
                    </button>
                    <a href="{{ route('usuarios.index') }}" class="px-8 py-3 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    lucide.createIcons();
</script>
</body>
</html>