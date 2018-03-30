<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\EventLogInterface;
use App\Repositories\Eloquent\EventLogRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->bind(EventLogInterface::class, EventLogRepository::class);
    }
}
