<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use App\Models\Technology;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class CompanyController extends Controller
{
    /** Overzicht van jouw bedrijven, met zoeken en filteren op taal. */
    public function index(Request $request): View
    {
        $search = $request->string('q')->trim()->toString();
        $techId = $request->integer('tech');

        $companies = $request->user()->companies()
            ->with(['technologies', 'latestApplication'])
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('city', 'like', "%{$search}%")
                        ->orWhere('focus', 'like', "%{$search}%");
                });
            })
            ->when($techId, function ($query, $techId) {
                $query->whereHas('technologies', fn ($q) => $q->whereKey($techId));
            })
            ->orderBy('name')
            ->get();

        return view('companies.index', [
            'companies' => $companies,
            'technologies' => Technology::orderBy('name')->get(),
            'search' => $search,
            'techId' => $techId,
        ]);
    }

    public function create(): View
    {
        return view('companies.create', [
            'company' => new Company,
            'technologies' => Technology::orderBy('name')->get(),
        ]);
    }

    public function store(CompanyRequest $request): RedirectResponse
    {
        $company = $request->user()->companies()->create(
            $request->safe()->except(['technologies', 'new_technologies'])
        );

        $this->syncTechnologies($company, $request);

        return redirect()->route('companies.index')
            ->with('status', "{$company->name} is toegevoegd.");
    }

    public function edit(Company $company): View
    {
        Gate::authorize('update', $company);

        return view('companies.edit', [
            'company' => $company->load('technologies'),
            'technologies' => Technology::orderBy('name')->get(),
        ]);
    }

    public function update(CompanyRequest $request, Company $company): RedirectResponse
    {
        Gate::authorize('update', $company);

        $company->update($request->safe()->except(['technologies', 'new_technologies']));

        $this->syncTechnologies($company, $request);

        return redirect()->route('companies.index')
            ->with('status', "{$company->name} is bijgewerkt.");
    }

    public function destroy(Company $company): RedirectResponse
    {
        Gate::authorize('delete', $company);

        $company->delete();

        return redirect()->route('companies.index')
            ->with('status', "{$company->name} is verwijderd.");
    }

    /**
     * Koppel de aangevinkte talen aan het bedrijf,
     * plus nieuwe talen die je zelf hebt getypt (gescheiden door komma's).
     */
    private function syncTechnologies(Company $company, CompanyRequest $request): void
    {
        $ids = collect($request->validated('technologies', []));

        $newNames = collect(explode(',', (string) $request->validated('new_technologies')))
            ->map(fn ($name) => trim($name))
            ->filter();

        foreach ($newNames as $name) {
            $ids->push(Technology::firstOrCreate(['name' => $name])->id);
        }

        $company->technologies()->sync($ids->unique()->all());
    }
}
