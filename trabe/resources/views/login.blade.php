<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QOSTO - Iniciar Sesión</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 flex items-center justify-center px-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo.jpeg') }}" alt="Trabe Ingeniería" class="w-auto h-40 mx-auto mb-6">
            <h1 class="text-5xl font-bold text-white mb-2">QOSTO</h1>
            <p class="text-slate-300 text-lg">Gestión de Proyectos de Construcción</p>
        </div>

        <div class="bg-white rounded-2xl p-8 shadow-2xl">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nombre de usuario</label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus
                           class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent"
                           placeholder="Nombre de usuario">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Contraseña</label>
                    <input type="password" name="password" required
                           class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent"
                           placeholder="Contraseña">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        class="w-full bg-gradient-to-r from-slate-700 to-slate-800 text-white py-3 rounded-lg hover:shadow-lg transition-shadow font-semibold text-lg">
                    Iniciar sesión
                </button>
            </form>
        </div>

        <p class="text-center text-slate-400 text-sm mt-6">
            © 2026 Trabe Ingeniería - Todos los derechos reservados
        </p>
    </div>
</body>
</html>