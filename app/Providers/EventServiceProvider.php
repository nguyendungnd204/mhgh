<?php

namespace App\Providers;

use App\Models\Event;
use App\Repositories\EventRepository;
use App\Services\EventService;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->bind(EventRepository::class, function ($app) {
            return new EventRepository(new Event());
        });

        $this->app->bind(EventService::class, function ($app) {
            return new EventService($app->make(EventRepository::class));
        });
    }

  
    public function boot(): void
    {
        //
    }
}