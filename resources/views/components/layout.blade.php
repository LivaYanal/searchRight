@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ? $title.' · ' : '' }}{{ config('app.name') }}</title>
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full bg-paper font-sans text-ink antialiased">
<div class="flex min-h-screen">

    {{-- Zijbalk (vanaf laptopformaat) --}}
    <aside class="sticky top-0 hidden h-screen w-62 shrink-0 flex-col gap-7 bg-ink px-5 pt-7 pb-6 lg:flex">
        <a href="{{ route('board') }}" class="flex items-center gap-2.5">
            <x-logo-mark />
            <span class="font-display text-xl font-extrabold text-surface">searchRight</span>
        </a>

        <nav class="flex flex-col gap-1 text-sm">
            <x-nav-link :href="route('board')" :active="request()->routeIs('board')" icon="board">Bord</x-nav-link>
            <x-nav-link :href="route('companies.index')" :active="request()->routeIs('companies.*')" icon="building"
                        :count="auth()->user()->companies()->count()">Bedrijven</x-nav-link>
        </nav>

        <div class="mt-auto rounded-2xl bg-lime p-4 text-ink">
            <p class="text-xs font-medium">Stage begint over</p>
            <p class="flex items-baseline gap-1.5">
                <span class="font-display text-4xl leading-11 font-extrabold">{{ $daysUntilInternship }}</span>
                <span class="text-sm font-semibold">{{ $daysUntilInternship === 1 ? 'dag' : 'dagen' }}</span>
            </p>
            <p class="text-xs text-ink-muted">{{ $internshipStart->translatedFormat('j F') }} · blijf solliciteren 💪</p>
        </div>

        <div class="flex items-center gap-2.5">
            <span class="grid size-9 shrink-0 place-items-center rounded-full bg-accent text-sm font-semibold text-surface">
                {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr(auth()->user()->name, 0, 2)) }}
            </span>
            <div class="min-w-0 flex-1">
                <p class="truncate text-sm font-semibold text-surface">{{ auth()->user()->name }}</p>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-xs text-ink-soft hover:text-lime">Uitloggen</button>
                </form>
            </div>
        </div>
    </aside>

    <div class="flex min-w-0 flex-1 flex-col">
        {{-- Bovenbalk op telefoon/tablet --}}
        <header class="flex items-center justify-between gap-4 bg-ink px-4 py-3 lg:hidden">
            <a href="{{ route('board') }}" class="flex items-center gap-2">
                <x-logo-mark />
                <span class="font-display text-lg font-extrabold text-surface">searchRight</span>
            </a>
            <nav class="flex items-center gap-4 text-sm text-ink-soft">
                <a href="{{ route('board') }}" class="{{ request()->routeIs('board') ? 'text-lime' : '' }}">Bord</a>
                <a href="{{ route('companies.index') }}" class="{{ request()->routeIs('companies.*') ? 'text-lime' : '' }}">Bedrijven</a>
                <span class="rounded-full bg-lime px-2 py-0.5 text-xs font-semibold text-ink">{{ $daysUntilInternship }} d</span>
            </nav>
        </header>

        <main class="flex-1 px-4 py-6 sm:px-8 lg:px-10 lg:py-8">
            @if (session('status'))
                <div class="mb-6 rounded-xl border border-accent/20 bg-accent-soft px-4 py-3 text-sm font-medium text-accent" role="status">
                    {{ session('status') }}
                </div>
            @endif

            {{ $slot }}
        </main>
    </div>
</div>

<div id="toast" class="pointer-events-none fixed bottom-6 left-1/2 -translate-x-1/2 rounded-xl bg-ink px-4 py-3 text-sm text-surface opacity-0 shadow-xl transition" role="alert"></div>
</body>
</html>
