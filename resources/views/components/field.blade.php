@props(['name', 'label', 'type' => 'text', 'value' => null, 'hint' => null])

<div {{ $attributes->only('class') }}>
    <label for="{{ $name }}" class="mb-1.5 block text-[13px] font-medium text-ink">{{ $label }}</label>
    <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}"
           value="{{ $type === 'password' ? '' : old($name, $value) }}"
           {{ $attributes->except('class')->merge([
               'class' => 'w-full rounded-[10px] border bg-surface px-3 py-2.5 text-sm outline-none placeholder:text-ink-soft focus:border-accent focus:ring-2 focus:ring-accent/20 '
                   .($errors->has($name) ? 'border-st-rejected' : 'border-line'),
           ]) }}>
    @if ($hint)
        <p class="mt-1 text-xs text-ink-soft">{{ $hint }}</p>
    @endif
    @error($name)
        <p class="mt-1 text-xs font-medium text-st-rejected">{{ $message }}</p>
    @enderror
</div>
