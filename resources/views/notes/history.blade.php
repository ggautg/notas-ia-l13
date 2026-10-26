@extends('layouts.app')

@section('title', 'Historial · ' . $note->title)

@section('content')
    <div class="relative mx-auto max-w-2xl px-6 pt-16 pb-24">
        <header class="mb-12 text-center">
            <div class="divider mb-7">
                <span>Sanctum Notarum</span>
            </div>
            <a href="/notes" class="brand text-glow text-4xl sm:text-5xl">
                NOTAS
            </a>
            <p class="eyebrow mt-6">Archivo de versiones</p>
            <div class="mt-8 flex justify-center">
                <a href="/notes" class="btn-ghost">
                    <span>← Volver al archivo</span>
                </a>
            </div>
        </header>

        <div class="mb-10 text-center">
            <p class="eyebrow eyebrow-accent">Historial</p>
            <h1 class="title mt-4 text-lg">{{ $note->title }}</h1>
            <div class="ornament my-7"></div>
        </div>

        @if ($note->versions->isEmpty())
            <div class="theme-panel px-6 py-12 text-center">
                <p class="text-sm uppercase tracking-[0.35em] t-muted">Sin versiones anteriores registradas</p>
            </div>
        @else
            <ul class="space-y-5">
                @foreach ($note->versions as $version)
                    <li class="theme-panel note-card p-6 sm:p-7">
                        <p class="text-xs uppercase tracking-[0.35em] t-faint">{{ $version->created_at->format('d/m/Y H:i') }}</p>
                        <h2 class="title mt-3 text-base t-accent">{{ $version->title }}</h2>
                        <p class="note-content mt-4 whitespace-pre-line">{{ $version->content }}</p>

                        <div class="ornament my-6"></div>

                        <div x-data="{ confirming: false }">
                            <button @click="confirming = true"
                                class="text-xs uppercase tracking-[0.35em] t-accent hover:opacity-80">
                                ↩ Restaurar esta versión
                            </button>

                            <div x-show="confirming" x-cloak
                                class="modal fixed inset-0 z-50 flex items-center justify-center px-4"
                                @click.self="confirming = false">
                                <div class="theme-panel w-full max-w-sm p-7 text-center">
                                    <p class="eyebrow eyebrow-accent">Confirmar restauración</p>
                                    <h3 class="title mt-4 text-base">¿Restaurar esta versión?</h3>
                                    <p class="mt-3 text-sm t-muted">El contenido actual será reemplazado, pero quedará
                                        guardado en el historial.</p>

                                    <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-center">
                                        <button @click="confirming = false" class="btn-ghost">
                                            <span>Cancelar</span>
                                        </button>
                                        <form action="/notes/{{ $note->id }}/restore/{{ $version->id }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit" class="btn-primary w-full">
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
@endsection
