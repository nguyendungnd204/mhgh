<?php

namespace App\Providers;

use App\Repositories\EventRepository;
use App\Services\EventService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->bind(EventRepository::class, EventRepository::class);
        
        $this->app->bind(EventService::class, EventService::class);
    }

 
    public function boot(): void
    {
        //
    }
}