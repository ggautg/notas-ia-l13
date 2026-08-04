<!DOCTYPE html>
<html lang="es">
<head>
    <title>Editar Nota</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>💿</text></svg>">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-cyan-100 via-fuchsia-50 to-lime-100 text-gray-900 font-sans min-h-screen relative">

    <div class="absolute top-10 right-10 w-48 h-48 bg-gradient-to-br from-fuchsia-400 to-purple-500 rounded-full blur-2xl opacity-40 pointer-events-none"></div>

    <div class="relative max-w-2xl mx-auto px-6 pt-14 pb-20">

        <a href="/" class="text-2xl font-black tracking-tight mb-8 inline-block" style="background: linear-gradient(90deg, #ff00cc, #00e5ff, #ccff00); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent;">
            NOTAS
        </a>

        <h1 class="text-2xl font-black mb-6">Editar Nota</h1>

        @if ($errors->any())
            <div class="bg-red-100 border-4 border-black text-red-700 px-4 py-3 rounded-2xl mb-4 text-sm font-medium shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="/notes/{{ $note->id }}" method="POST" enctype="multipart/form-data" x-data="{ loading: false, emoji: '{{ $note->emoji }}' }" @submit="loading = true" class="bg-white border-4 border-black rounded-2xl p-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-xs font-bold text-gray-500 mb-1.5 uppercase tracking-wide">Título</label>
                <div class="flex gap-2" x-data="{ open: false }">
                    <input type="hidden" name="emoji" :value="emoji">

                    <button
                        type="button"
                        @click="open = !open"
                        class="w-11 h-11 shrink-0 rounded-xl border-2 border-black bg-cyan-50 text-lg hover:bg-cyan-100 transition flex items-center justify-center"
                        x-text="emoji || '➕'"
                    ></button>

                    <div class="relative flex-1">
                        <input type="text" name="title" id="title" value="{{ $note->title }}" class="w-full bg-cyan-50 border-2 border-black rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:bg-white transition h-11">

                        <div x-show="open" @click.outside="open = false" x-cloak class="absolute z-10 top-12 left-0">
                            <emoji-picker class="light" @emoji-click="emoji = $event.detail.unicode; open = false"></emoji-picker>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <label for="content" class="block text-xs font-bold text-gray-500 mb-1.5 uppercase tracking-wide">Contenido</label>
                <textarea name="content" id="content" rows="5" class="w-full bg-cyan-50 border-2 border-black rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:bg-white transition">{{ $note->content }}</textarea>
            </div>

            <div class="mb-4">
                <label for="tags" class="block text-xs font-bold text-gray-500 mb-1.5 uppercase tracking-wide">Etiquetas</label>
                <input type="text" name="tags" id="tags" value="{{ $note->tags->pluck('name')->join(', ') }}" class="w-full bg-cyan-50 border-2 border-black rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:bg-white transition">
                <p class="text-xs text-gray-500 mt-1.5">Separá las etiquetas con comas</p>
            </div>

            <div class="mb-6" x-data="{ hasImage: {{ $note->image ? 'true' : 'false' }}, preview: null }">
                <input type="hidden" name="remove_image" :value="hasImage ? '0' : '1'">

                <div x-show="hasImage && !preview">
                    <p class="text-xs font-bold text-gray-500 mb-1.5 uppercase tracking-wide">Imagen actual</p>
                    <div class="relative inline-block mb-4">
                        <img src="{{ $note->image ? Storage::url($note->image) : '' }}" alt="{{ $note->title }}" class="w-full max-w-xs rounded-xl border-2 border-black">
                        <button type="button" @click="hasImage = false" class="absolute -top-2 -right-2 bg-red-500 text-white border-2 border-black w-6 h-6 rounded-full text-xs hover:bg-red-400 transition">✕</button>
                    </div>
                </div>

                <div x-show="preview">
                    <div class="relative inline-block mb-4">
                        <img :src="preview" class="w-full max-w-xs rounded-xl border-2 border-black">
                        <button type="button" @click="preview = null; $refs.imageInput.value = ''" class="absolute -top-2 -right-2 bg-red-500 text-white border-2 border-black w-6 h-6 rounded-full text-xs hover:bg-red-400 transition">✕</button>
                    </div>
                </div>

                <div x-show="!hasImage && !preview">
                    <label for="image" class="block text-xs font-bold text-gray-500 mb-1.5 uppercase tracking-wide">Agregar imagen (opcional)</label>
                </div>

                <input
                    type="file"
                    name="image"
                    id="image"
                    x-ref="imageInput"
                    accept="image/*"
                    x-show="!hasImage && !preview"
                    @change="preview = $event.target.files.length ? URL.createObjectURL($event.target.files[0]) : null"
                    class="w-full text-sm text-gray-600"
                >
            </div>

            <button type="submit" :disabled="loading" x-text="loading ? 'Actualizando...' : 'Actualizar'" class="bg-fuchsia-500 text-white border-4 border-black px-6 py-3 rounded-full text-sm font-bold hover:bg-fuchsia-400 transition shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] disabled:opacity-60">
            </button>
        </form>

        <a href="/notes" class="inline-block mt-6 text-sm text-gray-600 hover:text-fuchsia-600 font-bold transition">← Volver a la lista</a>

    </div>
</body>