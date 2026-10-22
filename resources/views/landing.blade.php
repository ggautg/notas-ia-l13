<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Notas · Sanctum</title>
    <link rel="icon"
        href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>&#9760;</text></svg>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800;900&family=Cinzel+Decorative:wght@400;700;900&family=Cormorant+Garamond:wght@300;400;500;600;700&family=Cormorant+SC:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700&family=Jost:wght@300;400;500;600;700&family=Lora:wght@400;500;600;700&family=Marcellus&family=Marcellus+SC&family=Pirata+One&family=Raleway:wght@300;400;500;600;700&family=UnifrakturCook:wght@700&family=UnifrakturMaguntia&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="relative min-h-screen overflow-hidden">

    <div class="pointer-events-none fixed -top-52 right-[-16%] h-[36rem] w-[36rem] rounded-full bg-[radial-gradient(circle,rgba(167,139,250,0.28)_0%,transparent_72%)] blur-3xl"></div>
    <div class="pointer-events-none fixed -bottom-64 left-[-18%] h-[40rem] w-[40rem] rounded-full bg-[radial-gradient(circle,rgba(192,38,211,0.24)_0%,transparent_74%)] blur-3xl"></div>
    <div class="pointer-events-none fixed top-1/2 left-1/2 h-[48rem] w-[48rem] -translate-x-1/2 -translate-y-1/2 rounded-full bg-[radial-gradient(circle,rgba(124,58,237,0.18)_0%,transparent_78%)] blur-[150px]"></div>

    <div class="relative mx-auto flex min-h-screen max-w-4xl flex-col items-center justify-center px-6 text-center">
        <div class="gothic-divider mb-10 w-full max-w-xl">
            <span>Sanctum Notarum</span>
        </div>

        <h1 class="text-glow-gothic text-6xl sm:text-7xl md:text-8xl tracking-[0.6em] text-[#c4b5fd] uppercase" style="font-family: var(--font-display);">
            NOTAS
        </h1>

        <p class="mt-8 max-w-2xl text-sm uppercase tracking-[0.6em] text-white/50">
            Un archivo gótico para tus ideas · Minimal · Elegante · Inquietante
        </p>

        <div class="mt-14 flex flex-wrap justify-center gap-4">
            @auth
                <a href="/notes" class="btn-gothic">
                    <span>Ir a mis notas</span>
                    <span>→</span>
                </a>
            @else
                <a href="/register" class="btn-gothic">
                    <span>Empezar gratis</span>
                    <span>→</span>
                </a>
                <a href="/login" class="btn-gothic-ghost">
                    <span>Iniciar sesión</span>
                </a>
            @endauth
        </div>

        <div class="gothic-divider mt-16 w-full max-w-xl">
            <span>Noctis · Ars · Memoria</span>
        </div>
    </div>
</body>

</html>