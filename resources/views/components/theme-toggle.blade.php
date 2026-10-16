<button type="button" data-theme-toggle aria-label="Donkere modus aan/uit" title="Thema wisselen"
    {{ $attributes->merge(['class' => 'theme-toggle grid size-9 shrink-0 place-items-center rounded-full text-ink-soft transition hover:bg-white/10 hover:text-lime focus:outline-none focus-visible:ring-2 focus-visible:ring-accent/40']) }}>
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
         stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <mask id="theme-moon-{{ $id = uniqid() }}">
            <rect x="0" y="0" width="24" height="24" fill="white" />
            <circle class="moon-cut" cx="30" cy="0" r="7" fill="black" />
        </mask>
        <circle class="sun-core" cx="12" cy="12" r="5" fill="currentColor" stroke="none" mask="url(#theme-moon-{{ $id }})" />
        <g class="sun-rays">
            <path d="M12 1.5v2M12 20.5v2M4.6 4.6l1.4 1.4M18 18l1.4 1.4M1.5 12h2M20.5 12h2M4.6 19.4 6 18M18 6l1.4-1.4" />
        </g>
    </svg>
</button>
