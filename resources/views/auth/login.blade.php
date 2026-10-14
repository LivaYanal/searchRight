<x-layout title="Inloggen">
    <div class="mx-auto max-w-sm">
        <h1 class="text-2xl font-semibold tracking-tight">Inloggen</h1>
        <p class="mt-1 text-sm text-stone-600">Houd je stagezoektocht bij op één plek.</p>

        <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-4 rounded-xl border border-stone-200 bg-white p-6">
            @csrf
            <x-field name="email" label="E-mailadres" type="email" required autofocus autocomplete="email" />
            <x-field name="password" label="Wachtwoord" type="password" required autocomplete="current-password" />

            <label class="flex items-center gap-2 text-sm text-stone-600">
                <input type="checkbox" name="remember" class="rounded border-stone-300 accent-teal-700">
                Ingelogd blijven
            </label>

            <x-button class="w-full">Inloggen</x-button>
        </form>

        <p class="mt-4 text-center text-sm text-stone-600">
            Nog geen account? <a href="{{ route('register') }}" class="font-medium text-teal-800 hover:underline">Registreren</a>
        </p>
    </div>
</x-layout>
