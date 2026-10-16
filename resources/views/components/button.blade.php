@props(['variant' => 'primary', 'href' => null])

@php
    $classes = 'inline-flex items-center justify-center gap-2 rounded-[10px] px-4 py-2.5 text-sm font-semibold transition focus:outline-none focus-visible:ring-2 focus-visible:ring-accent/40 '
        .match ($variant) {
            'primary' => 'bg-accent text-white hover:bg-[#4a2ee0] dark:hover:bg-[#7a60ff]',
            'secondary' => 'border border-line bg-surface text-ink hover:bg-paper',
            'dark' => 'keep-dark bg-ink text-lime hover:bg-black',
            'danger' => 'border border-st-rejected/30 bg-surface text-st-rejected hover:bg-st-rejected-soft',
        };
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@else
    <button {{ $attributes->merge(['class' => $classes, 'type' => 'submit']) }}>{{ $slot }}</button>
@endif
