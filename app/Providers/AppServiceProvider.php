<?php

namespace App\Providers;

use App\Repositories\EventRepository;
use App\Repositories\NewsRepository;
use App\Services\EventService;
use App\Services\NewsService;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->bind(EventRepository::class, EventRepository::class);
        $this->app->bind(EventService::class, EventService::class);

        $this->app->bind(NewsRepository::class, NewsRepository::class);
        $this->app->bind(NewsService::class, NewsService::class);
    }

 
    public function boot(): void
    {
        //
    }
}