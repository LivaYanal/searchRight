<x-auth-layout title="Inloggen">
    <h1 class="font-display text-[32px] font-extrabold">Welkom terug 👋</h1>
    <p class="mt-1 text-sm text-ink-muted">Log in om verder te gaan met je zoektocht.</p>

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
