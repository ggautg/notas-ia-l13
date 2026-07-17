<!DOCTYPE html>
<html>
<head>
    <title>Notas IA</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>📝</text></svg>">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-950 text-white font-sans min-h-screen relative overflow-hidden">

    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[600px] bg-indigo-600/30 blur-[120px] rounded-full pointer-events-none"></div>
    <div class="absolute bottom-0 right-0 w-[400px] h-[400px] bg-purple-600/20 blur-[100px] rounded-full pointer-events-none"></div>

    <div class="relative max-w-3xl mx-auto px-6 pt-32 pb-20 text-center">

        <div class="inline-flex items-center gap-2 bg-white/5 border border-white/10 rounded-full px-4 py-1.5 text-xs text-indigo-300 mb-8">
            <span class="w-2 h-2 bg-indigo-400 rounded-full animate-pulse"></span>
            Tu segundo cerebro, siempre a mano
        </div>

        <h1 class="text-5xl sm:text-6xl font-extrabold tracking-tight mb-6 bg-gradient-to-b from-white to-gray-400 bg-clip-text text-transparent">
            NOTAS
        </h1>

        <p class="text-gray-400 text-lg mb-10 max-w-xl mx-auto">
            Organizá tus ideas, sumale etiquetas e imágenes, y compartí lo que quieras con un solo link.
        </p>

        <div class="flex justify-center gap-4 mb-20">
            @auth
                <a href="/notes" class="group relative bg-indigo-600 text-white px-8 py-3.5 rounded-lg text-sm font-semibold hover:bg-indigo-500 transition shadow-[0_0_30px_-5px_rgba(99,102,241,0.6)]">
                    Ir a mis notas →
                </a>
            @else
                <a href="/register" class="group relative bg-indigo-600 text-white px-8 py-3.5 rounded-lg text-sm font-semibold hover:bg-indigo-500 transition shadow-[0_0_30px_-5px_rgba(99,102,241,0.6)]">
                    Empezar gratis →
                </a>
                <a href="/login" class="border border-white/15 text-gray-200 px-8 py-3.5 rounded-lg text-sm font-semibold hover:bg-white/5 transition">
                    Iniciar sesión
                </a>
            @endauth
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-left">
            <div class="bg-white/5 border border-white/10 rounded-xl p-5">
                <div class="text-2xl mb-2">🏷️</div>
                <h3 class="font-semibold text-sm mb-1">Etiquetas</h3>
                <p class="text-gray-400 text-xs">Organizá y filtrá tus notas como quieras.</p>
            </div>
            <div class="bg-white/5 border border-white/10 rounded-xl p-5">
                <div class="text-2xl mb-2">🔗</div>
                <h3 class="font-semibold text-sm mb-1">Links públicos</h3>
                <p class="text-gray-400 text-xs">Compartí una nota sin que necesiten cuenta.</p>
            </div>
            <div class="bg-white/5 border border-white/10 rounded-xl p-5">
                <div class="text-2xl mb-2">🕒</div>
                <h3 class="font-semibold text-sm mb-1">Historial</h3>
                <p class="text-gray-400 text-xs">Volvé a cualquier versión anterior.</p>
            </div>
        </div>

    </div>
</body>
</html>