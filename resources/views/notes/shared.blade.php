@extends('layouts.app')

@section('title', $note->title . ' · Nota compartida')

@section('content')
    <div class="relative mx-auto max-w-2xl px-6 pt-16 pb-24">
        <header class="mb-10 text-center">
            <div class="divider mb-7">
                <span>Sanctum Notarum</span>
            </div>
            <a href="/" class="brand text-glow text-4xl sm:text-5xl">
                NOTAS
            </a>
            <p class="eyebrow mt-6">Nota compartida</p>
        </header>

        <article class="theme-panel note-card px-6 py-9 sm:px-10">
            <div class="flex items-center gap-3">
                @if ($note->emoji)
                    <span class="text-3xl">{{ $note->emoji }}</span>
                @endif
                <h1 class="title text-lg t-accent sm:text-xl">{{ $note->title }}</h1>
            </div>

            @if ($note->image)
                <img src="{{ Storage::url($note->image) }}" alt="{{ $note->title }}"
                    class="mt-6 w-full max-w-md rounded-2xl border border-glow">
            @endif

            <p class="note-content mt-6 whitespace-pre-line">{{ $note->content }}</p>

            @if ($note->tags->isNotEmpty())
                <div class="mt-8 flex flex-wrap gap-2">
                    @foreach ($note->tags as $tag)
                        <span class="tag">{{ $tag->name }}</span>
                    @endforeach
                </div>
            @endif

            <div class="ornament my-8"></div>
            <p class="text-center text-xs uppercase tracking-[0.45em] t-faint">Ex umbris · Ad memoriam</p>
        </article>
    </div>
@endsection
