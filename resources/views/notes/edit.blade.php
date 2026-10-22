<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar nota · Sanctum</title>
    <link rel="icon"
        href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>&#9760;</text></svg>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800;900&family=Cinzel+Decorative:wght@400;700;900&family=Cormorant+Garamond:wght@300;400;500;600;700&family=Cormorant+SC:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700&family=Jost:wght@300;400;500;600;700&family=Lora:wght@400;500;600;700&family=Marcellus&family=Marcellus+SC&family=Pirata+One&family=Raleway:wght@300;400;500;600;700&family=UnifrakturCook:wght@700&family=UnifrakturMaguntia&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="relative min-h-screen">

    <div class="pointer-events-none fixed -top-48 right-[-12%] h-[28rem] w-[28rem] rounded-full bg-[radial-gradient(circle,rgba(167,139,250,0.26)_0%,transparent_72%)] blur-3xl"></div>
    <div class="pointer-events-none fixed -bottom-56 left-[-14%] h-[32rem] w-[32rem] rounded-full bg-[radial-gradient(circle,rgba(192,38,211,0.22)_0%,transparent_74%)] blur-3xl"></div>

    <div class="relative mx-auto max-w-2xl px-6 pt-16 pb-24">
        <header class="mb-12 text-center">
            <div class="gothic-divider mb-7">
                <span>Sanctum Notarum</span>
            </div>
            <a href="/notes" class="text-glow-gothic text-4xl sm:text-5xl tracking-[0.6em] text-[#c4b5fd] uppercase" style="font-family: var(--font-display);">
                NOTAS
            </a>
            <p class="mt-6 text-xs uppercase tracking-[0.6em] text-white/50">Reescribir memoria</p>
            <div class="mt-8 flex justify-center">
                <a href="/notes" class="btn-gothic-ghost">
                    <span>← Volver al archivo</span>
                </a>
            </div>
        </header>

        <div class="gothic-panel gothic-frame px-6 py-10 sm:px-10">
            <div class="text-center">
                <p class="text-xs uppercase tracking-[0.6em] text-[#c4b5fd]/80">Editar nota</p>
                <h1 class="mt-4 text-lg tracking-[0.4em]">Restaurar códice</h1>
                <div class="ornament-gothic my-8"></div>
            </div>

            @if ($errors->any())
                <div class="mb-8 rounded-2xl border border-[#ef4444]/70 px-4 py-3 text-center text-xs uppercase tracking-[0.35em] text-red-300">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="/notes/{{ $note->id }}" method="POST" enctype="multipart/form-data" x-data="{ loading: false, emoji: '{{ $note->emoji }}' }" @submit="loading = true" class="space-y-7">
                @csrf
                @method('PUT')

                <div>
                    <label class="mb-2 block text-xs uppercase tracking-[0.4em] text-white/60">Título</label>
                    <div class="flex gap-3" x-data="{ open: false }">
                        <input type="hidden" name="emoji" :value="emoji">
                        <button type="button" @click="open = !open"
                            class="h-12 w-12 shrink-0 rounded-full border border-[#a78bfa]/70 bg-transparent text-xl flex items-center justify-center hover:bg-[#a78bfa]/10 transition"
                            x-text="emoji || '✦'"></button>
                        <div class="relative flex-1">
                            <input type="text" name="title" id="title" value="{{ $note->title }}" required class="input-gothic">
                            <div x-show="open" @click.outside="open = false" x-cloak class="absolute z-20 top-14 left-0">
                                <emoji-picker class="dark" @emoji-click="emoji = $event.detail.unicode; open = false"></emoji-picker>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="content" class="mb-2 block text-xs uppercase tracking-[0.4em] text-white/60">Contenido</label>
                    <textarea name="content" id="content" rows="10" required class="textarea-gothic">{{ $note->content }}</textarea>
                </div>

                <div>
                    <label for="tags" class="mb-2 block text-xs uppercase tracking-[0.4em] text-white/60">Etiquetas (separadas por coma)</label>
                    <input type="text" name="tags" id="tags" value="{{ $note->tags->pluck('name')->join(', ') }}" class="input-gothic">
                </div>

                <div x-data="{ hasImage: {{ $note->image ? 'true' : 'false' }}, preview: null }">
                    <input type="hidden" name="remove_image" :value="hasImage ? '0' : '1'">

                    <div x-show="hasImage && !preview">
                        <p class="mb-3 text-xs uppercase tracking-[0.4em] text-white/60">Imagen actual</p>
                        <div class="relative inline-block">
                            <img src="{{ $note->image ? Storage::url($note->image) : '' }}" alt="{{ $note->title }}" class="max-w-xs rounded-2xl border border-[#a78bfa]/60 shadow-[0_40px_80px_-40px_rgba(167,139,250,0.5)]">
                            <button type="button" @click="hasImage = false"
                                class="absolute -top-3 -right-3 flex h-8 w-8 items-center justify-center rounded-full border border-[#ef4444]/80 bg-[#ef4444]/20 text-xs text-red-200">✕</button>
                        </div>
                    </div>

                    <div x-show="preview">
                        <p class="mb-3 text-xs uppercase tracking-[0.4em] text-white/60">Nueva imagen</p>
                        <div class="relative inline-block">
                            <img :src="preview" class="max-w-xs rounded-2xl border border-[#a78bfa]/60 shadow-[0_40px_80px_-40px_rgba(167,139,250,0.5)]">
                            <button type="button" @click="preview = null; $refs.imageInput.value = ''"
                                class="absolute -top-3 -right-3 flex h-8 w-8 items-center justify-center rounded-full border border-[#ef4444]/80 bg-[#ef4444]/20 text-xs text-red-200">✕</button>
                        </div>
                    </div>

                    <div x-show="!hasImage && !preview">
                        <label for="image" class="mb-2 block text-xs uppercase tracking-[0.4em] text-white/60">Agregar imagen (opcional)</label>
                    </div>

                    <input
                        type="file"
                        name="image"
                        id="image"
                        x-ref="imageInput"
                        accept="image/*"
                        x-show="!hasImage && !preview"
                        @change="preview = $event.target.files.length ? URL.createObjectURL($event.target.files[0]) : null"
                        class="w-full text-sm text-white/70 file:mr-4 file:rounded-full file:border file:border-[#a78bfa]/70 file:bg-transparent file:px-6 file:py-2 file:text-xs file:uppercase file:tracking-[0.35em] file:text-[#c4b5fd] hover:file:bg-[#a78bfa]/10"
                    >
                </div>

                <button type="submit" :disabled="loading" class="btn-gothic w-full justify-center">
                    <span x-text="loading ? 'Actualizando...' : 'Actualizar memoria'"></span>
                </button>
            </form>
        </div>
    </div>
</body>

</html>
