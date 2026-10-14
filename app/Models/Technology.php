<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['name'])]
class Technology extends Model
{
    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class);
    }
}
