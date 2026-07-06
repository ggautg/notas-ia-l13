<!DOCTYPE html>
<html>
<head>
    <title>Iniciar sesión</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 text-gray-800 font-sans">
    <div class="max-w-md mx-auto mt-20 px-4">

        <h1 class="text-3xl font-bold text-gray-900 mb-6 text-center">Iniciar sesión</h1>

        @if ($errors->any())
            <div class="bg-red-100 text-red-800 px-4 py-3 rounded-lg mb-4">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="/login" method="POST" class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-sm font-semibold mb-1">Email</label>
                <input type="email" name="email" id="email" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-semibold mb-1">Contraseña</label>
                <input type="password" name="password" id="password" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700">
                Entrar
            </button>
        </form>

        <p class="text-center text-sm text-gray-600 mt-4">
            ¿No tenés cuenta? <a href="/register" class="text-indigo-600 hover:underline">Registrate</a>
        </p>

    </div>
</body>
</html>