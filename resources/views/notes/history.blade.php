<!DOCTYPE html>
<html>

<head>
    <title>Historial de {{ $note->title }}</title>
    <link rel="icon"
        href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>📝</text></svg>">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-950 text-white font-sans min-h-screen relative">

    <div
        class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[600px] bg-indigo-600/20 blur-[120px] rounded-full pointer-events-none">
    </div>

    <div class="relative max-w-2xl mx-auto px-6 pt-14 pb-20">

        <a href="/"
            class="text-xl font-extrabold tracking-tight bg-gradient-to-b from-white to-gray-400 bg-clip-text text-transparent mb-8 inline-block">
            NOTAS
        </a>

        <h1 class="text-2xl font-bold mb-1">Historial de versiones</h1>
        <p class="text-gray-500 text-sm mb-6">{{ $note->title }}</p>

        @if ($note->versions->isEmpty())
            <p class="text-gray-500 text-sm">Esta nota todavía no tiene versiones anteriores guardadas.</p>
        @else
            <ul class="space-y-3">
                @foreach ($note->versions as $version)
                    <li class="bg-white/5 border border-white/10 rounded-xl p-5">
                        <p class="text-xs text-gray-500 mb-2">{{ $version->created_at->format('d/m/Y H:i') }}</p>
                        <strong class="text-white">{{ $version->title }}</strong>
                        <p class="text-gray-400 text-sm mt-1">{{ $version->content }}</p>

                        <div x-data="{ confirming: false }" class="mt-3">
                            <button @click="confirming = true"
                                class="text-indigo-400 hover:text-indigo-300 text-sm font-medium transition">
                                ↩ Restaurar esta versión
                            </button>

                            <div x-show="confirming" x-cloak
                                class="fixed inset-0 bg-black/60 flex items-center justify-center z-50"
                                @click.self="confirming = false">
                                <div class="bg-gray-900 border border-white/10 rounded-xl p-6 max-w-sm mx-4">
                                    <h3 class="font-semibold text-white mb-2">¿Restaurar esta versión?</h3>
                                    <p class="text-gray-400 text-sm mb-6">El contenido actual de la nota va a ser reemplazado
                                        (aunque igual queda guardado en el historial).</p>

                                    <div class="flex gap-3 justify-end">
                                        <button @click="confirming = false"
                                            class="text-sm text-gray-400 hover:text-white transition px-4 py-2">
                                            Cancelar
                                        </button>

                                        <form action="/notes/{{ $note->id }}/restore/{{ $version->id }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="bg-indigo-500/20 text-indigo-300 text-sm px-4 py-2 rounded-lg hover:bg-indigo-500/30 transition">
                                                Sí, restaurar
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

        <a href="/notes" class="inline-block mt-6 text-sm text-gray-500 hover:text-gray-300 transition">← Volver a la
            lista</a>

    </div>
</body>

</html>