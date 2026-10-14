<x-layout title="Bedrijven">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight">Bedrijven</h1>
            <p class="mt-1 text-sm text-stone-600">
                {{ $companies->count() }} {{ $companies->count() === 1 ? 'bedrijf' : 'bedrijven' }} in je lijst
            </p>
        </div>
        <x-button :href="route('companies.create')">+ Bedrijf toevoegen</x-button>
    </div>

    {{-- Zoeken en filteren --}}
    <form method="GET" action="{{ route('companies.index') }}" class="mt-6 flex flex-wrap gap-2">
        <input type="search" name="q" value="{{ $search }}" placeholder="Zoek op naam, plaats of focus…"
               class="min-w-0 flex-1 rounded-lg border border-stone-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-600/20">
        <select name="tech" aria-label="Filter op taal"
                class="rounded-lg border border-stone-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600">
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

    {{-- Lijst --}}
    @if ($companies->isNotEmpty())
    <ul class="mt-6 grid gap-4 md:grid-cols-2">
        @foreach ($companies as $company)

        <li class="flex flex-col rounded-xl border border-stone-200 bg-white p-5">
            <div class="flex items-start justify-between gap-3">
                <div class="min-w-0">
                    <h2 class="truncate font-semibold">{{ $company->name }}</h2>
                    <p class="text-sm text-stone-500">
                        {{ $company->city ?: 'Plaats onbekend' }}
                        @if ($company->focus) · <span class="text-stone-700">{{ $company->focus }}</span> @endif
                    </p>
                </div>

                @if ($status = $company->latestApplication?->status)
                    <span class="shrink-0 rounded-full px-2.5 py-0.5 text-xs font-medium ring-1 ring-inset {{ $status->badgeClasses() }}">
                        {{ $status->label() }}
                    </span>
                @else
                    <span class="shrink-0 rounded-full px-2.5 py-0.5 text-xs text-stone-500 ring-1 ring-inset ring-stone-200">
                        Nog niet gesolliciteerd
                    </span>
                @endif
            </div>

            <p class="mt-3 text-sm text-stone-700">{{ $company->description ?: '-' }}</p>

            <div class="mt-3 flex flex-wrap gap-1.5">
                @forelse ($company->technologies->sortBy('name') as $technology)
                    <span class="rounded-md bg-stone-100 px-2 py-0.5 font-mono text-xs text-stone-700">{{ $technology->name }}</span>
                @empty
                    <span class="text-sm text-stone-400">-</span>
                @endforelse
            </div>

            <div class="mt-auto flex flex-wrap items-center gap-x-4 gap-y-1 pt-4 text-sm">
                @if ($company->website)
                    <a href="{{ $company->website }}" target="_blank" rel="noopener" class="text-teal-800 hover:underline">Website ↗</a>
                @endif
                @if ($company->stagemarkt_url)
                    <a href="{{ $company->stagemarkt_url }}" target="_blank" rel="noopener" class="text-teal-800 hover:underline">Stagemarkt ↗</a>
                @endif
                <a href="{{ route('companies.edit', $company) }}" class="ml-auto text-stone-600 hover:text-stone-900">Bewerken</a>
            </div>
        </li>
        @endforeach
    </ul>
    @else
        <div class="mt-6 rounded-xl border border-dashed border-stone-300 bg-white px-6 py-12 text-center">
            @if ($search || $techId)
                <p class="font-medium">Geen bedrijven gevonden</p>
                <p class="mt-1 text-sm text-stone-600">Probeer een andere zoekterm of taal.</p>
            @else
                <p class="font-medium">Nog geen bedrijven</p>
                <p class="mt-1 text-sm text-stone-600">Voeg je eerste bedrijf van stagemarkt.nl toe.</p>
                <x-button :href="route('companies.create')" class="mt-4">+ Bedrijf toevoegen</x-button>
            @endif
        </div>
    @endif
</x-layout>
