<?php

namespace App\Models;

use Database\Factories\CompanyFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'name', 'city', 'website', 'stagemarkt_url', 'focus', 'description',
    'contact_name', 'contact_email', 'contact_phone',
])]
class Company extends Model
{
    /** @use HasFactory<CompanyFactory> */
    use HasFactory;

    /** Het bedrijf hoort bij één gebruiker (jij). */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** Een bedrijf kan meerdere sollicitaties hebben. */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    /** Programmeertalen/frameworks die het bedrijf gebruikt. */
    public function technologies(): BelongsToMany
    {
        return $this->belongsToMany(Technology::class);
    }

    /**
     * Talen als tekst, bijv. "PHP, JavaScript".
     * Staan er geen talen bij het bedrijf? Dan "-".
     * Gebruik: $company->technology_list
     */
    protected function technologyList(): Attribute
    {
        return Attribute::get(function () {
            $names = $this->technologies->pluck('name')->sort()->implode(', ');

            return $names !== '' ? $names : '-';
        });
    }
}
