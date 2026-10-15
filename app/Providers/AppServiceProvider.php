<?php

namespace App\Providers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Online (productie) altijd https-links
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // Datums in het Nederlands, bijv. "16 okt"
        Carbon::setLocale(config('app.locale'));

        // Aftelteller in de zijbalk: hoeveel dagen tot je stage begint?
        View::composer('components.layout', function ($view) {
            $start = Carbon::parse(config('searchright.internship_start'));

            $view->with([
                'internshipStart' => $start,
                'daysUntilInternship' => max(0, (int) today()->diffInDays($start, false)),
            ]);
        });
    }
}
