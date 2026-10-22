<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mis Notas</title>
    <link rel="icon"
        href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>&#9760;</text></svg>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800;900&family=Cinzel+Decorative:wght@400;700;900&family=Cormorant+Garamond:wght@300;400;500;600;700&family=Cormorant+SC:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700&family=Jost:wght@300;400;500;600;700&family=Lora:wght@400;500;600;700&family=Marcellus&family=Marcellus+SC&family=Pirata+One&family=Raleway:wght@300;400;500;600;700&family=UnifrakturCook:wght@700&family=UnifrakturMaguntia&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="relative min-h-screen">

    <div class="pointer-events-none fixed -top-48 right-[-12%] h-[30rem] w-[30rem] rounded-full bg-[radial-gradient(circle,rgba(167,139,250,0.26)_0%,transparent_72%)] blur-3xl"></div>
    <div class="pointer-events-none fixed -bottom-56 left-[-14%] h-[34rem] w-[34rem] rounded-full bg-[radial-gradient(circle,rgba(192,38,211,0.22)_0%,transparent_74%)] blur-3xl"></div>
    <div class="pointer-events-none fixed top-1/2 left-1/2 h-[42rem] w-[42rem] -translate-x-1/2 -translate-y-1/2 rounded-full bg-[radial-gradient(circle,rgba(124,58,237,0.16)_0%,transparent_78%)] blur-[140px]"></div>

    <div class="relative mx-auto max-w-3xl px-6 pt-16 pb-24">

        <header class="mb-16 text-center">
            <div class="gothic-divider mb-8">
                <span>Sanctum Notarum</span>
            </div>
            <div class="flex flex-col items-center gap-7">
                <a href="/" class="text-glow-gothic text-center text-4xl sm:text-6xl md:text-7xl tracking-[0.6em] text-[#c4b5fd] uppercase" style="font-family: var(--font-display);">
                    NOTAS
                </a>
                <div class="gothic-pill">
                    <span>Gothic · SaaS · Nocturne</span>
                </div>
            </div>
            <form action="/logout" method="POST" class="mt-10 flex justify-center">
                @csrf
                <button type="submit" class="btn-gothic-ghost">
                    <span>{{ auth()->user()->name }}</span>
                    <span>·</span>
                    <span>Cerrar sesión</span>
                </button>
            </form>
        </header>

        @if (session('success'))
            <div class="glass-panel mb-9 px-6 py-4 text-center">
                <p class="text-xs uppercase tracking-[0.5em] text-[#f5d98c]">{{ session('success') }}</p>
            </div>
        @endif

        <div class="glass-panel art-deco-frame mb-10 px-6 py-9 sm:px-10">
            <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.6em] text-[#f5d98c]/80">Colección</p>
                    <p class="mt-3 text-lg text-white/80">{{ $totalNotes }} {{ Str::plural('nota', $totalNotes) }}</p>
                    @if ($topTags->isNotEmpty())
                        <p class="mt-4 text-xs uppercase tracking-[0.45em] text-white/40">
                            Más usadas ·
                            @foreach ($topTags as $tag)
                                <span class="text-[#f5d98c]">{{ $tag->name }}</span>{{ !$loop->last ? ' · ' : '' }}
                            @endforeach
                        </p>
                    @endif
                </div>
                <a href="/notes/create" class="btn-deco">
                    <span>+</span>
                    <span>Nueva nota</span>
                </a>
            </div>

            <div class="ornament my-9"></div>

            <form action="/notes/search" method="GET" class="flex flex-col gap-3 sm:flex-row">
                <div class="relative flex-1">
                    <input type="text" name="query" placeholder="BUSCAR POR TÍTULO O CONTENIDO"
                        value="{{ request('query') }}"
                        class="input-deco">
                </div>

                <select name="sort" x-data @change="$el.form.action = '/notes'; $el.form.submit()"
                    class="input-deco sm:w-auto">
                    <option value="recent" {{ request('sort', 'recent') === 'recent' ? 'selected' : '' }}>Más recientes</option>
                    <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Más antiguas</option>
                    <option value="az" {{ request('sort') === 'az' ? 'selected' : '' }}>Alfabético (A-Z)</option>
                </select>

                <button type="submit" class="btn-ghost">
                    <span>Buscar</span>
                </button>
            </form>
        </div>

        @if (request('query') || request('tag'))
            <div class="mb-8 flex flex-wrap items-center justify-center gap-3 text-xs uppercase tracking-[0.4em] text-white/50">
                @if (request('query'))
                    <span>Buscando · "{{ request('query') }}"</span>
                @endif
                @if (request('tag'))
                    <span>Etiqueta · "{{ request('tag') }}"</span>
                @endif
                <a href="/notes" class="text-[#f5d98c] hover:text-[#f7e3a6]">Ver todas</a>
            </div>
        @endif

        @if ($notes->isEmpty())
            <div class="glass-panel text-center py-16 px-6">
                <p class="text-5xl mb-6">&#10022;</p>
                @if (request('query') || request('tag'))
                    <p class="text-sm uppercase tracking-[0.4em] text-white/60">No encontramos ninguna nota con ese filtro.</p>
                @else
                    <p class="text-sm uppercase tracking-[0.4em] text-white/60 mb-6">Aún no hay notas en esta colección.</p>
                    <a href="/notes/create" class="btn-deco">
                        <span>+</span>
                        <span>Crear la primera</span>
                    </a>
                @endif
            </div>
        @else
            <ul class="space-y-5">
                @foreach ($notes as $note)
                    <li class="glass-panel note-card p-6 sm:p-8 {{ $note->pinned ? 'is-pinned' : '' }}">
                        <div class="flex justify-between items-start gap-4">
                            <div class="flex items-center gap-3">
                                @if ($note->emoji)
                                    <span class="text-2xl">{{ $note->emoji }}</span>
                                @endif
                                <h2 class="text-lg sm:text-xl tracking-[0.28em] text-[#f5d98c]">{{ $note->title }}</h2>
                            </div>

                            <form action="/notes/{{ $note->id }}/pin" method="POST">
                                @csrf
                                <button type="submit" class="text-lg transition {{ $note->pinned ? 'opacity-100' : 'opacity-40 hover:opacity-80' }}">
                                    &#128204;
                                </button>
                            </form>
                        </div>

                        @if ($note->image)
                            <img src="{{ Storage::url($note->image) }}" alt="{{ $note->title }}"
                                class="mt-5 w-full max-w-md rounded-2xl border border-[#d9b75b]/60 shadow-[0_30px_60px_-30px_rgba(245,217,140,0.4)]">
                        @endif

                        <p class="mt-5 text-base leading-relaxed text-white/80" style="font-family: var(--font-elegant); font-size: 1.05rem;">{{ Str::limit($note->content, 180) }}</p>

                        @if ($note->tags->isNotEmpty())
                            <div class="mt-6 flex flex-wrap gap-2">
                                @foreach ($note->tags as $tag)
                                    <a href="{{ request('query') ? '/notes/search?query=' . request('query') . '&tag=' . $tag->name : '/notes?tag=' . $tag->name }}"
                                        class="tag-pill">
                                        {{ $tag->name }}
                                    </a>
                                @endforeach
                            </div>
                        @endif

                        <div class="ornament my-7"></div>

                        <div class="flex flex-wrap items-center gap-4 text-xs uppercase tracking-[0.35em] text-white/60">
                            <a href="/notes/{{ $note->id }}/edit" class="hover:text-[#f5d98c]">Editar</a>

                            <div x-data="{ confirming: false }">
                                <button @click="confirming = true" class="hover:text-red-400">Borrar</button>

                                <div x-show="confirming" x-cloak
                                    class="modal-backdrop fixed inset-0 flex items-center justify-center z-50 px-4"
                                    @click.self="confirming = false">
                                    <div class="glass-panel max-w-sm w-full p-7 text-center">
                                        <p class="text-xs uppercase tracking-[0.6em] text-[#f5d98c]">Confirmar</p>
                                        <h3 class="mt-4 text-lg tracking-[0.4em]">¿Borrar esta nota?</h3>
                                        <p class="mt-3 text-sm text-white/60">Esta acción no se puede deshacer.</p>

                                        <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-center">
                                            <button @click="confirming = false" class="btn-ghost">
                                                <span>Cancelar</span>
                                            </button>
                                            <form action="/notes/{{ $note->id }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-deco">
                                                    <span>Sí, borrar</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <form action="/notes/{{ $note->id }}/share" method="POST">
                                @csrf
                                <button type="submit" class="hover:text-[#f5d98c]">Compartir</button>
                            </form>

                            <a href="/notes/{{ $note->id }}/pdf" class="hover:text-[#f5d98c]">PDF</a>
                            <a href="/notes/{{ $note->id }}/history" class="hover:text-[#f5d98c]">Historial</a>
                        </div>

                        @if ($note->share_token)
                            <div x-data="{ copied: false }" class="mt-4 flex flex-wrap items-center gap-3 text-xs uppercase tracking-[0.3em] text-white/40">
                                <p class="break-all">{{ url('/shared/' . $note->share_token) }}</p>
                                <button type="button"
                                    @click="navigator.clipboard.writeText('{{ url('/shared/' . $note->share_token) }}'); copied = true; setTimeout(() => copied = false, 2000)"
                                    class="text-[#f5d98c] hover:text-[#f7e3a6]"
                                    x-text="copied ? 'Copiado' : 'Copiar'"></button>
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif

        @if ($notes instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="mt-10 flex justify-center">
                {{ $notes->links() }}
            </div>
        @endif

    </div>
</body>

</html>
