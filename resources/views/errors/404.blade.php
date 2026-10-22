<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 · Perdido en la cripta</title>
    <link rel="icon"
        href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>&#9760;</text></svg>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800;900&family=Cinzel+Decorative:wght@400;700;900&family=Cormorant+Garamond:wght@300;400;500;600;700&family=Cormorant+SC:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700&family=Jost:wght@300;400;500;600;700&family=Lora:wght@400;500;600;700&family=Marcellus&family=Marcellus+SC&family=Pirata+One&family=Raleway:wght@300;400;500;600;700&family=UnifrakturCook:wght@700&family=UnifrakturMaguntia&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="relative min-h-screen overflow-hidden">

    <div class="pointer-events-none fixed -top-52 right-[-16%] h-[32rem] w-[32rem] rounded-full bg-[radial-gradient(circle,rgba(167,139,250,0.26)_0%,transparent_72%)] blur-3xl"></div>
    <div class="pointer-events-none fixed -bottom-64 left-[-18%] h-[36rem] w-[36rem] rounded-full bg-[radial-gradient(circle,rgba(192,38,211,0.22)_0%,transparent_74%)] blur-3xl"></div>

    <div class="relative mx-auto flex min-h-screen max-w-3xl flex-col items-center justify-center px-6 text-center">
        <div class="gothic-divider mb-10 w-full max-w-lg">
            <span>Sanctum Notarum</span>
        </div>

        <p class="text-xs uppercase tracking-[0.8em] text-[#c4b5fd]/80">Error</p>
        <h1 class="mt-6 text-glow-gothic text-7xl sm:text-8xl md:text-9xl tracking-[0.5em] text-[#c4b5fd]" style="font-family: var(--font-display);">
            404
        </h1>
        <p class="mt-8 max-w-xl text-sm uppercase tracking-[0.6em] text-white/50">
            Esta página se ha perdido entre las criptas del archivo
        </p>

        <div class="mt-12 flex flex-wrap justify-center gap-4">
            <a href="/" class="btn-gothic">
                <span>Volver al inicio</span>
                <span>→</span>
            </a>
            <a href="/notes" class="btn-gothic-ghost">
                <span>Ir al sanctum</span>
            </a>
        </div>

        <div class="gothic-divider mt-14 w-full max-w-lg">
            <span>Mors · Umbræ · Silentium</span>
        </div>
    </div>
</body>

</html>
