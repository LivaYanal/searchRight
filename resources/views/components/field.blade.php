@props(['name', 'label', 'type' => 'text', 'value' => null, 'hint' => null])

<div {{ $attributes->only('class') }}>
    <label for="{{ $name }}" class="mb-1 block text-sm font-medium text-stone-700">{{ $label }}</label>
    <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}"
           value="{{ $type === 'password' ? '' : old($name, $value) }}"
           {{ $attributes->except('class')->merge([
               'class' => 'w-full rounded-lg border bg-white px-3 py-2 text-sm shadow-xs outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-600/20 '
                   .($errors->has($name) ? 'border-rose-400' : 'border-stone-300'),
           ]) }}>
    @if ($hint)
        <p class="mt-1 text-xs text-stone-500">{{ $hint }}</p>
    @endif
    @error($name)
        <p class="mt-1 text-xs text-rose-700">{{ $message }}</p>
    @enderror
</div>
