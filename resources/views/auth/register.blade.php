<x-auth-layout title="Registreren">
    <h1 class="font-display text-[32px] font-extrabold">Account aanmaken</h1>
    <p class="mt-1 text-sm text-ink-muted">Begin met het bijhouden van je sollicitaties.</p>

    <form method="POST" action="{{ route('register') }}" class="mt-6 flex flex-col gap-4.5">
        @csrf
        <x-field name="name" label="Naam" required autofocus autocomplete="name" />
        <x-field name="email" label="E-mailadres" type="email" required autocomplete="email" />
        <x-field name="password" label="Wachtwoord" type="password" required autocomplete="new-password" hint="Minimaal 8 tekens." />
        <x-field name="password_confirmation" label="Herhaal wachtwoord" type="password" required autocomplete="new-password" />

        <x-button class="w-full">Account aanmaken</x-button>
    </form>

    <p class="mt-4 text-[13px] text-ink-muted">
        Al een account? <a href="{{ route('login') }}" class="font-semibold text-accent hover:underline">Inloggen</a>
    </p>
</x-auth-layout>
