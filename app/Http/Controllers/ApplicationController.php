<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ApplicationController extends Controller
{
    /** Datums en notities van de sollicitatie opslaan. */
    public function update(Request $request, Company $company): RedirectResponse
    {
        Gate::authorize('update', $company);

        $validated = $request->validate([
            'sent_at' => ['nullable', 'date'],
            'follow_up_at' => ['nullable', 'date'],
            'notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $company->currentApplication()->fill($validated)->save();

        return back()->with('status', 'Sollicitatie opgeslagen.');
    }
}
