@props(['company', 'draggable' => false])

@php
    $application = $company->latestApplication ?? $company->currentApplication();
    $status = $company->currentStatus();
@endphp

<article
    {{ $attributes->merge(['class' => 'group relative flex flex-col gap-3 rounded-2xl border border-line bg-surface p-4 shadow-[0_2px_6px_rgba(20,18,31,0.06)] transition hover:-translate-y-0.5 hover:shadow-[0_10px_24px_rgba(20,18,31,0.10)] '.($status === \App\Enums\ApplicationStatus::Rejected ? 'opacity-60 hover:opacity-100' : '')]) }}
    @if ($draggable)
        draggable="true" data-card="{{ $company->id }}" data-status-url="{{ route('companies.status', $company) }}"
    @endif
>
    <header class="flex items-center gap-2.5">
        <span class="grid size-9.5 shrink-0 place-items-center rounded-[10px] bg-accent-soft font-display text-sm font-extrabold text-accent">{{ $company->initials }}</span>
        <div class="min-w-0">
            <h3 class="truncate font-display text-base font-bold">
                {{-- De link bedekt de hele kaart (after:inset-0) --}}
                <a href="{{ route('companies.show', $company) }}" draggable="false" class="after:absolute after:inset-0 after:rounded-2xl focus:outline-none focus-visible:after:ring-2 focus-visible:after:ring-accent">{{ $company->name }}</a>
            </h3>
            <p class="truncate text-xs text-ink-soft">{{ $company->meta }}</p>
        </div>
    </header>

    <p class="text-[13px] leading-[19px] text-ink-muted">{{ $company->description ?: '-' }}</p>

    <div class="flex flex-wrap gap-1.5">
        @forelse ($company->technologies->sortBy('name')->take(4) as $technology)
            <x-tech-chip>{{ $technology->name }}</x-tech-chip>
        @empty
            <x-tech-chip>-</x-tech-chip>
        @endforelse
    </div>

    <footer class="flex items-center gap-2 border-t border-line pt-2.5">
        <span data-follow-up class="min-w-0 flex-1 truncate text-xs font-medium text-ink-soft">{{ $application->followUpLabel() }}</span>
        <x-status-badge :status="$status" />
    </footer>
</article>
