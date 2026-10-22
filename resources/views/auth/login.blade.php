<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar sesión · Sanctum</title>
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

    <div class="relative mx-auto max-w-md px-6 pt-16 pb-24">
        <header class="mb-10 text-center">
            <div class="gothic-divider mb-7">
                <span>Sanctum Notarum</span>
            </div>
            <a href="/" class="text-glow-gothic text-4xl sm:text-5xl tracking-[0.6em] text-[#c4b5fd] uppercase" style="font-family: var(--font-display);">
                NOTAS
            </a>
            <p class="mt-6 text-xs uppercase tracking-[0.6em] text-white/50">Acceso al archivo</p>
        </header>

        <div class="gothic-panel gothic-frame px-6 py-9 sm:px-9">
            <div class="text-center">
                <p class="text-xs uppercase tracking-[0.6em] text-[#c4b5fd]/80">Iniciar sesión</p>
                <h1 class="mt-4 text-lg tracking-[0.4em]">Cripta de entrada</h1>
                <div class="ornament-gothic my-7"></div>
            </div>

            <form action="/login" method="POST" x-data="{ loading: false }" @submit="loading = true" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="mb-2 block text-xs uppercase tracking-[0.4em] text-white/60">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required class="input-gothic">
                </div>

                <div>
                    <label for="password" class="mb-2 block text-xs uppercase tracking-[0.4em] text-white/60">Contraseña</label>
                    <input type="password" name="password" id="password" required class="input-gothic">
                </div>

                <label class="flex items-center gap-3 text-xs uppercase tracking-[0.35em] text-white/60">
                    <input type="checkbox" name="remember" class="rounded border border-[#a78bfa]/60 bg-transparent">
                    Recordarme
                </label>

                @if ($errors->any())
                    <div class="rounded-2xl border border-[#ef4444]/70 px-4 py-3 text-center text-xs uppercase tracking-[0.35em] text-red-300">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <button type="submit" :disabled="loading" class="btn-gothic w-full justify-center">
                    <span x-text="loading ? 'Entrando...' : 'Entrar'"></span>
                </button>
            </form>

            <div class="ornament-gothic my-8"></div>
            <p class="text-center text-xs uppercase tracking-[0.4em] text-white/50">
                ¿No tenés cuenta?
                <a href="/register" class="text-[#c4b5fd] hover:text-[#d7ccff]">Registrate</a>
            </p>
        </div>
    </div>
</body>

</html>
