<div data-stats class="mt-7 grid grid-cols-2 gap-4 xl:grid-cols-4">
    <div class="rounded-2xl border border-line bg-surface px-5 py-4.5">
        <p class="text-[13px] font-medium text-ink-muted">Bedrijven in je lijst</p>
        <p class="font-display text-4xl leading-10 font-extrabold">{{ $stats['companies'] }}</p>
        <p class="text-xs text-ink-soft">{{ $stats['companies'] ? 'Blijf toevoegen!' : 'Voeg je eerste bedrijf toe' }}</p>
    </div>
    <div class="rounded-2xl border border-line bg-surface px-5 py-4.5">
        <p class="text-[13px] font-medium text-ink-muted">Sollicitaties verstuurd</p>
        <p class="font-display text-4xl leading-10 font-extrabold">{{ $stats['sent'] }}</p>
        <p class="text-xs text-ink-soft">{{ $stats['sentPercentage'] }}% van je lijst</p>
    </div>
    <div class="rounded-2xl border border-line bg-surface px-5 py-4.5">
        <p class="text-[13px] font-medium text-ink-muted">Gesprekken</p>
        <p class="font-display text-4xl leading-10 font-extrabold">{{ $stats['interviews'] }}</p>
        <p class="text-xs text-ink-soft">
            {{ $stats['nextInterview'] ? 'Volgende: '.$stats['nextInterview']->translatedFormat('D j M') : 'Nog geen gepland' }}
        </p>
    </div>
    <div class="keep-dark rounded-2xl bg-ink px-5 py-4.5">
        <p class="text-[13px] font-medium text-ink-soft">Opvolgen deze week</p>
        <p class="font-display text-4xl leading-10 font-extrabold text-lime">{{ $stats['followUps'] }}</p>
        <p class="text-xs text-ink-soft">{{ $stats['followUps'] ? 'Mail ze vandaag nog!' : 'Alles bijgewerkt ✓' }}</p>
    </div>
</div>
