@extends('layouts.app')

@section('title', 'Mis notas · Sanctum')

@section('content')
    <div class="relative mx-auto max-w-3xl px-6 pt-16 pb-28">
        <header class="mb-14 text-center">
            <div class="divider mb-7">
                <span>Sanctum Notarum</span>
            </div>
            <div class="flex flex-col items-center gap-6">
                <a href="/" class="brand text-glow text-4xl sm:text-6xl md:text-7xl">
                    NOTAS
                </a>
                <div class="pill">
                    <span>Archivo personal</span>
                </div>
            </div>
            <form action="/logout" method="POST" class="mt-9 flex justify-center">
                @csrf
                <button type="submit" class="btn-ghost">
                    <span>{{ auth()->user()->name }}</span>
                    <span>·</span>
                    <span>Cerrar sesión</span>
                </button>
            </form>
        </header>

        @if (session('success'))
            <div class="theme-panel mb-8 px-6 py-4 text-center">
                <p class="text-xs uppercase tracking-[0.45em] t-accent">{{ session('success') }}</p>
            </div>
        @endif

        <div class="theme-panel mb-10 px-6 py-8 sm:px-9">
            <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="eyebrow eyebrow-accent">Colección</p>
                    <p class="mt-3 text-lg t-soft">{{ $totalNotes }} {{ Str::plural('nota', $totalNotes) }}</p>
                    @if ($topTags->isNotEmpty())
                        <p class="mt-4 text-xs uppercase tracking-[0.35em] t-faint">
                            Más usadas ·
                            @foreach ($topTags as $tag)
                                <span class="t-accent">{{ $tag->name }}</span>{{ !$loop->last ? ' · ' : '' }}
                            @endforeach
                        </p>
                    @endif
                </div>
                <a href="/notes/create" class="btn-primary">
                    <span>+</span>
                    <span>Nueva nota</span>
                </a>
            </div>

            <div class="ornament my-8"></div>

            <form action="/notes/search" method="GET" class="flex flex-col gap-3 sm:flex-row">
                <div class="relative flex-1">
                    <input type="text" name="query" placeholder="BUSCAR POR TÍTULO O CONTENIDO"
                        value="{{ request('query') }}" class="input-theme">
                </div>

                <select name="sort" x-data @change="$el.form.action = '/notes'; $el.form.submit()"
                    class="input-theme sm:w-auto">
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
            <div class="mb-8 flex flex-wrap items-center justify-center gap-3 text-xs uppercase tracking-[0.35em] t-muted">
                @if (request('query'))
                    <span>Buscando · "{{ request('query') }}"</span>
                @endif
                @if (request('tag'))
                    <span>Etiqueta · "{{ request('tag') }}"</span>
                @endif
                <a href="/notes" class="t-accent font-semibold">Ver todas</a>
            </div>
        @endif

        @if ($notes->isEmpty())
            <div class="theme-panel px-6 py-16 text-center">
                <p class="mb-6 text-5xl t-accent">✠</p>
                @if (request('query') || request('tag'))
                    <p class="text-sm uppercase tracking-[0.35em] t-muted">No encontramos ninguna nota con ese filtro.</p>
                @else
                    <p class="mb-6 text-sm uppercase tracking-[0.35em] t-muted">Aún no hay notas en esta colección.</p>
                    <a href="/notes/create" class="btn-primary">
                        <span>+</span>
                        <span>Crear la primera</span>
                    </a>
                @endif
            </div>
        @else
            <ul class="space-y-5">
                @foreach ($notes as $note)
                    <li class="theme-panel note-card p-6 sm:p-8 {{ $note->pinned ? 'is-pinned' : '' }}">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex items-center gap-3">
                                @if ($note->emoji)
                                    <span class="text-2xl">{{ $note->emoji }}</span>
                                @endif
                                <h2 class="title text-lg t-accent sm:text-xl">{{ $note->title }}</h2>
                            </div>

                            <form action="/notes/{{ $note->id }}/pin" method="POST">
                                @csrf
                                <button type="submit"
                                    class="text-lg transition {{ $note->pinned ? 'opacity-100' : 'opacity-40 hover:opacity-80' }}"
                                    title="{{ $note->pinned ? 'Desfijar' : 'Fijar' }}">
                                    📌
                                </button>
                            </form>
                        </div>

                        @if ($note->image)
                            <img src="{{ Storage::url($note->image) }}" alt="{{ $note->title }}"
                                class="mt-5 w-full max-w-md rounded-2xl border border-glow">
                        @endif

                        <p class="note-content mt-5">{{ Str::limit($note->content, 180) }}</p>

                        @if ($note->tags->isNotEmpty())
                            <div class="mt-6 flex flex-wrap gap-2">
                                @foreach ($note->tags as $tag)
                                    <a href="{{ request('query') ? '/notes/search?query=' . request('query') . '&tag=' . $tag->name : '/notes?tag=' . $tag->name }}"
                                        class="tag">
                                        {{ $tag->name }}
                                    </a>
                                @endforeach
                            </div>
                        @endif

                        <div class="ornament my-6"></div>

                        <div class="flex flex-wrap items-center gap-4 text-[0.66rem] uppercase tracking-[0.3em] t-muted">
                            <a href="/notes/{{ $note->id }}/edit" class="hover:opacity-100">Editar</a>

                            <div x-data="{ confirming: false }">
                                <button @click="confirming = true" class="t-danger hover:opacity-80">Borrar</button>

                                <div x-show="confirming" x-cloak
                                    class="modal fixed inset-0 z-50 flex items-center justify-center px-4"
                                    @click.self="confirming = false">
                                    <div class="theme-panel w-full max-w-sm p-7 text-center">
                                        <p class="eyebrow eyebrow-accent">Confirmar</p>
                                        <h3 class="title mt-4 text-base">¿Borrar esta nota?</h3>
                                        <p class="mt-3 text-sm t-muted">Esta acción no se puede deshacer.</p>

                                        <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-center">
                                            <button @click="confirming = false" class="btn-ghost">
                                                <span>Cancelar</span>
                                            </button>
                                            <form action="/notes/{{ $note->id }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-danger w-full">
                                                    <span>Sí, borrar</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <form action="/notes/{{ $note->id }}/share" method="POST">
                                @csrf
                                <button type="submit">Compartir</button>
                            </form>

                            <a href="/notes/{{ $note->id }}/pdf">PDF</a>
                            <a href="/notes/{{ $note->id }}/history">Historial</a>
                        </div>

                        @if ($note->share_token)
                            <div x-data="{ copied: false }" class="mt-4 flex flex-wrap items-center gap-3 text-xs t-faint">
                                <p class="break-all">{{ url('/shared/' . $note->share_token) }}</p>
                                <button type="button"
                                    @click="navigator.clipboard.writeText('{{ url('/shared/' . $note->share_token) }}'); copied = true; setTimeout(() => copied = false, 2000)"
                                    class="t-accent font-semibold" x-text="copied ? 'Copiado' : 'Copiar'"></button>
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
@endsection
