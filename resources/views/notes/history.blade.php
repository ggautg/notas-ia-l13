<!DOCTYPE html>
<html x-data="{ dark: localStorage.getItem('dark') === 'true' }" :class="{ 'dark': dark }">
<head>
    <title>Historial de {{ $note->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 font-sans">
    <div class="max-w-2xl mx-auto mt-10 px-4">

        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Historial de versiones</h1>
        <p class="text-gray-500 dark:text-gray-400 mb-6">{{ $note->title }}</p>

        @if ($note->versions->isEmpty())
            <p class="text-gray-400">Esta nota todavía no tiene versiones anteriores guardadas.</p>
        @else
            <ul class="space-y-4">
                @foreach ($note->versions as $version)
                    <li class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 shadow-sm">
                        <p class="text-xs text-gray-400 mb-2">{{ $version->created_at->format('d/m/Y H:i') }}</p>
                        <strong class="text-gray-900 dark:text-white">{{ $version->title }}</strong>
                        <p class="text-gray-600 dark:text-gray-300 text-sm mt-1">{{ $version->content }}</p>

                        <form action="/notes/{{ $note->id }}/restore/{{ $version->id }}" method="POST" class="mt-3">
                            @csrf
                            <button type="submit" class="text-indigo-600 dark:text-indigo-400 text-sm font-medium hover:underline">
                                ↩ Restaurar esta versión
                            </button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @endif

        <a href="/notes" class="inline-block mt-6 text-indigo-600 dark:text-indigo-400 text-sm font-medium hover:underline">← Volver a la lista</a>

    </div>
</body>
</html>