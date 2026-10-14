<?php

namespace App\Http\Controllers;

use App\Enums\ApplicationStatus;
use App\Services\BoardStats;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BoardController extends Controller
{
    /** Het Kanban-bord: één kolom per status. */
    public function __invoke(Request $request): View
    {
        $companies = $request->user()->companies()
            ->with(['technologies', 'latestApplication'])
            ->latest('updated_at')
            ->get();

        $columns = collect(ApplicationStatus::cases())->mapWithKeys(fn (ApplicationStatus $status) => [
            $status->value => $companies->filter(fn ($company) => $company->currentStatus() === $status),
        ]);

        return view('board.index', [
            'columns' => $columns,
            'stats' => BoardStats::for($request->user()),
        ]);
    }
}
