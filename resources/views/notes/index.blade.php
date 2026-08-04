<!DOCTYPE html>
<html lang="es">

<head>
    <title>Mis Notas</title>
    <link rel="icon"
        href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>💿</text></svg>">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-cyan-100 via-fuchsia-50 to-lime-100 text-gray-900 font-sans min-h-screen relative">

    <div
        class="absolute top-10 right-10 w-48 h-48 bg-gradient-to-br from-fuchsia-400 to-purple-500 rounded-full blur-2xl opacity-40 pointer-events-none">
    </div>
    <div
        class="absolute bottom-10 left-10 w-56 h-56 bg-gradient-to-br from-cyan-300 to-blue-400 rounded-full blur-2xl opacity-40 pointer-events-none">
    </div>

    <div class="relative max-w-2xl mx-auto px-6 pt-14 pb-20">

        <div class="flex justify-between items-center mb-8">
            <a href="/" class="text-2xl font-black tracking-tight"
                style="background: linear-gradient(90deg, #ff00cc, #00e5ff, #ccff00); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent;">
                NOTAS
            </a>

            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="text-xs text-gray-600 hover:text-fuchsia-600 font-bold transition">
                    {{ auth()->user()->name }} · Cerrar sesión
                </button>
            </form>
        </div>

        @if (session('success'))
            <div
                class="bg-lime-100 border-4 border-black text-lime-800 px-4 py-3 rounded-2xl mb-4 text-sm font-bold shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                {{ session('success') }}
            </div>
        @endif

        <a href="/notes/create"
            class="inline-block bg-fuchsia-500 text-white border-4 border-black px-4 py-2.5 rounded-full text-sm font-bold hover:bg-fuchsia-400 transition shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] mb-4">
            + Nueva nota
        </a>

        <div class="flex items-center gap-4 text-xs text-gray-600 font-medium mb-6">
            <span>{{ $totalNotes }} {{ Str::plural('nota', $totalNotes) }}</span>

            @if ($topTags->isNotEmpty())
                <span>·</span>
                <span>
                    Más usadas:
                    @foreach ($topTags as $tag)
                        <span class="text-fuchsia-600 font-bold">{{ $tag->name }}</span>{{ !$loop->last ? ', ' : '' }}
                    @endforeach
                </span>
            @endif
        </div>

        <form action="/notes/search" method="GET" class="flex gap-2 mb-6">
            <input type="text" name="query" placeholder="Buscar por título o contenido..."
                value="{{ request('query') }}"
                class="flex-1 bg-white border-2 border-black rounded-full px-4 py-2.5 text-sm focus:outline-none focus:bg-cyan-50 transition">

            <select name="sort" x-data @change="$el.form.action = '/notes'; $el.form.submit()"
                class="bg-white border-2 border-black rounded-full px-3 py-2.5 text-xs text-gray-700 font-medium focus:outline-none">
                <option value="recent" {{ request('sort', 'recent') === 'recent' ? 'selected' : '' }}>Más recientes
                </option>
                <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Más antiguas</option>
                <option value="az" {{ request('sort') === 'az' ? 'selected' : '' }}>Alfabético (A-Z)</option>
            </select>

            <button type="submit"
                class="bg-cyan-400 text-black border-2 border-black px-4 py-2.5 rounded-full text-sm font-bold hover:bg-cyan-300 transition">
                Buscar
            </button>
        </form>

        @if (request('query') || request('tag'))
            <div class="flex items-center gap-2 mb-6 text-xs text-gray-600 font-medium">
                @if (request('query'))
                    <span>Buscando: "{{ request('query') }}"</span>
                @endif
                @if (request('tag'))
                    <span>Etiqueta: "{{ request('tag') }}"</span>
                @endif
                <a href="/notes" class="text-fuchsia-600 font-bold hover:underline">✕ Ver todas</a>
            </div>
        @endif

        @if ($notes->isEmpty())
            <div class="text-center py-16">
                <p class="text-5xl mb-4">📭</p>
                @if (request('query') || request('tag'))
                    <p class="text-gray-600 text-sm font-medium">No encontramos ninguna nota con ese filtro.</p>
                @else
                    <p class="text-gray-600 text-sm mb-4 font-medium">Todavía no tenés notas.</p>
                    <a href="/notes/create" class="text-fuchsia-600 hover:underline text-sm font-bold">
                        Creá la primera →
                    </a>
                @endif
            </div>
        @endif

        <ul class="space-y-4">
            @foreach ($notes as $note)
                <li
                    class="bg-white border-4 border-black rounded-2xl p-5 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] {{ $note->pinned ? 'ring-4 ring-fuchsia-300' : '' }}">

                    <div class="flex justify-between items-center">
                        <strong class="text-gray-900 flex items-center gap-1.5">
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
                            class="w-full max-w-xs rounded-xl mt-3 border-2 border-black">
                    @endif

                    <p class="text-gray-600 text-sm mt-2">{{ Str::limit($note->content, 150) }}</p>

                    @if ($note->tags->isNotEmpty())
                        <div class="flex gap-2 mt-3 flex-wrap">
                            @foreach ($note->tags as $tag)
                                <a href="{{ request('query') ? '/notes/search?query=' . request('query') . '&tag=' . $tag->name : '/notes?tag=' . $tag->name }}"
                                    class="bg-cyan-100 border-2 border-black text-cyan-800 text-xs px-2.5 py-1 rounded-full hover:bg-cyan-200 transition font-medium">
                                    {{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                    @endif

                    <div class="flex gap-4 mt-4 text-xs font-bold">
                        <a href="/notes/{{ $note->id }}/edit"
                            class="text-gray-600 hover:text-fuchsia-600 transition">Editar</a>

                        <div x-data="{ confirming: false }">
                            <button @click="confirming = true"
                                class="text-red-500 hover:text-red-600 transition">Borrar</button>

                            <div x-show="confirming" x-cloak
                                class="fixed inset-0 bg-black/60 flex items-center justify-center z-50"
                                @click.self="confirming = false">
                                <div
                                    class="bg-white border-4 border-black rounded-2xl p-6 max-w-sm mx-4 shadow-[6px_6px_0px_0px_rgba(0,0,0,1)]">
                                    <h3 class="font-black text-gray-900 mb-2">¿Borrar esta nota?</h3>
                                    <p class="text-gray-600 text-sm mb-6 font-medium">Esta acción no se puede deshacer.</p>

                                    <div class="flex gap-3 justify-end">
                                        <button @click="confirming = false"
                                            class="text-sm text-gray-600 hover:text-gray-900 transition px-4 py-2 font-bold">
                                            Cancelar
                                        </button>

                                        <form action="/notes/{{ $note->id }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-500 text-white border-2 border-black text-sm px-4 py-2 rounded-full hover:bg-red-400 transition font-bold">
                                                Sí, borrar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form action="/notes/{{ $note->id }}/share" method="POST">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-fuchsia-600 transition">🔗
                                Compartir</button>
                        </form>

                        <a href="/notes/{{ $note->id }}/pdf" class="text-gray-600 hover:text-fuchsia-600 transition">📄
                            PDF</a>
                        <a href="/notes/{{ $note->id }}/history" class="text-gray-600 hover:text-fuchsia-600 transition">🕒
                            Historial</a>
                    </div>

                    @if ($note->share_token)
                        <div x-data="{ copied: false }" class="flex items-center gap-2 mt-2">
                            <p class="text-xs text-gray-500">{{ url('/shared/' . $note->share_token) }}</p>
                            <button type="button"
                                @click="navigator.clipboard.writeText('{{ url('/shared/' . $note->share_token) }}'); copied = true; setTimeout(() => copied = false, 2000)"
                                class="text-xs text-fuchsia-600 font-bold hover:underline"
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