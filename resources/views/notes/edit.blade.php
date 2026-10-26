@extends('layouts.app')

@section('title', 'Editar nota · Sanctum')

@section('content')
    <div class="relative mx-auto max-w-2xl px-6 pt-16 pb-24">
        <header class="mb-12 text-center">
            <div class="divider mb-7">
                <span>Sanctum Notarum</span>
            </div>
            <a href="/notes" class="brand text-glow text-4xl sm:text-5xl">
                NOTAS
            </a>
            <p class="eyebrow mt-6">Reescribir memoria</p>
            <div class="mt-8 flex justify-center">
                <a href="/notes" class="btn-ghost">
                    <span>← Volver al archivo</span>
                </a>
            </div>
        </header>

        <div class="theme-panel px-6 py-10 sm:px-10">
            <div class="text-center">
                <p class="eyebrow eyebrow-accent">Editar nota</p>
                <h1 class="title mt-4 text-lg">Restaurar códice</h1>
                <div class="ornament my-8"></div>
            </div>

            @if ($errors->any())
                <div class="mb-8 rounded-2xl border px-4 py-3 text-center text-xs uppercase tracking-[0.3em] t-danger"
                    style="border-color: var(--danger); background: var(--danger-wash);">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="/notes/{{ $note->id }}" method="POST" enctype="multipart/form-data"
                x-data="{ loading: false, emoji: '{{ $note->emoji }}' }" @submit="loading = true" class="space-y-7">
                @csrf
                @method('PUT')

                <div>
                    <label class="label">Título</label>
                    <div class="flex gap-3" x-data="{ open: false }">
                        <input type="hidden" name="emoji" :value="emoji">
                        <button type="button" @click="open = !open"
                            class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full border text-xl transition b-accent hover:opacity-80"
                            style="background: var(--accent-wash);"
                            x-text="emoji || '✠'"></button>
                        <div class="relative flex-1">
                            <input type="text" name="title" id="title" value="{{ $note->title }}" required
                                class="input-theme">
                            <div x-show="open" @click.outside="open = false" x-cloak
                                class="absolute left-0 top-14 z-20">
                                <emoji-picker class="dark"
                                    @emoji-click="emoji = $event.detail.unicode; open = false"></emoji-picker>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="content" class="label">Contenido</label>
                    <textarea name="content" id="content" rows="10" required class="textarea-theme">{{ $note->content }}</textarea>
                </div>

                <div>
                    <label for="tags" class="label">Etiquetas (separadas por coma)</label>
                    <input type="text" name="tags" id="tags" value="{{ $note->tags->pluck('name')->join(', ') }}"
                        class="input-theme">
                </div>

                <div x-data="{ hasImage: {{ $note->image ? 'true' : 'false' }}, preview: null }">
                    <input type="hidden" name="remove_image" :value="hasImage ? '0' : '1'">

                    <div x-show="hasImage && !preview">
                        <p class="label">Imagen actual</p>
                        <div class="relative inline-block">
                            <img src="{{ $note->image ? Storage::url($note->image) : '' }}" alt="{{ $note->title }}"
                                class="max-w-xs rounded-2xl border border-glow">
                            <button type="button" @click="hasImage = false"
                                class="absolute -right-3 -top-3 flex h-8 w-8 items-center justify-center rounded-full border text-xs t-danger"
                                style="background: var(--danger-wash); border-color: var(--danger);">✕</button>
                        </div>
                    </div>

                    <div x-show="preview">
                        <p class="label">Nueva imagen</p>
                        <div class="relative inline-block">
                            <img :src="preview" class="max-w-xs rounded-2xl border border-glow">
                            <button type="button" @click="preview = null; $refs.imageInput.value = ''"
                                class="absolute -right-3 -top-3 flex h-8 w-8 items-center justify-center rounded-full border text-xs t-danger"
                                style="background: var(--danger-wash); border-color: var(--danger);">✕</button>
                        </div>
                    </div>

                    <div x-show="!hasImage && !preview">
                        <label for="image" class="label">Agregar imagen (opcional)</label>
                    </div>

                    <input type="file" name="image" id="image" x-ref="imageInput" accept="image/*"
                        x-show="!hasImage && !preview"
                        @change="preview = $event.target.files.length ? URL.createObjectURL($event.target.files[0]) : null"
                        class="input-file">
                </div>

                <button type="submit" :disabled="loading" class="btn-primary w-full">
                    <span x-text="loading ? 'Actualizando...' : 'Actualizar memoria'"></span>
                </button>
            </form>
        </div>
    </div>
@endsection
