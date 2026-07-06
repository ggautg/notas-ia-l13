<!DOCTYPE html>
<html>
<head>
    <title>Crear cuenta</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 text-gray-800 font-sans">
    <div class="max-w-md mx-auto mt-20 px-4">

        <h1 class="text-3xl font-bold text-gray-900 mb-6 text-center">Crear cuenta</h1>

        @if ($errors->any())
            <div class="bg-red-100 text-red-800 px-4 py-3 rounded-lg mb-4">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="/register" method="POST" class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-sm font-semibold mb-1">Nombre</label>
                <input type="text" name="name" id="name" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-semibold mb-1">Email</label>
                <input type="email" name="email" id="email" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-semibold mb-1">Contraseña</label>
                <input type="password" name="password" id="password" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-semibold mb-1">Confirmar contraseña</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700">
                Registrarme
            </button>
        </form>

        <p class="text-center text-sm text-gray-600 mt-4">
            ¿Ya tenés cuenta? <a href="/login" class="text-indigo-600 hover:underline">Iniciá sesión</a>
        </p>

    </div>
</body>
</html>