@props(['variant' => 'primary', 'href' => null])

@php
    $classes = 'inline-flex items-center justify-center gap-2 rounded-lg px-4 py-2 text-sm font-medium transition focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600/40 '
        .match ($variant) {
            'primary' => 'bg-teal-700 text-white hover:bg-teal-800',
            'secondary' => 'border border-stone-300 bg-white text-stone-700 hover:bg-stone-100',
            'danger' => 'border border-rose-200 bg-white text-rose-700 hover:bg-rose-50',
        };
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@else
    <button {{ $attributes->merge(['class' => $classes, 'type' => 'submit']) }}>{{ $slot }}</button>
@endif
