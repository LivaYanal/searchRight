@csrf

<section class="rounded-xl border border-stone-200 bg-white p-6">
    <h2 class="font-semibold">Bedrijf</h2>
    <div class="mt-4 grid gap-4 sm:grid-cols-2">
        <x-field name="name" label="Naam *" :value="$company->name" required class="sm:col-span-2" />
        <x-field name="city" label="Plaats" :value="$company->city" />
        <x-field name="focus" label="Focus" :value="$company->focus" list="focus-options"
                 hint="Bijv. Webdevelopment of Gaming" />
        <datalist id="focus-options">
            @foreach (['Webdevelopment', 'Gaming', 'Apps', 'Software op maat', 'E-commerce', 'Data & AI'] as $option)
                <option value="{{ $option }}">
            @endforeach
        </datalist>
        <x-field name="description" label="Korte omschrijving" :value="$company->description" maxlength="255"
                 hint="Eén zin uit hun bio, zodat je weet wat ze doen." class="sm:col-span-2" />
        <x-field name="website" label="Website" :value="$company->website" placeholder="www.bedrijf.nl" />
        <x-field name="stagemarkt_url" label="Link op stagemarkt.nl" :value="$company->stagemarkt_url" />
    </div>
</section>

<section class="rounded-xl border border-stone-200 bg-white p-6">
    <h2 class="font-semibold">Programmeertalen</h2>
    <p class="mt-1 text-sm text-stone-600">Vink aan wat in hun bio of vacature staat. Staat er niets? Laat leeg, dan zie je "-".</p>

    @php
        $selected = collect(old('technologies', $company->technologies->pluck('id')->all()))
            ->map(fn ($id) => (int) $id);
    @endphp

    <div class="mt-4 flex flex-wrap gap-2">
        @foreach ($technologies as $technology)
            <label class="cursor-pointer">
                <input type="checkbox" name="technologies[]" value="{{ $technology->id }}" class="peer sr-only"
                       @checked($selected->contains($technology->id))>
                <span class="inline-block rounded-md border border-stone-300 px-2.5 py-1 font-mono text-xs text-stone-700 transition peer-checked:border-teal-700 peer-checked:bg-teal-700 peer-checked:text-white peer-focus-visible:ring-2 peer-focus-visible:ring-teal-600/40">
                    {{ $technology->name }}
                </span>
            </label>
        @endforeach
    </div>

    <x-field name="new_technologies" label="Andere talen" class="mt-4"
             hint="Staat een taal er niet bij? Typ ze hier, gescheiden door komma's (bijv. Rust, Flutter)." />
</section>

<section class="rounded-xl border border-stone-200 bg-white p-6">
    <h2 class="font-semibold">Contactpersoon</h2>
    <div class="mt-4 grid gap-4 sm:grid-cols-3">
        <x-field name="contact_name" label="Naam" :value="$company->contact_name" />
        <x-field name="contact_email" label="E-mail" type="email" :value="$company->contact_email" />
        <x-field name="contact_phone" label="Telefoon" type="tel" :value="$company->contact_phone" />
    </div>
</section>
