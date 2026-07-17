<!DOCTYPE html>
<html>
<head>
    <title>{{ $note->title }}</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>📝</text></svg>">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-950 text-white font-sans min-h-screen relative">

    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[600px] bg-indigo-600/20 blur-[120px] rounded-full pointer-events-none"></div>

    <div class="relative max-w-2xl mx-auto px-6 pt-14 pb-20">

        <a href="/" class="text-xl font-extrabold tracking-tight bg-gradient-to-b from-white to-gray-400 bg-clip-text text-transparent mb-6 inline-block">
            NOTAS
        </a>

        <p class="text-xs text-gray-500 mb-4">Nota compartida</p>

        <div class="bg-white/5 border border-white/10 rounded-xl p-6">
            <h1 class="text-2xl font-bold mb-4">
    @if ($note->emoji)
        {{ $note->emoji }}
    @endif
    {{ $note->title }}
</h1>

            @if ($note->image)
                <img src="{{ Storage::url($note->image) }}" alt="{{ $note->title }}" class="w-full max-w-xs rounded-lg mb-4">
            @endif

            <p class="text-gray-300">{{ $note->content }}</p>

            @if ($note->tags->isNotEmpty())
                <div class="flex gap-2 mt-4 flex-wrap">
                    @foreach ($note->tags as $tag)
                        <span class="bg-indigo-500/10 text-indigo-300 text-xs px-2.5 py-1 rounded-full">
                            {{ $tag->name }}
                        </span>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</body>
</html>