<?php

namespace App\Http\Controllers;

use App\Enums\ApplicationStatus;
use App\Models\Company;
use App\Services\BoardStats;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class CompanyStatusController extends Controller
{
    /**
     * Status wijzigen. Werkt op twee manieren:
     * - slepen op het bord (JavaScript, antwoord in JSON)
     * - op een knop klikken op de detailpagina (gewoon formulier)
     */
    public function __invoke(Request $request, Company $company): JsonResponse|RedirectResponse
    {
        Gate::authorize('update', $company);

        $validated = $request->validate([
            'status' => ['required', Rule::enum(ApplicationStatus::class)],
        ]);

        $application = $company->currentApplication();
        $application->changeStatus(ApplicationStatus::from($validated['status']));
        $company->touch(); // bovenaan in de nieuwe kolom

        if ($request->expectsJson()) {
            return response()->json([
                'status' => $application->status->value,
                'label' => $application->status->label(),
                'badge' => Blade::render('<x-status-badge :status="$status" />', ['status' => $application->status]),
                'follow_up' => $application->followUpLabel(),
                // Nieuwe cijfers voor bovenaan het bord
                'stats' => view('board._stats', ['stats' => BoardStats::for($request->user())])->render(),
            ]);
        }

        return back()->with('status', "Status van {$company->name} is nu “{$application->status->label()}”.");
    }
}
