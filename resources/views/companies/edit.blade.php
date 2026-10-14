<x-layout :title="$company->name.' bewerken'">
    <div class="mx-auto max-w-160">
        <a href="{{ route('companies.show', $company) }}" class="text-[13px] font-medium text-ink-muted hover:text-ink">← Terug naar {{ $company->name }}</a>

        <form method="POST" action="{{ route('companies.update', $company) }}"
              class="mt-4 flex flex-col gap-5 rounded-2xl bg-surface p-7 shadow-[0_24px_60px_rgba(0,0,0,0.12)] sm:p-8">
            @method('PUT')
            <h1 class="font-display text-[26px] font-extrabold">{{ $company->name }} bewerken</h1>

            @include('companies._form')

            <div class="flex justify-end gap-2.5 pt-2">
                <x-button variant="secondary" :href="route('companies.show', $company)">Annuleren</x-button>
                <x-button>Opslaan</x-button>
            </div>
        </form>

        <form method="POST" action="{{ route('companies.destroy', $company) }}" class="mt-6 flex justify-end"
              onsubmit="return confirm(@js('Weet je zeker dat je '.$company->name.' wilt verwijderen? De sollicitatie wordt ook verwijderd.'))">
            @csrf
            @method('DELETE')
            <x-button variant="danger">Bedrijf verwijderen</x-button>
        </form>
    </div>
</x-layout>
