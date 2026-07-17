<!DOCTYPE html>
<html>
<head>
    <title>Crear cuenta</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>📝</text></svg>">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-950 text-white font-sans min-h-screen relative overflow-hidden">

    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[600px] bg-indigo-600/30 blur-[120px] rounded-full pointer-events-none"></div>
    <div class="absolute bottom-0 right-0 w-[400px] h-[400px] bg-purple-600/20 blur-[100px] rounded-full pointer-events-none"></div>

    <div class="relative max-w-md mx-auto px-6 pt-24">

        <div class="text-center mb-8">
            <a href="/" class="text-2xl font-extrabold tracking-tight bg-gradient-to-b from-white to-gray-400 bg-clip-text text-transparent">
                NOTAS
            </a>
        </div>

        <h1 class="text-2xl font-bold text-center mb-6">Crear cuenta</h1>

        @if ($errors->any())
            <div class="bg-red-500/10 border border-red-500/30 text-red-300 px-4 py-3 rounded-lg mb-4 text-sm">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="/register" method="POST" x-data="{ loading: false }" @submit="loading = true" class="bg-white/5 border border-white/10 rounded-xl p-6">
    @csrf

            <div class="mb-4">
                <label for="name" class="block text-xs font-semibold text-gray-400 mb-1.5 uppercase tracking-wide">Nombre</label>
                <input type="text" name="name" id="name" class="w-full bg-white/5 border border-white/10 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-indigo-500 transition">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-xs font-semibold text-gray-400 mb-1.5 uppercase tracking-wide">Email</label>
                <input type="email" name="email" id="email" class="w-full bg-white/5 border border-white/10 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-indigo-500 transition">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-xs font-semibold text-gray-400 mb-1.5 uppercase tracking-wide">Contraseña</label>
                <input type="password" name="password" id="password" class="w-full bg-white/5 border border-white/10 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-indigo-500 transition">
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-xs font-semibold text-gray-400 mb-1.5 uppercase tracking-wide">Confirmar contraseña</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="w-full bg-white/5 border border-white/10 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-indigo-500 transition">
            </div>

            <button type="submit" :disabled="loading" x-text="loading ? 'Creando cuenta...' : 'Registrarme'" class="w-full bg-indigo-600 text-white px-4 py-3 rounded-lg text-sm font-semibold hover:bg-indigo-500 transition shadow-[0_0_30px_-5px_rgba(99,102,241,0.6)] disabled:opacity-60">
</button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-6">
            ¿Ya tenés cuenta? <a href="/login" class="text-indigo-400 hover:text-indigo-300">Iniciá sesión</a>
        </p>

    </div>
</body>
</html>