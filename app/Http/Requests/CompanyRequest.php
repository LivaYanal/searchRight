<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class CompanyRequest extends FormRequest
{
    /** Vaste keuzes voor "focus" (in het formulier als knopjes). */
    public const FOCUS_OPTIONS = ['Webdevelopment', 'Gaming', 'Apps', 'Software op maat', 'E-commerce', 'Data & AI'];

    public function authorize(): bool
    {
        return true; // rechten worden gecheckt met CompanyPolicy in de controller
    }

    protected function prepareForValidation(): void
    {
        // Typ je "www.bedrijf.nl"? Dan maken we er "https://www.bedrijf.nl" van.
        foreach (['website', 'stagemarkt_url'] as $field) {
            $value = trim((string) $this->input($field));

            if ($value !== '' && ! Str::startsWith($value, ['http://', 'https://'])) {
                $this->merge([$field => 'https://'.$value]);
            }
        }

        // Zelf een andere focus getypt? Die gaat voor het gekozen knopje.
        $other = trim((string) $this->input('focus_other'));

        if ($other !== '') {
            $this->merge(['focus' => $other]);
        }
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'stagemarkt_url' => ['nullable', 'url', 'max:255'],
            'focus' => ['nullable', 'string', 'max:100'],
            'focus_other' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:255'],
            'contact_name' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'technologies' => ['nullable', 'array'],
            'technologies.*' => ['integer', 'exists:technologies,id'],
            'new_technologies' => ['nullable', 'string', 'max:255'],
        ];
    }

    /** Alleen de velden die echt in de companies-tabel staan. */
    public function companyData(): array
    {
        return $this->safe()->except(['technologies', 'new_technologies', 'focus_other']);
    }
}
