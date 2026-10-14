<x-layout title="Bedrijven">
    <div class="flex flex-wrap items-center gap-4">
        <div class="min-w-0 flex-1">
            <h1 class="font-display text-[34px] leading-10 font-extrabold">Bedrijven</h1>
            <p class="mt-1 text-sm text-ink-muted">
                {{ $companies->count() }} {{ $companies->count() === 1 ? 'bedrijf' : 'bedrijven' }}{{ $search || $techId ? ' gevonden' : ' in je lijst' }}
            </p>
        </div>
        <x-button :href="route('companies.create')">+ Bedrijf toevoegen</x-button>
    </div>

    <form method="GET" action="{{ route('companies.index') }}" class="mt-6 flex flex-wrap gap-2">
        <div class="relative min-w-0 flex-1">
            <x-icon name="search" :size="16" class="absolute top-1/2 left-3 -translate-y-1/2 text-ink-soft" />
            <input type="search" name="q" value="{{ $search }}" placeholder="Zoek op naam, plaats of focus…"
                   class="w-full rounded-[10px] border border-line bg-surface py-2.5 pr-3 pl-9 text-sm outline-none placeholder:text-ink-soft focus:border-accent focus:ring-2 focus:ring-accent/20">
        </div>
        <select name="tech" aria-label="Filter op taal"
                class="rounded-[10px] border border-line bg-surface px-3 py-2.5 text-sm outline-none focus:border-accent">
            <option value="">Alle talen</option>
            @foreach ($technologies as $technology)
                <option value="{{ $technology->id }}" @selected($techId === $technology->id)>{{ $technology->name }}</option>
            @endforeach
        </select>
        <x-button variant="secondary">Filteren</x-button>
        @if ($search || $techId)
            <x-button variant="secondary" :href="route('companies.index')">Wissen</x-button>
        @endif
    </form>

    @if ($companies->isNotEmpty())
        <div class="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4">
            @foreach ($companies as $company)
                <x-company-card :company="$company" />
            @endforeach
        </div>
    @else
        <div class="mt-6 rounded-2xl border-[1.5px] border-dashed border-ink-soft/40 px-6 py-14 text-center">
            @if ($search || $techId)
                <p class="font-display text-lg font-bold">Geen bedrijven gevonden</p>
                <p class="mt-1 text-sm text-ink-muted">Probeer een andere zoekterm of taal.</p>
            @else
                <p class="font-display text-lg font-bold">Nog geen bedrijven</p>
                <p class="mt-1 text-sm text-ink-muted">Voeg je eerste bedrijf van stagemarkt.nl toe.</p>
                <x-button :href="route('companies.create')" class="mt-4">+ Bedrijf toevoegen</x-button>
            @endif
        </div>
    @endif
</x-layout>
