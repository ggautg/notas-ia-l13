<!DOCTYPE html>
<html lang="es">

<head>
    <title>Iniciar sesión</title>
    <link rel="icon"
        href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>💿</text></svg>">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="bg-gradient-to-br from-cyan-100 via-fuchsia-50 to-lime-100 text-gray-900 font-sans min-h-screen relative overflow-hidden">

    <div
        class="absolute top-10 left-10 w-40 h-40 bg-gradient-to-br from-fuchsia-400 to-purple-500 rounded-full blur-2xl opacity-60">
    </div>
    <div
        class="absolute bottom-10 right-10 w-56 h-56 bg-gradient-to-br from-cyan-300 to-blue-400 rounded-full blur-2xl opacity-60">
    </div>

    <div class="relative max-w-md mx-auto px-6 pt-24">

        <div class="text-center mb-8">
            <a href="/" class="text-3xl font-black tracking-tight"
                style="background: linear-gradient(90deg, #ff00cc, #00e5ff, #ccff00); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent;">
                NOTAS
            </a>
        </div>

        <h1 class="text-2xl font-black text-center mb-6">Iniciar sesión</h1>

        @if ($errors->any())
            <div
                class="bg-red-100 border-4 border-black text-red-700 px-4 py-3 rounded-2xl mb-4 text-sm font-medium shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="/login" method="POST" x-data="{ loading: false }" @submit="loading = true"
            class="bg-white border-4 border-black rounded-2xl p-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
            @csrf

            <div class="mb-4">
                <label for="email"
                    class="block text-xs font-bold text-gray-500 mb-1.5 uppercase tracking-wide">Email</label>
                <input type="email" name="email" id="email"
                    class="w-full bg-cyan-50 border-2 border-black rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:bg-white transition">
            </div>

            <div class="mb-6">
                <label for="password"
                    class="block text-xs font-bold text-gray-500 mb-1.5 uppercase tracking-wide">Contraseña</label>
                <input type="password" name="password" id="password"
                    class="w-full bg-cyan-50 border-2 border-black rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:bg-white transition">
            </div>

            <button type="submit" :disabled="loading" x-text="loading ? 'Entrando...' : 'Entrar'"
                class="w-full bg-fuchsia-500 text-white border-4 border-black px-4 py-3 rounded-full text-sm font-bold hover:bg-fuchsia-400 transition shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] disabled:opacity-60">
            </button>
        </form>

        <p class="text-center text-sm text-gray-600 mt-6 font-medium">
            ¿No tenés cuenta? <a href="/register" class="text-fuchsia-600 font-bold hover:underline">Registrate</a>
        </p>

    </div>
</body>

</html>