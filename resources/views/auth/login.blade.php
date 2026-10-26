@extends('layouts.app')

@section('title', 'Iniciar sesión · Sanctum')

@section('content')
    <div class="relative mx-auto max-w-md px-6 pt-16 pb-24">
        <header class="mb-10 text-center">
            <div class="divider mb-7">
                <span>Sanctum Notarum</span>
            </div>
            <a href="/" class="brand text-glow text-4xl sm:text-5xl">
                NOTAS
            </a>
            <p class="eyebrow mt-6">Acceso al archivo</p>
        </header>

        <div class="theme-panel px-6 py-9 sm:px-9">
            <div class="text-center">
                <p class="eyebrow eyebrow-accent">Iniciar sesión</p>
                <h1 class="title mt-4 text-lg">Cripta de entrada</h1>
                <div class="ornament my-7"></div>
            </div>

            <form action="/login" method="POST" x-data="{ loading: false }" @submit="loading = true" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="label">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                        class="input-theme">
                </div>

                <div>
                    <label for="password" class="label">Contraseña</label>
                    <input type="password" name="password" id="password" required class="input-theme">
                </div>

                <label class="flex items-center gap-3 text-xs uppercase tracking-[0.3em] t-muted">
                    <input type="checkbox" name="remember"
                        class="h-4 w-4 rounded border border-current bg-transparent accent-[var(--accent)]">
                    Recordarme
                </label>

                @if ($errors->any())
                    <div class="rounded-2xl border px-4 py-3 text-center text-xs uppercase tracking-[0.3em] t-danger"
                        style="border-color: var(--danger); background: var(--danger-wash);">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <button type="submit" :disabled="loading" class="btn-primary w-full">
                    <span x-text="loading ? 'Entrando...' : 'Entrar'"></span>
                </button>
            </form>

            <div class="ornament my-8"></div>
            <p class="text-center text-xs uppercase tracking-[0.35em] t-muted">
                ¿No tenés cuenta?
                <a href="/register" class="t-accent font-semibold">Registrate</a>
            </p>
        </div>
    </div>
@endsection
