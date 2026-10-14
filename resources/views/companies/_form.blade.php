@use('App\Http\Requests\CompanyRequest')

@csrf

@php
    $currentFocus = old('focus', $company->focus);
    $isCustomFocus = $currentFocus && ! in_array($currentFocus, CompanyRequest::FOCUS_OPTIONS, true);
    $selected = collect(old('technologies', $company->technologies->pluck('id')->all()))->map(fn ($id) => (int) $id);
@endphp

<div class="grid gap-4 sm:grid-cols-2">
    <x-field name="name" label="Naam *" :value="$company->name" required />
    <x-field name="city" label="Plaats" :value="$company->city" placeholder="Amsterdam" />
</div>

{{-- Focus als knopjes --}}
<fieldset>
    <legend class="mb-2 text-[13px] font-medium">Focus</legend>
    <input type="hidden" name="focus" value="">
    <div class="flex flex-wrap gap-2">
        @foreach (CompanyRequest::FOCUS_OPTIONS as $option)
            <label class="cursor-pointer">
                <input type="radio" name="focus" value="{{ $option }}" class="peer sr-only" @checked($currentFocus === $option)>
                <span class="inline-block rounded-full border border-line bg-surface px-3 py-1.5 text-[13px] font-medium text-ink-muted transition peer-checked:border-ink peer-checked:bg-ink peer-checked:font-semibold peer-checked:text-lime peer-focus-visible:ring-2 peer-focus-visible:ring-accent/40">
                    {{ $option }}
                </span>
            </label>
        @endforeach
    </div>
    <x-field name="focus_other" label="Of typ zelf een focus" class="mt-3" :value="$isCustomFocus ? $currentFocus : null" placeholder="bijv. Cybersecurity" />
</fieldset>

{{-- Korte omschrijving met teller --}}
<div>
    <div class="mb-1.5 flex items-center justify-between">
        <label for="description" class="text-[13px] font-medium">Korte omschrijving</label>
        <span id="description-counter" class="font-mono text-[11px] text-ink-soft"></span>
    </div>
    <input id="description" name="description" maxlength="255" data-counter="description-counter"
           value="{{ old('description', $company->description) }}" placeholder="Wat doet het bedrijf, in één zin?"
           class="w-full rounded-[10px] border border-line bg-surface px-3 py-2.5 text-sm outline-none placeholder:text-ink-soft focus:border-accent focus:ring-2 focus:ring-accent/20">
    <p class="mt-1 text-xs text-ink-soft">Eén zin uit hun bio, zodat je weet wat ze doen.</p>
    @error('description') <p class="mt-1 text-xs font-medium text-st-rejected">{{ $message }}</p> @enderror
</div>

{{-- Talen als aanklikbare chips --}}
<fieldset>
    <legend class="mb-2 flex w-full items-center justify-between text-[13px] font-medium">
        Programmeertalen <span class="font-mono text-[11px] font-normal text-ink-soft">geen? dan "-"</span>
    </legend>
    <div class="flex flex-wrap gap-1.5">
        @foreach ($technologies as $technology)
            <label class="cursor-pointer">
                <input type="checkbox" name="technologies[]" value="{{ $technology->id }}" class="peer sr-only"
                       @checked($selected->contains($technology->id))>
                <span class="inline-block rounded-md border border-line bg-paper px-2.5 py-1 font-mono text-xs text-ink-muted transition peer-checked:border-accent peer-checked:bg-accent peer-checked:text-surface peer-focus-visible:ring-2 peer-focus-visible:ring-accent/40">
                    {{ $technology->name }}
                </span>
            </label>
        @endforeach
    </div>
    <x-field name="new_technologies" label="Andere talen" class="mt-3" placeholder="bijv. Rust, Flutter"
             hint="Staat een taal er niet bij? Typ ze hier, gescheiden door komma's." />
</fieldset>

<div class="grid gap-4 sm:grid-cols-2">
    <x-field name="website" label="Website" :value="$company->website" placeholder="www.bedrijf.nl" />
    <x-field name="stagemarkt_url" label="Link op stagemarkt.nl" :value="$company->stagemarkt_url" placeholder="stagemarkt.nl/…" />
</div>

<details class="group rounded-[10px] border border-line px-4 py-3" @if ($company->contact_name || $errors->hasAny(['contact_name', 'contact_email', 'contact_phone'])) open @endif>
    <summary class="cursor-pointer text-[13px] font-semibold">Contactpersoon <span class="font-normal text-ink-soft">(optioneel)</span></summary>
    <div class="mt-3 grid gap-4 sm:grid-cols-3">
        <x-field name="contact_name" label="Naam" :value="$company->contact_name" />
        <x-field name="contact_email" label="E-mail" type="email" :value="$company->contact_email" />
        <x-field name="contact_phone" label="Telefoon" type="tel" :value="$company->contact_phone" />
    </div>
</details>
