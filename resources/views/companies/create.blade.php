<x-layout title="Bedrijf toevoegen">
    <div class="mx-auto max-w-160">
        <a href="{{ route('board') }}" class="text-[13px] font-medium text-ink-muted hover:text-ink">← Terug naar bord</a>

        <form method="POST" action="{{ route('companies.store') }}"
              class="mt-4 flex flex-col gap-5 rounded-2xl bg-surface p-7 shadow-[0_24px_60px_rgba(0,0,0,0.12)] sm:p-8">
            <div>
                <h1 class="font-display text-[26px] font-extrabold">Bedrijf toevoegen</h1>
                <p class="mt-1 text-sm text-ink-muted">Gevonden op stagemarkt.nl? Zet het hier neer.</p>
            </div>

            @include('companies._form')

            <div class="flex justify-end gap-2.5 pt-2">
                <x-button variant="secondary" :href="route('board')">Annuleren</x-button>
                <x-button>Opslaan</x-button>
            </div>
        </form>
    </div>
</x-layout>
