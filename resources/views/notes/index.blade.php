<!DOCTYPE html>
<html x-data="{ dark: localStorage.getItem('dark') === 'true' }" :class="{ 'dark': dark }">

<head>
    <title>Mis Notas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 font-sans">
    <div class="max-w-2xl mx-auto mt-10 px-4">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Mis Notas</h1>

            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="text-sm text-gray-500 hover:underline">
                    Cerrar sesión ({{ auth()->user()->name }})
                </button>
            </form>
            <button @click="dark = !dark; localStorage.setItem('dark', dark)"
                class="text-sm text-gray-500 dark:text-gray-300 mr-3">
                <span x-show="!dark">🌙 Oscuro</span>
                <span x-show="dark">☀️ Claro</span>
            </button>
        </div>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        <a href="/notes/create"
            class="inline-block bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 mb-4">
            + Nueva nota
        </a>

        <livewire:note-search />

        @if (request('query') || request('tag'))
            <div class="flex items-center gap-2 mb-4 text-sm">
                @if (request('query'))
                    <span class="text-gray-500 dark:text-gray-400">Buscando: "{{ request('query') }}"</span>
                @endif

                @if (request('tag'))
                    <span class="text-gray-500 dark:text-gray-400">Etiqueta: "{{ request('tag') }}"</span>
                @endif

                <a href="/notes" class="text-indigo-600 dark:text-indigo-400 hover:underline">✕ Ver todas</a>
            </div>
        @endif

        <ul class="space-y-4">
            @foreach ($notes as $note)
                <li class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 shadow-sm">
                    <strong class="text-lg text-gray-900 dark:text-white">{{ $note->title }}</strong>

                    @if ($note->image)
                        <img src="{{ Storage::url($note->image) }}" alt="{{ $note->title }}"
                            class="w-full max-w-xs rounded-lg mt-2">
                    @endif

                    @if ($note->summary)
                        <p class="text-indigo-500 text-sm italic mt-1">{{ $note->summary }}</p>
                    @endif

                    <p class="text-gray-600 dark:text-gray-300 mt-1">{{ $note->content }}</p>

                    @if ($note->tags->isNotEmpty())
                        <div class="flex gap-2 mt-2">
                            @foreach ($note->tags as $tag)
                                <a href="/notes?tag={{ $tag->name }}"
                                    class="bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-200 text-xs px-2 py-1 rounded-full hover:bg-indigo-200 dark:hover:bg-indigo-800">
                                    {{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                    @endif

                    @if (isset($note->similarity))
                        <small class="text-gray-400">Coincidencia: {{ round($note->similarity * 100) }}%</small><br>
                    @endif

                    <div class="flex gap-3 mt-3">
                        <a href="/notes/{{ $note->id }}/edit"
                            class="text-indigo-600 text-sm font-medium hover:underline">Editar</a>

                        <form action="/notes/{{ $note->id }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 text-sm font-medium hover:underline">Borrar</button>
                        </form>


                        <form action="/notes/{{ $note->id }}/share" method="POST">
                            @csrf
                            <button type="submit"
                                class="text-gray-500 dark:text-gray-400 text-sm font-medium hover:underline">
                                🔗 Compartir
                            </button>
                        </form>

                        @if ($note->share_token)
                            <span class="text-xs text-gray-400">
                                Link: {{ url('/shared/' . $note->share_token) }}
                            </span>
                        @endif

                        <a href="/notes/{{ $note->id }}/pdf"
                            class="text-gray-500 dark:text-gray-400 text-sm font-medium hover:underline">
                            📄 PDF
                        </a>

                        <a href="/notes/{{ $note->id }}/history"
                            class="text-gray-500 dark:text-gray-400 text-sm font-medium hover:underline">
                            🕒 Historial
                        </a>
                                </div>
                </li>
            @endforeach
            </ul>

            @if ($notes instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="mt-6">
                           {{ $notes->links() }}
                </div>
            @endif

    </div>
    @livewireScripts
</body>

</html>