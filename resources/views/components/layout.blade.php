@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ? $title.' · ' : '' }}{{ config('app.name') }}</title>
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full bg-stone-50 text-stone-900 antialiased">
    <header class="border-b border-stone-200 bg-white">
        <div class="mx-auto flex max-w-5xl items-center justify-between gap-4 px-4 py-3">
            <a href="{{ url('/') }}" class="flex items-center gap-2 font-semibold tracking-tight">
                <span class="grid size-8 place-items-center rounded-lg bg-teal-700 text-white">sR</span>
                <span>search<span class="text-teal-700">Right</span></span>
            </a>

            @auth
                <nav class="flex items-center gap-4 text-sm">
                    <a href="{{ route('companies.index') }}"
                       class="{{ request()->routeIs('companies.*') ? 'font-semibold text-teal-800' : 'text-stone-600 hover:text-stone-900' }}">
                        Bedrijven
                    </a>
                    <span class="hidden text-stone-400 sm:inline">|</span>
                    <span class="hidden text-stone-600 sm:inline">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-stone-600 hover:text-stone-900">Uitloggen</button>
                    </form>
                </nav>
            @endauth
        </div>
    </header>

    <main class="mx-auto max-w-5xl px-4 py-8">
        @if (session('status'))
            <div class="mb-6 rounded-lg border border-teal-200 bg-teal-50 px-4 py-3 text-sm text-teal-900" role="status">
                {{ session('status') }}
            </div>
        @endif

        {{ $slot }}
    </main>
</body>
</html>
