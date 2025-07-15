<?php

namespace App\Providers;

use App\Repositories\EventRepository;
use App\Repositories\NewsRepository;
use App\Repositories\UserRepository;
use App\Services\AuthService;
use App\Services\EventService;
use App\Services\NewsService;
use Illuminate\Support\ServiceProvider;
use App\Services\UserService;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->bind(UserRepository::class, UserRepository::class);
        $this->app->bind(AuthService::class, AuthService::class);
        $this->app->bind(UserService::class, UserService::class);

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