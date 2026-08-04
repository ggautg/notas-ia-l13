<!DOCTYPE html>
<html lang="es">
<head>
    <title>{{ $note->title }}</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>💿</text></svg>">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-cyan-100 via-fuchsia-50 to-lime-100 text-gray-900 font-sans min-h-screen relative">

    <div class="absolute top-10 right-10 w-48 h-48 bg-gradient-to-br from-fuchsia-400 to-purple-500 rounded-full blur-2xl opacity-40 pointer-events-none"></div>

    <div class="relative max-w-2xl mx-auto px-6 pt-14 pb-20">

        <a href="/" class="text-2xl font-black tracking-tight mb-6 inline-block" style="background: linear-gradient(90deg, #ff00cc, #00e5ff, #ccff00); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent;">
            NOTAS
        </a>

        <p class="text-xs text-gray-500 mb-4 font-bold uppercase tracking-wide">Nota compartida</p>

        <div class="bg-white border-4 border-black rounded-2xl p-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
            <h1 class="text-2xl font-black mb-4">
                @if ($note->emoji)
                    {{ $note->emoji }}
                @endif
                {{ $note->title }}
            </h1>

            @if ($note->image)
                <img src="{{ Storage::url($note->image) }}" alt="{{ $note->title }}" class="w-full max-w-xs rounded-xl mb-4 border-2 border-black">
            @endif

            <p class="text-gray-700">{{ $note->content }}</p>

            @if ($note->tags->isNotEmpty())
                <div class="flex gap-2 mt-4 flex-wrap">
                    @foreach ($note->tags as $tag)
                        <span class="bg-cyan-100 border-2 border-black text-cyan-800 text-xs px-2.5 py-1 rounded-full font-medium">
                            {{ $tag->name }}
                        </span>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</body>
</html>