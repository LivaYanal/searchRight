@props(['status'])

<span data-badge {{ $attributes->merge(['class' => 'inline-flex shrink-0 items-center gap-1.5 rounded-full py-1 pr-2.5 pl-2 text-xs font-semibold '.$status->badgeClasses()]) }}>
    <span class="size-1.5 rounded-full {{ $status->dotClass() }}"></span>
    {{ $status->label() }}
</span>
