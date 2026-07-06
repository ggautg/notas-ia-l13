<!DOCTYPE html>
<html>
<head>
    <title>Editar Nota</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 text-gray-800 font-sans">
    <div class="max-w-2xl mx-auto mt-10 px-4">

        <h1 class="text-3xl font-bold text-gray-900 mb-6">Editar Nota</h1>

        <form action="/notes/{{ $note->id }}" method="POST" class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="title" class="block text-sm font-semibold mb-1">Título</label>
                <input type="text" name="title" id="title" value="{{ $note->title }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>

            <div class="mb-4">
                <label for="content" class="block text-sm font-semibold mb-1">Contenido</label>
                <textarea name="content" id="content" rows="5" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">{{ $note->content }}</textarea>
            </div>

            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700">
                Actualizar
            </button>
        </form>

        <a href="/notes" class="inline-block mt-4 text-indigo-600 text-sm font-medium hover:underline">← Volver a la lista</a>

    </div>
</body>
</html>