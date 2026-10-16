@props(['title', 'dark' => false])

<section {{ $attributes->merge(['class' => 'flex flex-col gap-4 rounded-2xl p-6 '.($dark ? 'keep-dark bg-ink text-surface' : 'border border-line bg-surface')]) }}>
    <h2 class="font-display text-lg font-bold {{ $dark ? 'text-lime' : '' }}">{{ $title }}</h2>
    {{ $slot }}
</section>
