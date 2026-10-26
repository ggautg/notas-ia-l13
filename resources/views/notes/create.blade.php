@extends('layouts.app')

@section('title', 'Nueva nota · Sanctum')

@section('content')
    <div class="relative mx-auto max-w-2xl px-6 pt-16 pb-24">
        <header class="mb-12 text-center">
            <div class="divider mb-7">
                <span>Sanctum Notarum</span>
            </div>
            <a href="/notes" class="brand text-glow text-4xl sm:text-5xl">
                NOTAS
            </a>
            <p class="eyebrow mt-6">Inscribir nueva memoria</p>
            <div class="mt-8 flex justify-center">
                <a href="/notes" class="btn-ghost">
                    <span>← Volver al archivo</span>
                </a>
            </div>
        </header>

        <div class="theme-panel px-6 py-10 sm:px-10">
            <div class="text-center">
                <p class="eyebrow eyebrow-accent">Nueva nota</p>
                <h1 class="title mt-4 text-lg">Códice en blanco</h1>
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

            <form action="/notes" method="POST" enctype="multipart/form-data"
                x-data="{ loading: false, emoji: '' }" @submit="loading = true" class="space-y-7">
                @csrf

                <div>
                    <label class="label">Título</label>
                    <div class="flex gap-3" x-data="{ open: false }">
                        <input type="hidden" name="emoji" :value="emoji">
                        <button type="button" @click="open = !open"
                            class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full border text-xl transition b-accent hover:opacity-80"
                            style="background: var(--accent-wash);"
                            x-text="emoji || '✠'"></button>
                        <div class="relative flex-1">
                            <input type="text" name="title" required class="input-theme">
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
                    <textarea name="content" id="content" rows="10" required class="textarea-theme"></textarea>
                </div>

                <div>
                    <label for="tags" class="label">Etiquetas (separadas por coma)</label>
                    <input type="text" name="tags" id="tags" placeholder="TRABAJO, IDEAS, DIARIO" class="input-theme">
                </div>

                <div x-data="{ preview: null }">
                    <label for="image" class="label">Imagen (opcional)</label>
                    <input type="file" name="image" id="image" x-ref="imageInput" accept="image/*"
                        @change="preview = $event.target.files.length ? URL.createObjectURL($event.target.files[0]) : null"
                        class="input-file">
                    <template x-if="preview">
                        <div class="relative mt-5 inline-block">
                            <img :src="preview" class="max-w-xs rounded-2xl border border-glow">
                            <button type="button" @click="preview = null; $refs.imageInput.value = ''"
                                class="absolute -right-3 -top-3 flex h-8 w-8 items-center justify-center rounded-full border text-xs t-danger"
                                style="background: var(--danger-wash); border-color: var(--danger);">✕</button>
                        </div>
                    </template>
                </div>

                <button type="submit" :disabled="loading" class="btn-primary w-full">
                    <span x-text="loading ? 'Guardando...' : 'Guardar memoria'"></span>
                </button>
            </form>
        </div>
    </div>
@endsection
