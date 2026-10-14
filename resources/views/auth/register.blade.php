<x-layout title="Registreren">
    <div class="mx-auto max-w-sm">
        <h1 class="text-2xl font-semibold tracking-tight">Account aanmaken</h1>
        <p class="mt-1 text-sm text-stone-600">Begin met het bijhouden van je sollicitaties.</p>

        <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-4 rounded-xl border border-stone-200 bg-white p-6">
            @csrf
            <x-field name="name" label="Naam" required autofocus autocomplete="name" />
            <x-field name="email" label="E-mailadres" type="email" required autocomplete="email" />
            <x-field name="password" label="Wachtwoord" type="password" required autocomplete="new-password"
                     hint="Minimaal 8 tekens." />
            <x-field name="password_confirmation" label="Herhaal wachtwoord" type="password" required autocomplete="new-password" />

            <x-button class="w-full">Account aanmaken</x-button>
        </form>

        <p class="mt-4 text-center text-sm text-stone-600">
            Al een account? <a href="{{ route('login') }}" class="font-medium text-teal-800 hover:underline">Inloggen</a>
        </p>
    </div>
</x-layout>
