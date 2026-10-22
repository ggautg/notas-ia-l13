<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $note->title }} · Nota compartida</title>
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
        <header class="mb-10 text-center">
            <div class="gothic-divider mb-7">
                <span>Sanctum Notarum</span>
            </div>
            <a href="/" class="text-glow-gothic text-4xl sm:text-5xl tracking-[0.6em] text-[#c4b5fd] uppercase" style="font-family: var(--font-display);">
                NOTAS
            </a>
            <p class="mt-6 text-xs uppercase tracking-[0.6em] text-white/50">Nota compartida</p>
        </header>

        <article class="gothic-panel note-gothic px-6 py-9 sm:px-10">
            <div class="flex items-center gap-3">
                @if ($note->emoji)
                    <span class="text-3xl">{{ $note->emoji }}</span>
                @endif
                <h1 class="text-lg sm:text-xl tracking-[0.32em] text-[#c4b5fd]">{{ $note->title }}</h1>
            </div>

            @if ($note->image)
                <img src="{{ Storage::url($note->image) }}" alt="{{ $note->title }}" class="mt-6 w-full max-w-md rounded-2xl border border-[#a78bfa]/60 shadow-[0_40px_80px_-40px_rgba(167,139,250,0.5)]">
            @endif

            <p class="mt-6 whitespace-pre-line text-base leading-relaxed text-white/90" style="font-family: var(--font-elegant); font-size: 1.08rem;">{{ $note->content }}</p>

            @if ($note->tags->isNotEmpty())
                <div class="mt-8 flex flex-wrap gap-2">
                    @foreach ($note->tags as $tag)
                        <span class="tag-gothic">{{ $tag->name }}</span>
                    @endforeach
                </div>
            @endif

            <div class="ornament-gothic my-8"></div>
            <p class="text-center text-xs uppercase tracking-[0.5em] text-white/40">Ex umbris · Ad memoriam</p>
        </article>
    </div>
</body>

</html>
