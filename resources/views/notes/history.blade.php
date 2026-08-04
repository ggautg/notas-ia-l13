<!DOCTYPE html>
<html lang="es">
<head>
    <title>Historial de {{ $note->title }}</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>💿</text></svg>">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-cyan-100 via-fuchsia-50 to-lime-100 text-gray-900 font-sans min-h-screen relative">

    <div class="absolute top-10 right-10 w-48 h-48 bg-gradient-to-br from-fuchsia-400 to-purple-500 rounded-full blur-2xl opacity-40 pointer-events-none"></div>

    <div class="relative max-w-2xl mx-auto px-6 pt-14 pb-20">

        <a href="/" class="text-2xl font-black tracking-tight mb-8 inline-block" style="background: linear-gradient(90deg, #ff00cc, #00e5ff, #ccff00); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent;">
            NOTAS
        </a>

        <h1 class="text-2xl font-black mb-1">Historial de versiones</h1>
        <p class="text-gray-600 text-sm mb-6 font-medium">{{ $note->title }}</p>

        @if ($note->versions->isEmpty())
            <p class="text-gray-600 text-sm font-medium">Esta nota todavía no tiene versiones anteriores guardadas.</p>
        @else
            <ul class="space-y-4">
                @foreach ($note->versions as $version)
                    <li class="bg-white border-4 border-black rounded-2xl p-5 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                        <p class="text-xs text-gray-500 mb-2 font-medium">{{ $version->created_at->format('d/m/Y H:i') }}</p>
                        <strong class="text-gray-900">{{ $version->title }}</strong>
                        <p class="text-gray-600 text-sm mt-1">{{ $version->content }}</p>

                        <div x-data="{ confirming: false }" class="mt-3">
                            <button @click="confirming = true" class="text-fuchsia-600 hover:text-fuchsia-500 text-sm font-bold transition">
                                ↩ Restaurar esta versión
                            </button>

                            <div x-show="confirming" x-cloak class="fixed inset-0 bg-black/60 flex items-center justify-center z-50" @click.self="confirming = false">
                                <div class="bg-white border-4 border-black rounded-2xl p-6 max-w-sm mx-4 shadow-[6px_6px_0px_0px_rgba(0,0,0,1)]">
                                    <h3 class="font-black text-gray-900 mb-2">¿Restaurar esta versión?</h3>
                                    <p class="text-gray-600 text-sm mb-6 font-medium">El contenido actual va a ser reemplazado (aunque igual queda guardado en el historial).</p>

                                    <div class="flex gap-3 justify-end">
                                        <button @click="confirming = false" class="text-sm text-gray-600 hover:text-gray-900 transition px-4 py-2 font-bold">
                                            Cancelar
                                        </button>

                                        <form action="/notes/{{ $note->id }}/restore/{{ $version->id }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-fuchsia-500 text-white border-2 border-black text-sm px-4 py-2 rounded-full hover:bg-fuchsia-400 transition font-bold">
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

        <a href="/notes" class="inline-block mt-6 text-sm text-gray-600 hover:text-fuchsia-600 font-bold transition">← Volver a la lista</a>

    </div>
</body>
</html>