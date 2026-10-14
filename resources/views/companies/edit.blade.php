<x-layout :title="$company->name.' bewerken'">
    <a href="{{ route('companies.index') }}" class="text-sm text-stone-600 hover:text-stone-900">← Terug naar bedrijven</a>
    <h1 class="mt-2 text-2xl font-semibold tracking-tight">{{ $company->name }} bewerken</h1>

    <form method="POST" action="{{ route('companies.update', $company) }}" class="mt-6 space-y-6">
        @method('PUT')
        @include('companies._form')

        <div class="flex justify-end gap-2">
            <x-button variant="secondary" :href="route('companies.index')">Annuleren</x-button>
            <x-button>Opslaan</x-button>
        </div>
    </form>

    <form method="POST" action="{{ route('companies.destroy', $company) }}" class="mt-10 border-t border-stone-200 pt-6"
          onsubmit="return confirm(@js('Weet je zeker dat je '.$company->name.' wilt verwijderen? Sollicitaties worden ook verwijderd.'))">
        @csrf
        @method('DELETE')
        <x-button variant="danger">Bedrijf verwijderen</x-button>
    </form>
</x-layout>
