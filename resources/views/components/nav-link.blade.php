@props(['href', 'active' => false, 'icon', 'count' => null])

<a href="{{ $href }}" @if ($active) aria-current="page" @endif
   class="flex items-center gap-3 rounded-[10px] px-3 py-2.5 transition {{ $active ? 'bg-white/10 font-semibold text-surface' : 'font-medium text-ink-soft hover:bg-white/5 hover:text-surface' }}">
    <x-icon :name="$icon" class="{{ $active ? 'text-lime' : '' }}" />
    <span class="flex-1">{{ $slot }}</span>
    @if ($count !== null)
        <span class="font-mono text-[11px] {{ $active ? 'text-lime' : '' }}">{{ $count }}</span>
    @endif
</a>
