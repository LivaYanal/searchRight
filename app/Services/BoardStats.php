<?php

namespace App\Services;

use App\Enums\ApplicationStatus;
use App\Models\User;
use Illuminate\Support\Carbon;

/**
 * Berekent de vier cijfers bovenaan het bord.
 * Wordt gebruikt bij het laden van het bord én na elke sleepactie,
 * zodat de cijfers altijd kloppen met de database.
 */
class BoardStats
{
    /**
     * @return array{companies: int, sent: int, sentPercentage: int, interviews: int, followUps: int, nextInterview: ?Carbon}
     */
    public static function for(User $user): array
    {
        $companies = $user->companies()->with('latestApplication')->get();

        $statuses = $companies->map(fn ($company) => $company->currentStatus());
        $applications = $companies->pluck('latestApplication')->filter();

        $sent = $statuses->filter(fn (ApplicationStatus $status) => $status->isSent())->count();

        $weekFromNow = today()->addDays(7);

        $followUps = $applications->filter(fn ($application) => $application->follow_up_at !== null
            && $application->follow_up_at->lte($weekFromNow)
            && in_array($application->status, [ApplicationStatus::Sent, ApplicationStatus::Interview], true)
        )->count();

        $nextInterview = $applications
            ->filter(fn ($application) => $application->status === ApplicationStatus::Interview
                && $application->follow_up_at?->gte(today()))
            ->sortBy('follow_up_at')
            ->first()?->follow_up_at;

        return [
            'companies' => $companies->count(),
            'sent' => $sent,
            'sentPercentage' => $companies->count() ? (int) round($sent / $companies->count() * 100) : 0,
            'interviews' => $statuses->filter(fn (ApplicationStatus $status) => $status === ApplicationStatus::Interview)->count(),
            'followUps' => $followUps,
            'nextInterview' => $nextInterview,
        ];
    }
}
