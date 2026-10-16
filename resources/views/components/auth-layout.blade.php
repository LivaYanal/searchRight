@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ? $title.' · ' : '' }}{{ config('app.name') }}</title>
    <x-theme-script />
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full bg-paper font-sans text-ink antialiased">
<div class="grid min-h-screen lg:grid-cols-[1fr_560px]">
    <section class="keep-dark flex flex-col gap-6 bg-ink px-8 py-10 sm:px-14 lg:py-12">
        <div class="flex items-center gap-2.5">
            <x-logo-mark size="lg" />
            <span class="font-display text-[22px] font-extrabold text-surface">searchRight</span>
        </div>

        <div class="my-auto hidden max-w-xl lg:block">
            <h1 class="font-display text-6xl leading-[1.06] font-extrabold text-surface">
                Vind de stage<br>die <span class="text-lime">bij jou past.</span>
            </h1>
            <p class="mt-6 text-lg leading-relaxed text-ink-soft">
                Houd elk bedrijf, elke sollicitatie en elk gesprek bij op één bord.
                Gemaakt door een student die zelf stage zoekt.
            </p>
            <div class="mt-6 flex flex-wrap gap-2">
                @foreach (\App\Enums\ApplicationStatus::cases() as $status)
                    <x-status-badge :status="$status" />
                @endforeach
            </div>
        </div>

        <p class="hidden font-mono text-xs text-ink-soft lg:block">Stage vanaf 25 januari · Software Developer niveau 4</p>
    </section>

    <section class="relative flex items-center justify-center px-6 py-12">
        <x-theme-toggle class="absolute top-5 right-5" />
        <div class="w-full max-w-sm">
            {{ $slot }}
        </div>
    </section>
</div>
</body>
</html>
