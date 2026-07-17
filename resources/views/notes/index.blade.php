<!DOCTYPE html>
<html lang="es">

<head>
    <title>Mis Notas</title>
    <link rel="icon"
        href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>📝</text></svg>">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-950 text-white font-sans min-h-screen relative">

    <div
        class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[600px] bg-indigo-600/20 blur-[120px] rounded-full pointer-events-none">
    </div>

    <div class="relative max-w-2xl mx-auto px-6 pt-14 pb-20">

        <div class="flex justify-between items-center mb-8">
            <a href="/"
                class="text-xl font-extrabold tracking-tight bg-gradient-to-b from-white to-gray-400 bg-clip-text text-transparent">
                NOTAS
            </a>

            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="text-xs text-gray-500 hover:text-gray-300 transition">
                    {{ auth()->user()->name }} · Cerrar sesión
                </button>
            </form>
        </div>

        @if (session('success'))
            <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 px-4 py-3 rounded-lg mb-4 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <a href="/notes/create"
            class="inline-block bg-indigo-600 text-white px-4 py-2.5 rounded-lg text-sm font-semibold hover:bg-indigo-500 transition shadow-[0_0_30px_-5px_rgba(99,102,241,0.6)] mb-6">
            + Nueva nota
        </a>

        <form action="/notes/search" method="GET" class="flex gap-2 mb-6">
            <input type="text" name="query" placeholder="Buscar por título o contenido..."
                value="{{ request('query') }}"
                class="flex-1 bg-white/5 border border-white/10 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-indigo-500 transition">

            <select name="sort" x-data @change="$el.form.action = '/notes'; $el.form.submit()"
                class="bg-white/5 border border-white/10 rounded-lg px-3 py-2.5 text-xs text-gray-300 focus:outline-none focus:border-indigo-500 transition">
                <option value="recent" {{ request('sort', 'recent') === 'recent' ? 'selected' : '' }}>Más recientes
                </option>
                <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Más antiguas</option>
                <option value="az" {{ request('sort') === 'az' ? 'selected' : '' }}>Alfabético (A-Z)</option>
            </select>

            <button type="submit"
                class="bg-white/10 text-white px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-white/20 transition">
                Buscar
            </button>
        </form>

        @if (request('query') || request('tag'))
            <div class="flex items-center gap-2 mb-6 text-xs text-gray-400">
                @if (request('query'))
                    <span>Buscando: "{{ request('query') }}"</span>
                @endif
                @if (request('tag'))
                    <span>Etiqueta: "{{ request('tag') }}"</span>
                @endif
                <a href="/notes" class="text-indigo-400 hover:text-indigo-300">✕ Ver todas</a>
            </div>
        @endif

        @if ($notes->isEmpty())
            <div class="text-center py-16">
                <p class="text-4xl mb-4">📭</p>
                @if (request('query') || request('tag'))
                    <p class="text-gray-400 text-sm">No encontramos ninguna nota con ese filtro.</p>
                @else
                    <p class="text-gray-400 text-sm mb-4">Todavía no tenés notas.</p>
                    <a href="/notes/create" class="text-indigo-400 hover:text-indigo-300 text-sm font-medium">
                        Creá la primera →
                    </a>
                @endif
            </div>
        @endif


        <ul class="space-y-3">
            @foreach ($notes as $note)
                <li
                    class="bg-white/5 border rounded-xl p-5 transition {{ $note->pinned ? 'border-indigo-500/40 bg-indigo-500/5' : 'border-white/10 hover:border-white/20' }}">

                    <div class="flex justify-between items-center">
                        <strong class="text-white flex items-center gap-1.5">
                            @if ($note->emoji)
                                <span>{{ $note->emoji }}</span>
                            @endif
                            <span>{{ $note->title }}</span>
                        </strong>

                        <form action="/notes/{{ $note->id }}/pin" method="POST">
                            @csrf
                            <button type="submit"
                                class="text-sm shrink-0 transition {{ $note->pinned ? 'opacity-100' : 'opacity-30 hover:opacity-60' }}">
                                📌
                            </button>
                        </form>
                    </div>

                    @if ($note->image)
                        <img src="{{ Storage::url($note->image) }}" alt="{{ $note->title }}"
                            class="w-full max-w-xs rounded-lg mt-3">
                    @endif

                    <p class="text-gray-400 text-sm mt-2">{{ Str::limit($note->content, 150) }}</p>

                    @if ($note->tags->isNotEmpty())
                        <div class="flex gap-2 mt-3 flex-wrap">
                            @foreach ($note->tags as $tag)
                                <a href="{{ request('query') ? '/notes/search?query=' . request('query') . '&tag=' . $tag->name : '/notes?tag=' . $tag->name }}"
                                    class="bg-indigo-500/10 text-indigo-300 text-xs px-2.5 py-1 rounded-full hover:bg-indigo-500/20 transition">
                                    {{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                    @endif

                    <div class="flex gap-4 mt-4 text-xs">
                        <a href="/notes/{{ $note->id }}/edit" class="text-gray-400 hover:text-white transition">Editar</a>

                        <div x-data="{ confirming: false }">
                            <button @click="confirming = true"
                                class="text-red-400/70 hover:text-red-400 transition text-xs">Borrar</button>

                            <div x-show="confirming" x-cloak
                                class="fixed inset-0 bg-black/60 flex items-center justify-center z-50"
                                @click.self="confirming = false">
                                <div class="bg-gray-900 border border-white/10 rounded-xl p-6 max-w-sm mx-4">
                                    <h3 class="font-semibold text-white mb-2">¿Borrar esta nota?</h3>
                                    <p class="text-gray-400 text-sm mb-6">Esta acción no se puede deshacer.</p>

                                    <div class="flex gap-3 justify-end">
                                        <button @click="confirming = false"
                                            class="text-sm text-gray-400 hover:text-white transition px-4 py-2">
                                            Cancelar
                                        </button>

                                        <form action="/notes/{{ $note->id }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-500/20 text-red-300 text-sm px-4 py-2 rounded-lg hover:bg-red-500/30 transition">
                                                Sí, borrar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form action="/notes/{{ $note->id }}/share" method="POST">
                            @csrf
                            <button type="submit" class="text-gray-400 hover:text-white transition">🔗 Compartir</button>
                        </form>

                        <a href="/notes/{{ $note->id }}/pdf" class="text-gray-400 hover:text-white transition">📄 PDF</a>
                        <a href="/notes/{{ $note->id }}/history" class="text-gray-400 hover:text-white transition">🕒
                            Historial</a>
                    </div>

                    @if ($note->share_token)
                        <div x-data="{ copied: false }" class="flex items-center gap-2 mt-2">
                            <p class="text-xs text-gray-600">{{ url('/shared/' . $note->share_token) }}</p>
                            <button type="button"
                                @click="navigator.clipboard.writeText('{{ url('/shared/' . $note->share_token) }}'); copied = true; setTimeout(() => copied = false, 2000)"
                                class="text-xs text-indigo-400 hover:text-indigo-300 transition"
                                x-text="copied ? '✓ Copiado' : 'Copiar'"></button>
                        </div>
                    @endif

                </li>
            @endforeach
        </ul>

        @if ($notes instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="mt-6">
                {{ $notes->links() }}
            </div>
        @endif

    </div>
</body>

</html>