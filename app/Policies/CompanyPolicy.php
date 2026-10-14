<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;

/**
 * Bepaalt wie wat mag met een bedrijf.
 * Je mag alleen je eigen bedrijven bewerken en verwijderen.
 */
class CompanyPolicy
{
    public function update(User $user, Company $company): bool
    {
        return $user->id === $company->user_id;
    }

    public function delete(User $user, Company $company): bool
    {
        return $user->id === $company->user_id;
    }
}
