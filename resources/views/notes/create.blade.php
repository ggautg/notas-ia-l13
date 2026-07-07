<!DOCTYPE html>
<html x-data="{ dark: localStorage.getItem('dark') === 'true' }" :class="{ 'dark': dark }">

<head>
    <title>Nueva Nota</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 font-sans">
    <div class="max-w-2xl mx-auto mt-10 px-4">

        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Nueva Nota</h1>

        @if ($errors->any())
    <div class="bg-red-100 text-red-800 px-4 py-3 rounded-lg mb-4">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

        <form action="/notes" enctype="multipart/form-data" method="POST"
            class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-6 shadow-sm">
            @csrf

            <div class="mb-4">
                <label for="title" class="block text-sm font-semibold mb-1 dark:text-gray-200">Título</label>
                <input type="text" name="title" id="title"
                    class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg px-3 py-2 text-sm">
            </div>

            <div class="mb-4">
                <label for="content" class="block text-sm font-semibold mb-1 dark:text-gray-200">Contenido</label>
                <textarea name="content" id="content" rows="5"
                    class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg px-3 py-2 text-sm"></textarea>
            </div>

            <div class="mb-4">
                <label for="tags" class="block text-sm font-semibold mb-1 dark:text-gray-200">Etiquetas</label>
                <input type="text" name="tags" id="tags" placeholder="trabajo, personal, ideas"
                    class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg px-3 py-2 text-sm">
                <p class="text-xs text-gray-400 mt-1">Separá las etiquetas con comas</p>
            </div>

            <div class="mb-4">
                <label for="image" class="block text-sm font-semibold mb-1 dark:text-gray-200">Imagen (opcional)</label>
                <input type="file" name="image" id="image" accept="image/*" class="w-full text-sm dark:text-gray-200">
            </div>

            <button type="submit"
                class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700">
                Guardar
            </button>
        </form>

        <a href="/notes"
            class="inline-block mt-4 text-indigo-600 dark:text-indigo-400 text-sm font-medium hover:underline">← Volver
            a la lista</a>

    </div>
</body>

</html>