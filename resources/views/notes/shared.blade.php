<!DOCTYPE html>
<html x-data="{ dark: localStorage.getItem('dark') === 'true' }" :class="{ 'dark': dark }">
<head>
    <title>{{ $note->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 font-sans">
    <div class="max-w-2xl mx-auto mt-10 px-4">

        <p class="text-xs text-gray-400 mb-2">Nota compartida</p>

        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-6 shadow-sm">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">{{ $note->title }}</h1>

            @if ($note->image)
                <img src="{{ Storage::url($note->image) }}" alt="{{ $note->title }}" class="w-full max-w-xs rounded-lg mb-3">
            @endif

            <p class="text-gray-600 dark:text-gray-300">{{ $note->content }}</p>

            @if ($note->tags->isNotEmpty())
                <div class="flex gap-2 mt-4">
                    @foreach ($note->tags as $tag)
                        <span class="bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-200 text-xs px-2 py-1 rounded-full">
                            {{ $tag->name }}
                        </span>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</body>
</html>