<!DOCTYPE html>
<html>

<head>
    <title>Nueva Nota</title>
    <link rel="icon"
        href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>📝</text></svg>">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-950 text-white font-sans min-h-screen relative">

    <div
        class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[600px] bg-indigo-600/20 blur-[120px] rounded-full pointer-events-none">
    </div>

    <div class="relative max-w-2xl mx-auto px-6 pt-14 pb-20">

        <a href="/"
            class="text-xl font-extrabold tracking-tight bg-gradient-to-b from-white to-gray-400 bg-clip-text text-transparent mb-8 inline-block">
            NOTAS
        </a>

        <h1 class="text-2xl font-bold mb-6">Nueva Nota</h1>

        @if ($errors->any())
            <div class="bg-red-500/10 border border-red-500/30 text-red-300 px-4 py-3 rounded-lg mb-4 text-sm">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="/notes" method="POST" enctype="multipart/form-data" x-data="{ loading: false, emoji: '' }"
            @submit="loading = true" class="bg-white/5 border border-white/10 rounded-xl p-6">
            @csrf

            <div class="mb-4">
                <label class="block text-xs font-semibold text-gray-400 mb-1.5 uppercase tracking-wide">Título</label>
                <div class="flex gap-2" x-data="{ open: false }">
                    <input type="hidden" name="emoji" :value="emoji">

                    <button type="button" @click="open = !open"
                        class="w-11 h-11 shrink-0 rounded-lg border border-white/10 bg-white/5 text-lg hover:bg-white/10 transition flex items-center justify-center"
                        x-text="emoji || '➕'"></button>

                    <div class="relative flex-1">
                        <input type="text" name="title" id="title"
                            class="w-full bg-white/5 border border-white/10 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-indigo-500 transition h-11">

                        <div x-show="open" @click.outside="open = false" x-cloak class="absolute z-10 top-12 left-0">
                            <emoji-picker class="light"
                                @emoji-click="emoji = $event.detail.unicode; open = false"></emoji-picker>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <label for="content"
                    class="block text-xs font-semibold text-gray-400 mb-1.5 uppercase tracking-wide">Contenido</label>
                <textarea name="content" id="content" rows="5"
                    class="w-full bg-white/5 border border-white/10 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-indigo-500 transition"></textarea>
            </div>

            <div class="mb-4">
                <label for="tags"
                    class="block text-xs font-semibold text-gray-400 mb-1.5 uppercase tracking-wide">Etiquetas</label>
                <input type="text" name="tags" id="tags" placeholder="trabajo, personal, ideas"
                    class="w-full bg-white/5 border border-white/10 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-indigo-500 transition">
                <p class="text-xs text-gray-600 mt-1.5">Separá las etiquetas con comas</p>
            </div>

            <div class="mb-6">
                <label for="image"
                    class="block text-xs font-semibold text-gray-400 mb-1.5 uppercase tracking-wide">Imagen
                    (opcional)</label>
                <input type="file" name="image" id="image" accept="image/*" class="w-full text-sm text-gray-400">
            </div>

            <button type="submit" :disabled="loading" x-text="loading ? 'Guardando...' : 'Guardar'"
                class="bg-indigo-600 text-white px-6 py-3 rounded-lg text-sm font-semibold hover:bg-indigo-500 transition shadow-[0_0_30px_-5px_rgba(99,102,241,0.6)] disabled:opacity-60">
            </button>
        </form>

        <a href="/notes" class="inline-block mt-6 text-sm text-gray-500 hover:text-gray-300 transition">← Volver a la
            lista</a>

    </div>
</body>

</html>