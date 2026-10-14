<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class CompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // rechten worden gecheckt met CompanyPolicy in de controller
    }

    /** Typ je "www.bedrijf.nl"? Dan maken we er "https://www.bedrijf.nl" van. */
    protected function prepareForValidation(): void
    {
        foreach (['website', 'stagemarkt_url'] as $field) {
            $value = trim((string) $this->input($field));

            if ($value !== '' && ! Str::startsWith($value, ['http://', 'https://'])) {
                $this->merge([$field => 'https://'.$value]);
            }
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
            'description' => ['nullable', 'string', 'max:255'],
            'contact_name' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'technologies' => ['nullable', 'array'],
            'technologies.*' => ['integer', 'exists:technologies,id'],
            'new_technologies' => ['nullable', 'string', 'max:255'],
        ];
    }
}
