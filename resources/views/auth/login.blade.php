<x-auth-layout title="Inloggen">
    <h1 class="font-display text-[32px] font-extrabold">Welkom terug 👋</h1>
    <p class="mt-1 text-sm text-ink-muted">Log in om verder te gaan met je zoektocht.</p>

    @if (config('searchright.demo'))
        <div class="mt-5 rounded-xl border border-accent/20 bg-accent-soft px-4 py-3 text-[13px] text-ink">
            <p class="font-semibold text-accent">Even rondkijken? Gebruik het demo-account:</p>
            <p class="mt-1 font-mono text-xs">{{ config('searchright.demo_email') }} · {{ config('searchright.demo_password') }}</p>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="mt-6 flex flex-col gap-4.5">
        @csrf
        <x-field name="email" label="E-mailadres" type="email" required autofocus autocomplete="email" />
        <x-field name="password" label="Wachtwoord" type="password" required autocomplete="current-password" />

        <label class="flex items-center gap-2 text-[13px] text-ink-muted">
            <input type="checkbox" name="remember" class="size-4 rounded accent-accent">
            Ingelogd blijven
        </label>

        <x-button class="w-full">Inloggen</x-button>
    </form>

    <p class="mt-4 text-[13px] text-ink-muted">
        Nog geen account? <a href="{{ route('register') }}" class="font-semibold text-accent hover:underline">Registreren</a>
    </p>
</x-auth-layout>
