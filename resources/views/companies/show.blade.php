@use('App\Enums\ApplicationStatus')

<x-layout :title="$company->name">
    <a href="{{ route('board') }}" class="text-[13px] font-medium text-ink-muted hover:text-ink">← Terug naar bord</a>

    {{-- Kop --}}
    <div class="mt-5 flex flex-wrap items-center gap-4.5">
        <span class="grid size-16 shrink-0 place-items-center rounded-2xl bg-accent-soft font-display text-[22px] font-extrabold text-accent">{{ $company->initials }}</span>
        <div class="min-w-0 flex-1">
            <h1 class="font-display text-[34px] leading-10 font-extrabold">{{ $company->name }}</h1>
            <p class="mt-1.5 flex flex-wrap items-center gap-x-3.5 gap-y-1 text-sm text-ink-muted">
                <span>{{ $company->meta }}</span>
                @if ($company->website)
                    <a href="{{ $company->website }}" target="_blank" rel="noopener" class="font-semibold text-accent hover:underline">Website ↗</a>
                @endif
                @if ($company->stagemarkt_url)
                    <a href="{{ $company->stagemarkt_url }}" target="_blank" rel="noopener" class="font-semibold text-accent hover:underline">Stagemarkt ↗</a>
                @endif
            </p>
        </div>
        <x-button variant="secondary" :href="route('companies.edit', $company)">Bewerken</x-button>
        @if ($company->contact_email)
            <x-button variant="dark" :href="'mailto:'.$company->contact_email">
                <x-icon name="mail" :size="16" /> Mail contactpersoon
            </x-button>
        @endif
    </div>

    <div class="mt-6 grid items-start gap-5 xl:grid-cols-[1fr_400px]">
        {{-- Links --}}
        <div class="flex flex-col gap-5">
            <x-panel title="Status van je sollicitatie">
                <p class="-mt-2 text-[13px] text-ink-muted">Klik op een status om hem te wijzigen. Op het bord verschuift de kaart mee.</p>

                <div class="grid grid-cols-2 gap-2 sm:grid-cols-5">
                    @foreach (ApplicationStatus::cases() as $status)
                        @php $active = $application->status === $status; @endphp
                        <form method="POST" action="{{ route('companies.status', $company) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="{{ $status->value }}">
                            <button @class([
                                'flex w-full items-center justify-center gap-2 rounded-[10px] px-3 py-3 text-[13px] transition',
                                $status->activeClasses().' border-2 font-semibold' => $active,
                                'border border-line bg-surface font-medium text-ink-muted hover:border-ink-soft' => ! $active,
                            ]) @if ($active) aria-pressed="true" @endif>
                                <span class="size-2 rounded-full {{ $status->dotClass() }}"></span>
                                {{ $status->label() }}
                            </button>
                        </form>
                    @endforeach
                </div>
            </x-panel>

            <form method="POST" action="{{ route('companies.application', $company) }}">
                @csrf
                @method('PATCH')
                <x-panel title="Datums en notities">
                    <div class="grid gap-4 sm:grid-cols-2">
                        <x-field name="sent_at" label="Verstuurd op" type="date" :value="$application->sent_at?->format('Y-m-d')" />
                        <x-field name="follow_up_at" label="Opvolgen op" type="date" :value="$application->follow_up_at?->format('Y-m-d')"
                                 hint="Bij een gesprek: de datum van het gesprek." />
                    </div>
                    <div>
                        <label for="notes" class="mb-1.5 block text-[13px] font-medium">Notities</label>
                        <textarea id="notes" name="notes" rows="5"
                                  placeholder="Wie sprak je? Wat wil je vragen in het gesprek?"
                                  class="w-full rounded-[10px] border border-line bg-paper px-4 py-3 text-sm leading-[22px] outline-none placeholder:text-ink-soft focus:border-accent focus:ring-2 focus:ring-accent/20">{{ old('notes', $application->notes) }}</textarea>
                        @error('notes') <p class="mt-1 text-xs font-medium text-st-rejected">{{ $message }}</p> @enderror
                    </div>
                    <div class="flex justify-end"><x-button>Opslaan</x-button></div>
                </x-panel>
            </form>

            <x-panel title="Tijdlijn">
                <ol class="flex flex-col gap-3.5">
                    @php
                        $events = collect([
                            [$company->created_at, 'Toegevoegd aan searchRight', 'bg-ink-soft'],
                            [$application->sent_at, 'Sollicitatie verstuurd', 'bg-st-sent'],
                            [$application->follow_up_at, $application->status === ApplicationStatus::Interview ? 'Gesprek' : 'Opvolgen', 'bg-accent'],
                        ])->filter(fn ($event) => $event[0] !== null)->sortBy(fn ($event) => $event[0]);
                    @endphp
                    @foreach ($events as $event)
                        <li class="flex items-center gap-3.5">
                            <span class="w-14 shrink-0 font-mono text-xs text-ink-soft">{{ $event[0]->translatedFormat('j M') }}</span>
                            <span class="size-2.5 shrink-0 rounded-full {{ $event[2] }}"></span>
                            <span class="text-sm font-medium">{{ $event[1] }}</span>
                        </li>
                    @endforeach
                </ol>
            </x-panel>
        </div>

        {{-- Rechts --}}
        <div class="flex flex-col gap-5">
            <x-panel title="Over het bedrijf">
                <p class="text-sm leading-[21px] text-ink-muted">{{ $company->description ?: '-' }}</p>
                <dl class="flex flex-col gap-2 text-[13px]">
                    <div class="flex justify-between gap-4"><dt class="text-ink-soft">Focus</dt><dd class="font-semibold">{{ $company->focus ?: '-' }}</dd></div>
                    <div class="flex justify-between gap-4"><dt class="text-ink-soft">Plaats</dt><dd class="font-semibold">{{ $company->city ?: '-' }}</dd></div>
                </dl>
                <div>
                    <p class="mb-2 text-[13px] text-ink-soft">Talen</p>
                    <div class="flex flex-wrap gap-1.5">
                        @forelse ($company->technologies->sortBy('name') as $technology)
                            <x-tech-chip>{{ $technology->name }}</x-tech-chip>
                        @empty
                            <x-tech-chip>-</x-tech-chip>
                        @endforelse
                    </div>
                </div>
            </x-panel>

            <x-panel title="Contactpersoon">
                @if ($company->contact_name)
                    <div class="flex items-center gap-3">
                        <span class="grid size-10 place-items-center rounded-full bg-st-interview-soft text-sm font-semibold text-st-interview">
                            {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($company->contact_name, 0, 2)) }}
                        </span>
                        <p class="font-semibold">{{ $company->contact_name }}</p>
                    </div>
                @endif
                <dl class="flex flex-col gap-2 text-[13px]">
                    <div class="flex justify-between gap-4"><dt class="text-ink-soft">E-mail</dt>
                        <dd class="truncate font-semibold">
                            @if ($company->contact_email)
                                <a href="mailto:{{ $company->contact_email }}" class="hover:text-accent">{{ $company->contact_email }}</a>
                            @else - @endif
                        </dd></div>
                    <div class="flex justify-between gap-4"><dt class="text-ink-soft">Telefoon</dt><dd class="font-semibold">{{ $company->contact_phone ?: '-' }}</dd></div>
                </dl>
            </x-panel>

            <x-panel title="Tip" dark>
                <p class="text-sm leading-[21px]">{{ $application->status->tip() }}</p>
            </x-panel>
        </div>
    </div>
</x-layout>
