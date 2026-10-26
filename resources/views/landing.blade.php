@extends('layouts.app')

@section('title', 'Notas · Sanctum')

@section('content')
    <div class="relative mx-auto flex min-h-screen max-w-4xl flex-col items-center justify-center px-6 py-16 text-center">
        <div class="divider mb-10 w-full max-w-xl">
            <span>Sanctum Notarum</span>
        </div>

        <h1 class="brand text-glow text-6xl sm:text-7xl md:text-8xl">
            NOTAS
        </h1>

        <p class="eyebrow mt-8 max-w-2xl">
            Un archivo para tus ideas · Minimal · Elegante
        </p>

        <div class="mt-14 flex flex-wrap justify-center gap-4">
            @auth
                <a href="/notes" class="btn-primary">
                    <span>Ir a mis notas</span>
                    <span>→</span>
                </a>
            @else
                <a href="/register" class="btn-primary">
                    <span>Empezar gratis</span>
                    <span>→</span>
                </a>
                <a href="/login" class="btn-ghost">
                    <span>Iniciar sesión</span>
                </a>
            @endauth
        </div>

        <div class="divider mt-16 w-full max-w-xl">
            <span>Noctis · Ars · Memoria</span>
        </div>
    </div>
@endsection
