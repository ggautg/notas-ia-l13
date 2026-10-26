@extends('layouts.app')

@section('title', '404 · Perdido en la cripta')

@section('content')
    <div class="relative mx-auto flex min-h-screen max-w-3xl flex-col items-center justify-center px-6 py-16 text-center">
        <div class="divider mb-10 w-full max-w-lg">
            <span>Sanctum Notarum</span>
        </div>

        <p class="eyebrow eyebrow-accent">Error</p>
        <h1 class="brand text-glow mt-6 text-7xl sm:text-8xl md:text-9xl">
            404
        </h1>
        <p class="eyebrow mt-8 max-w-xl">
            Esta página se ha perdido entre las criptas del archivo
        </p>

        <div class="mt-12 flex flex-wrap justify-center gap-4">
            <a href="/" class="btn-primary">
                <span>Volver al inicio</span>
                <span>→</span>
            </a>
            @auth
                <a href="/notes" class="btn-ghost">
                    <span>Ir al sanctum</span>
                </a>
            @endauth
        </div>

        <div class="divider mt-14 w-full max-w-lg">
            <span>Mors · Umbræ · Silentium</span>
        </div>
    </div>
@endsection
