<!DOCTYPE html>
<html lang="es">
<head>
    <title>Notas</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>💿</text></svg>">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-cyan-100 via-fuchsia-50 to-lime-100 text-gray-900 font-sans min-h-screen relative overflow-hidden">

    <div class="absolute top-10 left-10 w-40 h-40 bg-gradient-to-br from-fuchsia-400 to-purple-500 rounded-full blur-2xl opacity-60"></div>
    <div class="absolute bottom-10 right-10 w-56 h-56 bg-gradient-to-br from-cyan-300 to-blue-400 rounded-full blur-2xl opacity-60"></div>
    <div class="absolute top-1/3 right-1/4 w-32 h-32 bg-gradient-to-br from-lime-300 to-yellow-300 rounded-full blur-2xl opacity-50"></div>

    <div class="relative max-w-3xl mx-auto px-6 pt-28 pb-20 text-center">


        <h1 class="text-6xl sm:text-7xl font-black tracking-tight mb-6" style="background: linear-gradient(90deg, #ff00cc, #00e5ff, #ccff00); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; text-shadow: 3px 3px 0px rgba(0,0,0,0.1);">
            NOTAS
        </h1>

        <div class="flex justify-center gap-4 mb-20">
            @auth
                <a href="/notes" class="bg-fuchsia-500 text-white border-4 border-black px-8 py-3.5 rounded-full text-sm font-bold hover:bg-fuchsia-400 transition shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[2px] hover:translate-y-[2px]">
                    Ir a mis notas →
                </a>
            @else
                <a href="/register" class="bg-fuchsia-500 text-white border-4 border-black px-8 py-3.5 rounded-full text-sm font-bold hover:bg-fuchsia-400 transition shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[2px] hover:translate-y-[2px]">
                    Empezar gratis →
                </a>
                <a href="/login" class="bg-white border-4 border-black px-8 py-3.5 rounded-full text-sm font-bold hover:bg-cyan-100 transition shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[2px] hover:translate-y-[2px]">
                    Iniciar sesión
                </a>
            @endauth
        </div>

    </div>
</body>
</html>