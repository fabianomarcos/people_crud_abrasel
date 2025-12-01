<?php

namespace App\Providers;

use App\Application\Person\Presenters\JsonPersonPresenter as PresentersJsonPersonPresenter;
use App\Application\Person\Presenters\PersonPresenter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(PersonPresenter::class, PresentersJsonPersonPresenter::class);
    }

    public function boot(): void
    {
        //
    }
}
