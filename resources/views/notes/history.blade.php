<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Historial · {{ $note->title }}</title>
    <link rel="icon"
        href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>&#9760;</text></svg>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800;900&family=Cinzel+Decorative:wght@400;700;900&family=Cormorant+Garamond:wght@300;400;500;600;700&family=Cormorant+SC:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700&family=Jost:wght@300;400;500;600;700&family=Lora:wght@400;500;600;700&family=Marcellus&family=Marcellus+SC&family=Pirata+One&family=Raleway:wght@300;400;500;600;700&family=UnifrakturCook:wght@700&family=UnifrakturMaguntia&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="relative min-h-screen">

    <div class="pointer-events-none fixed -top-48 right-[-12%] h-[28rem] w-[28rem] rounded-full bg-[radial-gradient(circle,rgba(167,139,250,0.26)_0%,transparent_72%)] blur-3xl"></div>
    <div class="pointer-events-none fixed -bottom-56 left-[-14%] h-[32rem] w-[32rem] rounded-full bg-[radial-gradient(circle,rgba(192,38,211,0.22)_0%,transparent_74%)] blur-3xl"></div>

    <div class="relative mx-auto max-w-2xl px-6 pt-16 pb-24">
        <header class="mb-12 text-center">
            <div class="gothic-divider mb-7">
                <span>Sanctum Notarum</span>
            </div>
            <a href="/notes" class="text-glow-gothic text-4xl sm:text-5xl tracking-[0.6em] text-[#c4b5fd] uppercase" style="font-family: var(--font-display);">
                NOTAS
            </a>
            <p class="mt-6 text-xs uppercase tracking-[0.6em] text-white/50">Archivo de versiones</p>
            <div class="mt-8 flex justify-center">
                <a href="/notes" class="btn-gothic-ghost">
                    <span>← Volver al archivo</span>
                </a>
            </div>
        </header>

        <div class="mb-10 text-center">
            <p class="text-xs uppercase tracking-[0.6em] text-[#c4b5fd]/80">Historial</p>
            <h1 class="mt-4 text-lg tracking-[0.4em]">{{ $note->title }}</h1>
            <div class="ornament-gothic my-7"></div>
        </div>

        @if ($note->versions->isEmpty())
            <div class="gothic-panel text-center py-12 px-6">
                <p class="text-sm uppercase tracking-[0.4em] text-white/60">Sin versiones anteriores registradas</p>
            </div>
        @else
            <ul class="space-y-5">
                @foreach ($note->versions as $version)
                    <li class="gothic-panel note-gothic p-6 sm:p-7">
                        <p class="text-xs uppercase tracking-[0.4em] text-white/40">{{ $version->created_at->format('d/m/Y H:i') }}</p>
                        <h2 class="mt-3 text-base tracking-[0.3em] text-[#c4b5fd]">{{ $version->title }}</h2>
                        <p class="mt-4 whitespace-pre-line text-base leading-relaxed text-white/80" style="font-family: var(--font-elegant); font-size: 1.02rem;">{{ $version->content }}</p>

                        <div class="ornament-gothic my-6"></div>

                        <div x-data="{ confirming: false }">
                            <button @click="confirming = true" class="text-xs uppercase tracking-[0.4em] text-[#c4b5fd] hover:text-[#d7ccff]">
                                ↩ Restaurar esta versión
                            </button>

                            <div x-show="confirming" x-cloak class="modal-gothic fixed inset-0 flex items-center justify-center z-50 px-4" @click.self="confirming = false">
                                <div class="gothic-panel max-w-sm w-full p-7 text-center">
                                    <p class="text-xs uppercase tracking-[0.6em] text-[#c4b5fd]">Confirmar restauración</p>
                                    <h3 class="mt-4 text-lg tracking-[0.4em]">¿Restaurar esta versión?</h3>
                                    <p class="mt-3 text-sm text-white/60">El contenido actual será reemplazado, pero quedará guardado en el historial.</p>

                                    <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-center">
                                        <button @click="confirming = false" class="btn-gothic-ghost">
                                            <span>Cancelar</span>
                                        </button>
                                        <form action="/notes/{{ $note->id }}/restore/{{ $version->id }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-gothic">
                                                <span>Sí, restaurar</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</body>

</html>
