@use('App\Enums\ApplicationStatus')

<x-layout title="Bord">
    {{-- Kop --}}
    <div class="flex flex-wrap items-center gap-4">
        <div class="min-w-0 flex-1">
            <h1 class="font-display text-[34px] leading-10 font-extrabold">Mijn stagezoektocht</h1>
            <p class="mt-1 text-sm text-ink-muted">Sleep een bedrijf naar de volgende kolom om de status bij te werken.</p>
        </div>
        <form method="GET" action="{{ route('companies.index') }}" class="relative hidden w-75 sm:block">
            <x-icon name="search" :size="16" class="absolute top-1/2 left-3 -translate-y-1/2 text-ink-soft" />
            <input type="search" name="q" placeholder="Zoek bedrijf, plaats of taal…"
                   class="w-full rounded-[10px] border border-line bg-surface py-2.5 pr-3 pl-9 text-sm outline-none placeholder:text-ink-soft focus:border-accent focus:ring-2 focus:ring-accent/20">
        </form>
        <x-button :href="route('companies.create')">+ Bedrijf toevoegen</x-button>
    </div>

    {{-- Statistieken (worden na elke sleepactie vernieuwd) --}}
    @include('board._stats')

    {{-- Kanban-bord --}}
    <div data-board class="-mx-4 mt-7 flex gap-4 overflow-x-auto px-4 pb-4 sm:mx-0 sm:px-0">
        @foreach ($columns as $value => $companies)
            @php $status = ApplicationStatus::from($value); @endphp

            <section data-column="{{ $value }}" class="flex min-h-[420px] w-64 shrink-0 flex-col gap-2.5 rounded-2xl bg-line/45 p-2.5 xl:w-auto xl:flex-1"
                     aria-label="Kolom {{ $status->label() }}">
                <h2 class="flex items-center gap-2 px-1 pt-1 text-sm font-semibold">
                    <span class="size-2 rounded-full {{ $status->dotClass() }}"></span>
                    <span class="flex-1">{{ $status->label() }}</span>
                    <span data-count class="rounded-full bg-surface px-2 py-0.5 font-mono text-[11px] font-medium text-ink-muted">{{ $companies->count() }}</span>
                </h2>

                <div data-list class="flex flex-1 flex-col gap-2.5">
                    @foreach ($companies as $company)
                        <x-company-card :company="$company" draggable />
                    @endforeach

                    <div data-empty @class(['hidden' => $companies->isNotEmpty()])>
                        <div @class([
                            'flex flex-col items-center gap-1.5 rounded-2xl border-[1.5px] border-dashed px-3 py-7 text-center text-[13px] font-semibold',
                            'border-st-accepted/50 text-st-accepted' => $status === ApplicationStatus::Accepted,
                            'border-ink-soft/40 text-ink-soft' => $status !== ApplicationStatus::Accepted,
                        ])>
                            @if ($status === ApplicationStatus::Accepted)
                                <span class="text-2xl">🎉</span> Hier komt jouw stageplek
                            @else
                                Sleep hier een bedrijf naartoe
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        @endforeach
    </div>
</x-layout>
