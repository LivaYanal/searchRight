<x-layout title="Bedrijf toevoegen">
    <a href="{{ route('companies.index') }}" class="text-sm text-stone-600 hover:text-stone-900">← Terug naar bedrijven</a>
    <h1 class="mt-2 text-2xl font-semibold tracking-tight">Bedrijf toevoegen</h1>

    <form method="POST" action="{{ route('companies.store') }}" class="mt-6 space-y-6">
        @include('companies._form')

        <div class="flex justify-end gap-2">
            <x-button variant="secondary" :href="route('companies.index')">Annuleren</x-button>
            <x-button>Opslaan</x-button>
        </div>
    </form>
</x-layout>
