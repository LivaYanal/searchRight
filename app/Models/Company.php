<?php

namespace App\Models;

use App\Enums\ApplicationStatus;
use Database\Factories\CompanyFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

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

    /** De meest recente sollicitatie (bepaalt de kolom op het bord). */
    public function latestApplication(): HasOne
    {
        return $this->hasOne(Application::class)->latestOfMany();
    }

    /** Programmeertalen/frameworks die het bedrijf gebruikt. */
    public function technologies(): BelongsToMany
    {
        return $this->belongsToMany(Technology::class);
    }

    /** Huidige sollicitatie, of een nieuwe (nog niet opgeslagen) als er nog geen is. */
    public function currentApplication(): Application
    {
        return $this->latestApplication ?? $this->applications()->make();
    }

    /** Huidige status; zonder sollicitatie is dat "te versturen". */
    public function currentStatus(): ApplicationStatus
    {
        return $this->latestApplication?->status ?? ApplicationStatus::ToSend;
    }

    /**
     * Talen als tekst, bijv. "PHP, JavaScript".
     * Staan er geen talen bij het bedrijf? Dan "-".
     */
    protected function technologyList(): Attribute
    {
        return Attribute::get(function () {
            $names = $this->technologies->pluck('name')->sort()->implode(', ');

            return $names !== '' ? $names : '-';
        });
    }

    /** Twee letters voor het logo-vakje, bijv. "Pixel Games" → "PG". */
    protected function initials(): Attribute
    {
        return Attribute::get(function () {
            $words = preg_split('/\s+/', trim($this->name)) ?: [];

            $initials = count($words) > 1
                ? Str::substr($words[0], 0, 1).Str::substr($words[1], 0, 1)
                : Str::substr($this->name, 0, 2);

            return Str::upper($initials);
        });
    }

    /** "Amsterdam · Gaming" (laat lege delen weg). */
    protected function meta(): Attribute
    {
        return Attribute::get(fn () => collect([$this->city, $this->focus])->filter()->implode(' · ') ?: '-');
    }
}
